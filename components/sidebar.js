// Ensure user is logged in
(function () {
  const name = localStorage.getItem('name');
  const role = localStorage.getItem('role');
  if (!name || !role) {
    window.location.href = 'index.html';
    return;
  }
})();

// Sidebar UI
document.write(`
  <nav class="sidebar">
    <div class="menu_content">
      <ul class="menu_items">
        <li class="item user_info-animated">
          <div class="nav_link submenu_item"><span class="navlink"><div><strong>Name:</strong> <span id="sidebarUserName">-</span></div></span></div>
          <div class="nav_link submenu_item"><span class="navlink"><div><strong>Role:</strong> <span id="sidebarUserRole">-</span></div></span></div>
          <div class="nav_link submenu_item"><span class="navlink"><div><strong>Warehouse:</strong> <span id="sidebarUserWarehouse">-</span></div></span></div>
        </li>

        <!-- DYNAMIC SECTIONS -->
        <li class="item dashboard-section">
          <div class="nav_link submenu_item toggle-submenu">
            <span class="navlink_icon"><i class="bx bx-home-alt"></i></span>
            <span class="navlink">Dashboard</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu dashboard-links"></ul>
        </li>

        <li class="item admin-section">
          <div class="nav_link submenu_item toggle-submenu">
            <span class="navlink_icon"><i class="bx bx-grid-alt"></i></span>
            <span class="navlink">Admin</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu admin-links"></ul>
        </li>
      </ul>

      <ul class="menu_items editor-section"></ul>

      <!-- Bottom -->
      <div class="sidebar-actions">
        <div id="logoutBtn" class="bottom" style="cursor:pointer; border-top:1px solid #eee; padding-top:12px;">
          <span>Logout</span><i class='bx bx-power-off'></i>
        </div>
      </div>
      <div class="bottom_content">
        <div class="bottom expand_sidebar"><span>Expand</span><i class='bx bx-log-in'></i></div>
        <div class="bottom collapse_sidebar"><span>Collapse</span><i class='bx bx-log-out'></i></div>
      </div>
    </div>
  </nav>
`);

const style = document.createElement('style');
style.innerHTML = `
.user_info-animated {
  border-bottom: 1px solid #e5e7eb;
  margin-bottom: 12px;
  padding-bottom: 10px;
}
.user_info-animated { animation: fadeInUserInfo 0.7s ease; transition: background 0.3s; }
@keyframes fadeInUserInfo {
  from { opacity: 0; transform: translateY(-10px);}
  to { opacity: 1; transform: translateY(0);}
}
.sidebar-actions { margin-top: 24px; margin-bottom: 8px; }
#logoutBtn { color: #e53e3e; font-weight: 600; }

a.nav_link.active { background-color: #e6f0ff; font-weight: bold; color: #4282ea; }

ul.submenu { display: none; padding-left: 1rem; }
ul.submenu.open { display: block; }
.toggle-submenu { cursor: pointer; user-select: none; }

.nav_link.sublink {
  margin-left: 0 !important;
  padding-left: 0.5rem;
  display: flex;
  align-items: center;
  gap: 8px;
}
.navlink_icon {
  margin-right: 4px;
}
ul.submenu .nav_link.sublink {
  padding-left: 1.2rem;
}
`;
document.head.appendChild(style);

// Capitalize helper
function capitalizeWords(str) {
  if (!str) return '-';
  return String(str).replace(/\b\w/g, c => c.toUpperCase());
}

