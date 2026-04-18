document.addEventListener('DOMContentLoaded', () => {
  const token = localStorage.getItem('token');
  const BASE_URL = window.BASE_URL;
  const STOCK_MOVEMENT_API = `${BASE_URL}/stock-movement`;
  const LOGISTICS_API = `${BASE_URL}/logistics`;
  const SHIPPING_API = `${BASE_URL}/shipping`;

  let selectedMovementId = null;
  let logisticsList = [];

  document.querySelectorAll('.shipping-tab-btn').forEach(btn => {
    btn.onclick = () => {
      document.querySelectorAll('.shipping-tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.shipping-tab-content').forEach(tab => tab.classList.remove('active'));
      const tabId = btn.dataset.tab;
      const tabContent = document.getElementById(tabId);
      if (tabContent) {
        btn.classList.add('active');
        tabContent.classList.add('active');
      }
    };
  });

  async function fetchPendingShipments() {
    try {
      const res = await fetch(`${SHIPPING_API}?status=Pending`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const data = await res.json();
      renderPendingTable(data);
    } catch {
      document.getElementById('pendingShippingBody').innerHTML = '<tr><td colspan="7">Error loading data</td></tr>';
    }
  }

  function renderPendingTable(data) {
    const body = document.getElementById('pendingShippingBody');
    if (!data.length) {
      body.innerHTML = '<tr><td colspan="7">No pending shipments</td></tr>';
      return;
    }
    body.innerHTML = data.map(shipment => `
      <tr data-id="${shipment._id}">
        <td>${shipment._id}</td>
        <td>${shipment.orderCode}</td>
        <td>${shipment.customer?.name || '-'}</td>
        <td>${shipment.deliveryAddress}</td>
        <td>${new Date(shipment.createdAt).toLocaleDateString()}</td>
        <td>${shipment.status}</td>
        <td>
          <button class="shipping-action-btn ship">Mark as Shipped</button>
          <button class="shipping-action-btn cancel">Cancel</button>
          <button class="shipping-action-btn" onclick="printSingleShipment(${JSON.stringify(shipment).replace(/"/g, '&quot;')})">🖨️</button>
        </td>
      </tr>
    `).join('');
    attachStatusButtons();
  }

  function attachStatusButtons() {
    document.querySelectorAll('.shipping-action-btn.ship').forEach(btn => {
      btn.onclick = () => {
        const id = btn.closest('tr').dataset.id;
        updateShippingStatus(id, 'In Transit');
      };
    });
    document.querySelectorAll('.shipping-action-btn.cancel').forEach(btn => {
      btn.onclick = () => {
        const id = btn.closest('tr').dataset.id;
        updateShippingStatus(id, 'Cancelled');
      };
    });
  }

  async function updateShippingStatus(id, status) {
    try {
      await fetch(`${SHIPPING_API}/${id}/status`, {
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status })
      });
      fetchPendingShipments();
    } catch {
      alert('Error updating status');
    }
  }

  async function fetchStockMovements() {
    try {
      const res = await fetch(STOCK_MOVEMENT_API, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const data = await res.json();
      renderStockMovementTable(data);
    } catch {
      document.getElementById('stockMovementTbody').innerHTML = '<tr><td colspan="10">Error loading stock movement</td></tr>';
    }
  }

  function renderStockMovementTable(movements) {
    const tbody = document.getElementById('stockMovementTbody');
    if (!movements.length) {
      tbody.innerHTML = '<tr><td colspan="10">No stock movement records found.</td></tr>';
      return;
    }
    tbody.innerHTML = movements.map(m => `
      <tr>
        <td>${m._id || '-'}</td>
        <td>${m.productVariant?.name || '-'}</td>
        <td>${m.quantity || '-'}</td>
        <td>${m.type || '-'}</td>
        <td>${m.warehouse?.name || '-'}</td>
        <td>${m.destinationWarehouse?.name || '-'}</td>
        <td>${m.createdBy?.name || '-'}</td>
        <td>${m.createdLog || '-'}</td>
        <td>${m.approvedLog || '-'}</td>
        <td><button onclick="openLogisticsModal('${m._id}')">Assign Logistics</button></td>
      </tr>
    `).join('');
  }

  async function fetchLogisticsPartners() {
    try {
      const res = await fetch(LOGISTICS_API, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const data = await res.json();
      logisticsList = data;
      const select = document.getElementById('logisticsSelect');
      select.innerHTML = `<option value="">-- Select Partner --</option>` +
        logisticsList.map(l => `<option value="${l._id}">${l.provider} | ${l.contact} | ${l.serviceArea}</option>`).join('');
    } catch {
      alert('Failed to load logistics partners');
    }
  }

  async function openLogisticsModal(movementId) {
    selectedMovementId = movementId;
    await fetchLogisticsPartners();
    document.getElementById('logisticsModal').style.display = 'flex';
  }

  function closeLogisticsModal() {
    selectedMovementId = null;
    document.getElementById('logisticsModal').style.display = 'none';
  }

  document.getElementById('assignLogisticsConfirm').onclick = async () => {
    const selectedId = document.getElementById('logisticsSelect').value;
    if (!selectedId || !selectedMovementId) return;
    try {
      await fetch(`${STOCK_MOVEMENT_API}/${selectedMovementId}/assign-logistics`, {
        method: 'PUT',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ logisticsId: selectedId })
      });

      await fetch(`${SHIPPING_API}`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          movementId: selectedMovementId,
          logisticsId: selectedId,
          status: 'Pending'
        })
      });

      closeLogisticsModal();
      fetchStockMovements();
      fetchPendingShipments();
    } catch {
      alert('Failed to assign logistics or create shipping');
    }
  };

  // Print entire pending shipment table
  window.printPendingShipments = function () {
    const table = document.querySelector('#pendingShippingTab table');
    if (!table) return;
    const printWindow = window.open('', '', 'width=900,height=700');
    printWindow.document.write(`
      <html>
        <head>
          <title>Print - Pending Shipments</title>
          <style>
            body { font-family: Arial, sans-serif; padding: 20px; color: #222; }
            h2 { text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            th { background: #f3f3f3; color: #2563eb; }
          </style>
        </head>
        <body>
          <h2>Pending Shipments</h2>
          ${table.outerHTML}
        </body>
      </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
      printWindow.print();
      printWindow.close();
    }, 500);
  };

  // Print single shipment
  window.printSingleShipment = function (shipment) {
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write(`
      <html>
        <head>
          <title>Shipment #${shipment._id}</title>
          <style>
            body { font-family: Arial, sans-serif; padding: 20px; color: #222; }
            h2 { text-align: center; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            td { padding: 10px; border-bottom: 1px solid #ddd; }
          </style>
        </head>
        <body>
          <h2>Shipping Record</h2>
          <table>
            <tr><td><strong>Shipment ID:</strong></td><td>${shipment._id}</td></tr>
            <tr><td><strong>Order Code:</strong></td><td>${shipment.orderCode}</td></tr>
            <tr><td><strong>Customer:</strong></td><td>${shipment.customer?.name || '-'}</td></tr>
            <tr><td><strong>Address:</strong></td><td>${shipment.deliveryAddress}</td></tr>
            <tr><td><strong>Status:</strong></td><td>${shipment.status}</td></tr>
            <tr><td><strong>Date:</strong></td><td>${new Date(shipment.createdAt).toLocaleDateString()}</td></tr>
          </table>
        </body>
      </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
      printWindow.print();
      printWindow.close();
    }, 500);
  };

  // Init
  fetchPendingShipments();
  fetchStockMovements();
});
