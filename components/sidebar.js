// ============================================
// SIDEBAR MENU SYSTEM - Final UX Improved Version (Logout Centering Fix)
// ============================================

// Configuration (unchanged)
const CONFIG = {
    permissions: {
        dashboard: {
            'store.html': { roles: ['admin', 'sales', 'inventory'], icon: 'bx-store', label: 'Store' },
            'order-invoice.html': { roles: ['admin', 'sales', 'finance'], icon: 'bx-receipt', label: 'Orders & Invoices' },
            'product.html': { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx-box', label: 'Products' },
            'customer.html': { roles: ['admin', 'sales', 'finance'], icon: 'bx-user', label: 'Customers' },
            'report.html': { roles: ['admin', 'sales', 'inventory', 'warehouse', 'finance'], icon: 'bx-bar-chart-alt', label: 'Reports' },
            'setting.html': { roles: ['admin'], icon: 'bx-cog', label: 'Settings' },
            'chairman.html': { roles: ['chairman', 'admin'], icon: 'bx-briefcase-alt-2', label: 'Chairman Overview' }
        },
        admin: {
            'user.html': { roles: ['admin'], icon: 'bx-user-circle', label: 'Users' },
            'roles.html': { roles: ['admin'], icon: 'bx-shield', label: 'Roles' },
            'warehouse.html': { roles: ['admin', 'inventory'], icon: 'bx-buildings', label: 'Warehouses' },
            'stock.html': { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx-transfer', label: 'Stock Management' },
            'stats.html': { roles: ['admin', 'finance'], icon: 'bx-pie-chart', label: 'Statistics' },
            'category.html': { roles: ['admin', 'sales', 'inventory'], icon: 'bx-list-ul', label: 'Categories' },
            'product-variant.html': { roles: ['admin', 'inventory'], icon: 'bx-layer', label: 'Product Variants' },
            'approve.html': { roles: ['admin', 'finance'], icon: 'bx-check-circle', label: 'Approvals' },
            'logistics.html': { roles: ['admin', 'sales', 'warehouse'], icon: 'bx-package', label: 'Logistics' }
        },
        operations: { 
            'sale.html': { roles: ['admin', 'sales'], icon: 'bx-cart', label: 'Sales' },
            'shipping.html': { roles: ['admin', 'sales', 'warehouse'], icon: 'bx-send', label: 'Shipping' },
            'inventory-check.html': { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx-clipboard', label: 'Inventory Check' }
        }
    }
};

// Check for login status (unchanged)
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
  <style>
    /* Import Boxicons for the icons */
    @import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');

    /* BASE STYLES */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 260px;
      background: #fff;
      border-right: 1px solid #e5e7eb;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      z-index: 999;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
    }
    .sidebar.close {
      width: 70px;
    }
    .menu_content {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 12px 0;
    }
    .menu_items {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .nav_link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      text-decoration: none;
      color: #64748b;
      font-size: 14px;
      transition: all 0.2s;
      cursor: pointer;
      user-select: none;
    }
    .nav_link:hover { 
        background: #f8fafc; 
        color: #475569;
    }
    /* Main links are already centered due to min-width: 20px on navlink_icon and the overall padding */
    .navlink_icon { font-size: 20px; min-width: 20px; display: flex; align-items: center; justify-content: center; }
    .navlink { flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: opacity 0.3s; }
    
    /* UI IMPROVEMENT: Logo/Header */
    .sidebar-header {
      padding: 20px;
      border-bottom: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      min-height: 70px;
      gap: 12px;
      font-size: 20px;
      font-weight: 700;
      color: #1e293b;
      position: relative; 
    }
    .sidebar-header i.bx-store-alt { 
      font-size: 28px;
      color: #3b82f6;
    }
    .sidebar.close .sidebar-logo-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }
    /* Toggle Button in Header */
    #sidebarToggle {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        padding: 8px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 24px;
        color: #64748b;
        transition: transform 0.3s;
    }
    .sidebar.close #sidebarToggle {
        position: static;
        transform: none;
        margin: 0 auto;
    }
    .sidebar.close .sidebar-header {
        justify-content: center;
        padding: 0;
    }
    .sidebar.close .sidebar-header i.bx-store-alt {
        display: none; 
    }

    /* Collapsed State Text Hiding */
    .sidebar.close .navlink, 
    .sidebar.close .sidebar-logo-text { 
        opacity: 0; 
        width: 0; 
        pointer-events: none; 
    }

    /* User Info (unchanged) */
    .user_info-animated {
      border-bottom: 1px solid #e5e7eb;
      margin-bottom: 12px;
      padding: 16px 20px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
    }
    .user_info-animated div {
        padding: 4px 0;
        font-size: 13px;
    }
    .sidebar.close .user_info-animated strong,
    .sidebar.close .user_info-animated span {
      opacity: 0; width: 0;
    }
    
    a.nav_link.active { 
        background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 100%); 
        font-weight: 600; 
        color: #3b82f6; 
        border-right: 3px solid #3b82f6;
    }

    /* Submenu fixes (unchanged) */
    ul.submenu { display: none; padding-left: 0; margin-left: 0; } 
    ul.submenu.open { display: block; }
    .toggle-submenu { cursor: pointer; user-select: none; }

    .nav_link.sublink {
      padding-left: 52px; 
    }
    .sidebar.close .nav_link.sublink {
        padding-left: 20px;
    }

    /* Logout Button Styling */
    .sidebar-actions {
        padding: 0 20px;
        border-top: 1px solid #e5e7eb; 
        margin-top: auto; 
        padding-top: 16px;
    }
    .sidebar.close .sidebar-actions {
        padding: 0;
        padding-top: 16px;
        /* Ensure container alignment when text is gone */
        display: flex;
        justify-content: center; /* Center the entire block */
        align-items: center;
        flex-direction: column;
    }
    
    #logoutBtn {
        padding-bottom: 12px; 
        width: 100%; 
    }
    
    /* FIX: Center the Logout icon when collapsed */
    .sidebar.close #logoutBtn {
        justify-content: center; 
        padding-left: 0;
        padding-right: 0;
        width: 100%; /* Allows flex centering to work within the 70px sidebar */
    }

    #logoutBtn span {
        color: #e53e3e;
        font-weight: 600;
        transition: opacity 0.3s;
    }
    .sidebar.close #logoutBtn span {
        opacity: 0; 
    }
    
  </style>

  <nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class='bx '></i>
        <span class="sidebar-logo-text">Inventory Management</span>
        <i id="sidebarToggle" class='bx bx-log-out'></i>
    </div>
    <div class="menu_content">
      <ul class="menu_items">
        <li class="item user_info-animated">
          <div class="user-info-text">
            <div><strong>Name:</strong> <span id="sidebarUserName">-</span></div>
            <div><strong>Role:</strong> <span id="sidebarUserRole">-</span></div>
            <div><strong>Warehouse:</strong> <span id="sidebarUserWarehouse">-</span></div>
          </div>
        </li>

        <li class="item dashboard-section">
          <div class="nav_link toggle-submenu" data-section="dashboard">
            <span class="navlink_icon"><i class="bx bx-home-alt"></i></span>
            <span class="navlink">Dashboard</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu dashboard-links"></ul>
        </li>

        <li class="item admin-section">
          <div class="nav_link toggle-submenu" data-section="admin">
            <span class="navlink_icon"><i class="bx bx-grid-alt"></i></span>
            <span class="navlink">Admin</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu admin-links"></ul>
        </li>
        
        <li class="item operations-section">
          <div class="nav_link toggle-submenu" data-section="operations">
            <span class="navlink_icon"><i class="bx bx-briefcase"></i></span>
            <span class="navlink">Operations</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu operations-links"></ul>
        </li>
      </ul>

      <div class="sidebar-actions">
        <div id="logoutBtn" class="bottom-action">
          <span>Logout</span><i class='bx bx-power-off'></i>
        </div>
      </div>
      
    </div>
  </nav>