// On DOM Ready
document.addEventListener('DOMContentLoaded', () => {
  const role = localStorage.getItem('role');
  const name = localStorage.getItem('name');
  let warehouse = localStorage.getItem('warehouse');
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  if (user?.warehouse?.name) warehouse = user.warehouse.name;

  document.getElementById('sidebarUserName').textContent = capitalizeWords(name);
  document.getElementById('sidebarUserRole').textContent = capitalizeWords(role);
  document.getElementById('sidebarUserWarehouse').textContent = capitalizeWords(warehouse);

  document.getElementById('logoutBtn')?.addEventListener('click', () => {
    localStorage.clear();
    window.location.href = 'index.html';
  });

  const currentPage = window.location.pathname.split('/').pop();

  const permissions = {
    dashboard: {
      'store.html':        { roles: ['admin', 'sales', 'inventory'], icon: 'bx bx-store' },
      'order-invoice.html':{ roles: ['admin', 'sales','finance'], icon: 'bx bx-receipt' },
      'product.html':      { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx bx-box' },
      'customer.html':     { roles: ['admin', 'sales', 'finance'], icon: 'bx bx-user' },
      'report.html':       { roles: ['admin', 'sales', 'inventory', 'warehouse', 'finance'], icon: 'bx bx-bar-chart-alt' },
      'setting.html':      { roles: ['admin'], icon: 'bx bx-cog' }
    },
    admin: {
      'user.html':         { roles: ['admin'], icon: 'bx bx-user-circle' },
      'roles.html':        { roles: ['admin'], icon: 'bx bx-shield' },
      'warehouse.html':    { roles: ['admin', 'inventory'], icon: 'bx bx-buildings' },
<<<<<<< HEAD
      'stock.html':        { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx bx-transfer' },
=======
      'stock-movement.html':{ roles: ['admin', 'inventory'], icon: 'bx bx-transfer' },
>>>>>>> origin/main
      'stats.html':        { roles: ['admin', 'finance'], icon: 'bx bx-pie-chart' },
      'category.html':     { roles: ['admin', 'sales', 'inventory'], icon: 'bx bx-list-ul' },
      'product-variant.html':{ roles: ['admin', 'inventory'], icon: 'bx bx-layer' },
      'approve.html':      { roles: ['admin', 'finance'], icon: 'bx bx-check-circle' },
      'logistics.html':    { roles: ['admin', 'sales', 'warehouse'], icon: 'bx bx-package' }
    },
    editor: {
      'sale.html':         { roles: ['admin', 'sales'], icon: 'bx bx-cart' },
      'shipping.html':     { roles: ['admin', 'sales', 'warehouse'], icon: 'bx bx-send' },
      'logistics.html':    { roles: ['admin', 'sales', 'warehouse'], icon: 'bx bx-package' }
    }
  };

  function renderLinks(sectionSelector, sectionData) {
    const container = document.querySelector(sectionSelector);
    let hasVisible = false;

    for (const [href, { roles, icon }] of Object.entries(sectionData)) {
      if (!roles.includes(role)) continue;
      const label = capitalizeWords(href.replace('.html', '').replace('-', ' '));
      const link = document.createElement('a');
      link.href = href;
      link.className = `nav_link sublink${currentPage === href ? ' active' : ''}`;
      link.innerHTML = `<span class="navlink_icon"><i class="${icon || 'bx bx-link'}"></i></span> <span class="navlink">${label}</span>`;
      container.appendChild(link);
      hasVisible = true;
    }

    if (!hasVisible && container.closest('.item')) {
      container.closest('.item').remove();
    }
  }

<<<<<<< HEAD
  // Clear previous dashboard links to avoid duplicates
  const dashboardLinksContainer = document.querySelector('.dashboard-links');
  if (dashboardLinksContainer) dashboardLinksContainer.innerHTML = '';
=======
>>>>>>> origin/main
  renderLinks('.dashboard-links', permissions.dashboard);
  renderLinks('.admin-links', permissions.admin);
  renderLinks('.editor-section', permissions.editor);

  // Toggle submenu display (fix: handle multiple submenus and arrow rotation)
  document.querySelectorAll('.toggle-submenu').forEach(toggle => {
    toggle.addEventListener('click', function () {
      // Find the submenu UL right after this toggle
      const submenu = this.nextElementSibling;
      if (!submenu) return;
      submenu.classList.toggle('open');
      // Rotate only the arrow in this toggle
      const arrow = this.querySelector('.arrow-left');
      if (arrow) arrow.classList.toggle('bx-rotate-90');
    });

    // Auto-open submenu if current page is inside it
    const submenu = toggle.nextElementSibling;
    if (submenu && submenu.querySelector('a.active')) {
      submenu.classList.add('open');
      const arrow = toggle.querySelector('.arrow-left');
      if (arrow) arrow.classList.add('bx-rotate-90');
    }
  });
});