// ============================================
// SIDEBAR MENU SYSTEM - Mobile & Desktop Fixed Version
// ============================================

// Configuration
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
            // 'inventory-check.html': { roles: ['admin', 'inventory', 'warehouse'], icon: 'bx-clipboard', label: 'Inventory Check' }
        }
    }
};

// Check for login status
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
      z-index: 1001;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
    }
    
    .sidebar.close {
      width: 70px;
    }
    
    /* Mobile: Hidden by default, slides in when open */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 280px;
      }
      
      .sidebar.mobile-open {
        transform: translateX(0);
      }
      
      /* Override close class on mobile */
      .sidebar.close {
        width: 280px;
      }
    }
    
    /* Overlay for mobile */
    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    
    .sidebar-overlay.active {
      display: block;
      opacity: 1;
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
      position: relative;
    }
    
    .nav_link:hover { 
      background: #f8fafc; 
      color: #475569;
    }
    
    .navlink_icon { 
      font-size: 20px; 
      min-width: 20px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
    }
    
    .navlink { 
      flex: 1; 
      white-space: nowrap; 
      overflow: hidden; 
      text-overflow: ellipsis; 
      transition: opacity 0.3s; 
    }
    
    .arrow-left {
      font-size: 16px;
      transition: transform 0.3s;
      margin-left: auto;
    }
    
    .arrow-left.rotated {
      transform: rotate(90deg);
    }
    
    /* Sidebar Header */
    .sidebar-header {
      padding: 20px;
      border-bottom: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      min-height: 70px;
      gap: 12px;
      font-size: 18px;
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
    
    /* Toggle Button - Only visible on desktop */
    #sidebarToggle {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      padding: 8px;
      cursor: pointer;
      font-size: 24px;
      color: #64748b;
      transition: all 0.3s;
    }
    
    .sidebar.close #sidebarToggle {
      position: static;
      transform: none;
      margin: 0 auto;
    }
    
    .sidebar.close .sidebar-header {
      justify-content: center;
      padding: 20px 10px;
    }
    
    .sidebar.close .sidebar-header i.bx-store-alt {
      display: none; 
    }
    
    /* Hide toggle button on mobile */
    @media (max-width: 768px) {
      #sidebarToggle {
        display: none;
      }
      
      .sidebar-header {
        padding: 16px 20px;
        min-height: 60px;
      }
      
      .sidebar-header i.bx-store-alt {
        font-size: 24px;
      }
      
      .sidebar-logo-text {
        font-size: 16px;
      }
    }
    
    /* Collapsed State */
    .sidebar.close .navlink, 
    .sidebar.close .sidebar-logo-text { 
      opacity: 0; 
      width: 0; 
      pointer-events: none; 
    }
    
    .sidebar.close .arrow-left {
      display: none;
    }
    
    /* On mobile, always show text even with close class */
    @media (max-width: 768px) {
      .sidebar.close .navlink,
      .sidebar.close .sidebar-logo-text {
        opacity: 1;
        width: auto;
        pointer-events: auto;
      }
      
      .sidebar.close .arrow-left {
        display: block;
      }
      
      .sidebar.close .sidebar-header {
        justify-content: flex-start;
        padding: 16px 20px;
      }
      
      .sidebar.close .sidebar-header i.bx-store-alt {
        display: block;
      }
    }
    
    /* User Info */
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
      opacity: 0; 
      width: 0;
    }
    
    @media (max-width: 768px) {
      .sidebar.close .user_info-animated strong,
      .sidebar.close .user_info-animated span {
        opacity: 1;
        width: auto;
      }
    }
    
    a.nav_link.active { 
      background: linear-gradient(90deg, #eff6ff 0%, #dbeafe 100%); 
      font-weight: 600; 
      color: #3b82f6; 
      border-right: 3px solid #3b82f6;
    }
    
    /* Submenu */
    ul.submenu { 
      display: none; 
      padding-left: 0; 
      margin-left: 0; 
    } 
    
    ul.submenu.open { 
      display: block; 
    }
    
    .toggle-submenu { 
      cursor: pointer; 
      user-select: none; 
    }
    
    .nav_link.sublink {
      padding-left: 52px; 
    }
    
    .sidebar.close .nav_link.sublink {
      padding-left: 20px;
    }
    
    @media (max-width: 768px) {
      .sidebar.close .nav_link.sublink {
        padding-left: 52px;
      }
    }
    
    /* Logout Button */
    .sidebar-actions {
      padding: 16px 20px;
      border-top: 1px solid #e5e7eb; 
      margin-top: auto; 
    }
    
    .sidebar.close .sidebar-actions {
      padding: 16px 0;
      display: flex;
      justify-content: center;
    }
    
    @media (max-width: 768px) {
      .sidebar.close .sidebar-actions {
        padding: 16px 20px;
        display: block;
      }
    }
    
    #logoutBtn {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 20px;
      background: none;
      border: none;
      color: #e53e3e;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      width: 100%;
      transition: all 0.2s;
      border-radius: 6px;
    }
    
    #logoutBtn:hover {
      background: #fef2f2;
    }
    
    #logoutBtn i {
      font-size: 20px;
    }
    
    .sidebar.close #logoutBtn {
      justify-content: center;
      padding: 12px;
      width: auto;
    }
    
    .sidebar.close #logoutBtn span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }
    
    @media (max-width: 768px) {
      .sidebar.close #logoutBtn {
        justify-content: flex-start;
        padding: 12px 20px;
        width: 100%;
      }
      
      .sidebar.close #logoutBtn span {
        opacity: 1;
        width: auto;
        overflow: visible;
      }
    }
  </style>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  <nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <i class='bx bx-store-alt'></i>
      <span class="sidebar-logo-text">Inventory Management</span>
      <i id="sidebarToggle" class='bx bx-chevron-left'></i>
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
        <button id="logoutBtn">
          <i class='bx bx-power-off'></i>
          <span>Logout</span>
        </button>
      </div>
    </div>
  </nav>