`);


// Capitalize helper (unchanged)
function capitalizeWords(str) {
    if (!str) return '-';
    return String(str).toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
}

// On DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    const role = localStorage.getItem('role');
    const name = localStorage.getItem('name');
    let warehouse = localStorage.getItem('warehouse');
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    if (user?.warehouse?.name) warehouse = user.warehouse.name;

    // 1. Update User Info (unchanged)
    document.getElementById('sidebarUserName').textContent = capitalizeWords(name);
    document.getElementById('sidebarUserRole').textContent = capitalizeWords(role);
    document.getElementById('sidebarUserWarehouse').textContent = capitalizeWords(warehouse);

    // 2. Logout Handler (unchanged)
    document.getElementById('logoutBtn')?.addEventListener('click', () => {
        if (confirm('Are you sure you want to logout?')) {
            localStorage.clear();
            window.location.href = 'index.html';
        }
    });

    const currentPage = window.location.pathname.split('/').pop();
    let isCollapsed = false;

    // 3. Link Rendering Function (unchanged)
    function renderLinks(sectionKey) {
        const container = document.querySelector(`.${sectionKey}-links`);
        if (!container) {
            document.querySelector(`.${sectionKey}-section`)?.remove();
            return;
        }

        const sectionData = CONFIG.permissions[sectionKey] || {};
        let hasVisible = false;

        for (const [href, { roles, icon, label }] of Object.entries(sectionData)) {
            if (!roles.includes(role)) continue;

            const linkLabel = label || capitalizeWords(href.replace('.html', '').replace('-', ' '));
            const linkItem = document.createElement('li'); 
            const link = document.createElement('a');

            link.href = href;
            link.className = `nav_link sublink${currentPage === href ? ' active' : ''}`;
            link.innerHTML = `<span class="navlink_icon"><i class="bx ${icon || 'bx-link'}"></i></span> <span class="navlink">${linkLabel}</span>`;
            
            linkItem.appendChild(link);
            container.appendChild(linkItem);
            hasVisible = true;
        }

        if (!hasVisible) {
            container.closest('.item')?.remove();
        }
    }

    // Render all sections (unchanged)
    renderLinks('dashboard');
    renderLinks('admin');
    renderLinks('operations');

    // 4. Collapse/Expand Handlers (MODIFIED)
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle'); 
    
    // Check for initial state (if a class was set externally)
    if (sidebar?.classList.contains('close')) {
         toggleBtn?.classList.replace('bx-log-out', 'bx-menu'); 
         isCollapsed = true;
    } else {
         toggleBtn?.classList.replace('bx-menu', 'bx-log-out'); 
         isCollapsed = false;
    }


    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('close');
            isCollapsed = !isCollapsed;

            // Swap icon based on state
            if (isCollapsed) {
                toggleBtn.classList.replace('bx-log-out', 'bx-menu');
            } else {
                toggleBtn.classList.replace('bx-menu', 'bx-log-out');
            }
        });
    }

    // 5. Hover behavior for desktop when collapsed (unchanged)
    sidebar?.addEventListener('mouseenter', () => {
        if (isCollapsed) {
            sidebar.classList.remove('close');
            toggleBtn?.classList.replace('bx-menu', 'bx-log-out'); 
        }
    });
    sidebar?.addEventListener('mouseleave', () => {
        if (isCollapsed) {
            sidebar.classList.add('close');
            toggleBtn?.classList.replace('bx-log-out', 'bx-menu'); 
        }
    });


    // 6. Submenu Toggle Display (unchanged)
    document.querySelectorAll('.toggle-submenu').forEach(toggle => {
        toggle.addEventListener('click', function () {
            if (isCollapsed && window.innerWidth > 768) {
                return; 
            }
            
            const submenu = this.nextElementSibling;
            if (!submenu) return;
            submenu.classList.toggle('open');
            
            const arrow = this.querySelector('.arrow-left');
            if (arrow) arrow.classList.toggle('rotated');
        });

        const submenu = toggle.nextElementSibling;
        if (submenu && submenu.querySelector('a.active')) {
            submenu.classList.add('open');
            const arrow = toggle.querySelector('.arrow-left');
            if (arrow) arrow.classList.add('rotated');
        }
    });
});