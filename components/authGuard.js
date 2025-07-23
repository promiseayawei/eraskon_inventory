(function () {
  const currentPath = window.location.pathname.split('/').pop();

  const pagePermissions = {
    'index.html':        ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'approve.html':      ['admin', 'finance'],
    'category.html':     ['admin', 'sales', 'inventory', 'warehouse'],
    'customer.html':     ['admin', 'sales', 'finance'],
    'invoiced.html':     ['admin', 'sales', 'finance'],
    'logistics.html':    ['admin', 'sales', 'warehouse'],
    'order-invoice.html':['admin', 'sales', 'finance'],
    'product.html':      ['admin', 'inventory', 'warehouse'],
    'product-variant.html': ['admin', 'inventory', 'warehouse'],
    'report.html':       ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'roles.html':        ['admin'],
    'sale.html':         ['admin', 'sales', 'finance'],
    'shipping.html':     ['admin', 'sales', 'warehouse'],
    'stats.html':        ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'stock.html': ['admin', 'inventory', 'warehouse'],
    'store.html':        ['admin', 'sales', 'inventory', 'warehouse'],
    'user.html':         ['admin', 'finance'],
    'warehouse.html':    ['admin', 'inventory', 'warehouse'],
    'welcome.html':      ['admin', 'sales', 'inventory', 'warehouse', 'finance']
  };

  const userRole = localStorage.getItem('role');
  const allowedRoles = pagePermissions[currentPath];

  window.addEventListener("beforeunload", () => {
    localStorage.setItem("previousPage", window.location.href);
  });

  if (allowedRoles && !allowedRoles.includes(userRole)) {
    const previous = localStorage.getItem('previousPage');
    const pageName = currentPath || "this page";
    const message = `Access Denied: Your role <b>${userRole || 'unknown'}</b> is not permitted to view <b>${pageName}</b>.`;

    showAlert({
      title: "Unauthorized Access",
      message: message,
      confirmText: "Go Back",
      cancelText: "Exit",
      onConfirm: () => {
        if (previous && previous !== window.location.href) {
          window.location.href = previous;
        }
      },
      onCancel: () => {
        if (previous && previous !== window.location.href) {
          window.location.href = previous;
        }
      }
    });
  }

  // Add this to your showAlert implementation (or wrap your alert logic)
  function showAlert({ title, message, confirmText, cancelText, onConfirm, onCancel }) {
    // --- Blurry Overlay ---
    const blur = document.createElement('div');
    blur.className = 'auth-guard-blur-overlay';
    document.body.appendChild(blur);

    // --- Simple Alert Modal ---
    const modal = document.createElement('div');
    modal.className = 'auth-guard-modal';
    modal.innerHTML = `
      <div class="auth-guard-modal-content">
        <h2>${title || 'Alert'}</h2>
        <div class="auth-guard-modal-message">${message || ''}</div>
        <div class="auth-guard-modal-actions">
          <button id="authGuardConfirm">${confirmText || 'OK'}</button>
          <button id="authGuardCancel">${cancelText || 'Cancel'}</button>
        </div>
      </div>
    `;
    document.body.appendChild(modal);

    // --- Cleanup function ---
    function cleanup() {
      blur.remove();
      modal.remove();
    }

    // --- Button handlers ---
    document.getElementById('authGuardConfirm').onclick = () => {
      cleanup();
      if (onConfirm) onConfirm();
    };
    document.getElementById('authGuardCancel').onclick = () => {
      cleanup();
      if (onCancel) onCancel();
    };
  }

  // --- Blurry Overlay & Modal Styles ---
  const style = document.createElement('style');
  style.innerHTML = `
    .auth-guard-blur-overlay {
      position: fixed;
      z-index: 9998;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(30, 41, 59, 0.25);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
    }
    .auth-guard-modal {
      position: fixed;
      z-index: 10000;
      top: 0; left: 0; right: 0; bottom: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .auth-guard-modal-content {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 8px 32px #0002;
      padding: 32px 28px 24px 28px;
      max-width: 90vw;
      min-width: 320px;
      text-align: center;
      animation: fadeInAuthGuard 0.3s;
    }
    .auth-guard-modal-content h2 {
      margin-top: 0;
      color: #ef4444;
      font-size: 1.4em;
    }
    .auth-guard-modal-message {
      margin: 18px 0 24px 0;
      color: #334155;
      font-size: 1.1em;
    }
    .auth-guard-modal-actions {
      display: flex;
      justify-content: center;
      gap: 18px;
    }
    .auth-guard-modal-actions button {
      padding: 8px 22px;
      border-radius: 6px;
      border: none;
      font-size: 1em;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.2s;
    }
    #authGuardConfirm { background: #2563eb; color: #fff; }
    #authGuardCancel { background: #ef4444; color: #fff; }
    #authGuardConfirm:hover { background: #1d4ed8; }
    #authGuardCancel:hover { background: #b91c1c; }
    @keyframes fadeInAuthGuard {
      from { opacity: 0; transform: translateY(-20px);}
      to { opacity: 1; transform: translateY(0);}
    }
  `;
  document.head.appendChild(style);
})();