`);

// Capitalize helper
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

    // Update User Info
    document.getElementById('sidebarUserName').textContent = capitalizeWords(name);
    document.getElementById('sidebarUserRole').textContent = capitalizeWords(role);
    document.getElementById('sidebarUserWarehouse').textContent = capitalizeWords(warehouse);

    // Logout Handler
    document.getElementById('logoutBtn')?.addEventListener('click', () => {
        if (confirm('Are you sure you want to logout?')) {
            localStorage.clear();
            window.location.href = 'index.html';
        }
    });

    const currentPage = window.location.pathname.split('/').pop();
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    let isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    const isMobile = window.innerWidth <= 768;

    // Link Rendering Function
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

    // Render all sections
    renderLinks('dashboard');
    renderLinks('admin');
    renderLinks('operations');

    // Desktop: Set initial collapse state
    if (!isMobile && isCollapsed) {
        sidebar?.classList.add('close');
        toggleBtn?.classList.replace('bx-chevron-left', 'bx-chevron-right');
    }

    // Toggle button for desktop only
    toggleBtn?.addEventListener('click', () => {
        if (window.innerWidth <= 768) return;
        
        sidebar?.classList.toggle('close');
        isCollapsed = sidebar?.classList.contains('close');
        
        if (isCollapsed) {
            toggleBtn.classList.replace('bx-chevron-left', 'bx-chevron-right');
        } else {
            toggleBtn.classList.replace('bx-chevron-right', 'bx-chevron-left');
        }
        
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    });

    // Desktop: Hover behavior when collapsed
    if (!isMobile) {
        sidebar?.addEventListener('mouseenter', () => {
            if (isCollapsed) {
                sidebar.classList.remove('close');
                toggleBtn?.classList.replace('bx-chevron-right', 'bx-chevron-left');
            }
        });
        
        sidebar?.addEventListener('mouseleave', () => {
            if (isCollapsed) {
                sidebar.classList.add('close');
                toggleBtn?.classList.replace('bx-chevron-left', 'bx-chevron-right');
            }
        });
    }

    // Mobile: Open sidebar function (called from navbar)
    window.openMobileSidebar = function() {
        sidebar?.classList.add('mobile-open');
        overlay?.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    // Mobile: Close sidebar function
    window.closeMobileSidebar = function() {
        sidebar?.classList.remove('mobile-open');
        overlay?.classList.remove('active');
        document.body.style.overflow = '';
    };

    // Close on overlay click
    overlay?.addEventListener('click', () => {
        window.closeMobileSidebar();
    });

    // Close sidebar when clicking a link on mobile
    if (isMobile) {
        document.querySelectorAll('.sidebar a.nav_link').forEach(link => {
            link.addEventListener('click', () => {
                setTimeout(() => window.closeMobileSidebar(), 150);
            });
        });
    }

    // Submenu Toggle
    document.querySelectorAll('.toggle-submenu').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const submenu = this.nextElementSibling;
            if (!submenu) return;
            
            // On desktop collapsed mode without hover, don't toggle
            if (window.innerWidth > 768 && isCollapsed && !sidebar?.matches(':hover')) {
                return;
            }
            
            submenu.classList.toggle('open');
            const arrow = this.querySelector('.arrow-left');
            if (arrow) arrow.classList.toggle('rotated');
        });

        // Auto-open submenu if it contains active link
        const submenu = toggle.nextElementSibling;
        if (submenu && submenu.querySelector('a.active')) {
            submenu.classList.add('open');
            const arrow = toggle.querySelector('.arrow-left');
            if (arrow) arrow.classList.add('rotated');
        }
    });
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const nowMobile = window.innerWidth <= 768;
            if (nowMobile) {
                // Switched to mobile - close sidebar if open
                sidebar?.classList.remove('mobile-open');
                overlay?.classList.remove('active');
                document.body.style.overflow = '';
            }
        }, 250);
    });
});