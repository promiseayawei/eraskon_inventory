// Check for logged-in user before rendering sidebar
(function() {
  const name = localStorage.getItem('name');
  const role = localStorage.getItem('role');
  if (!name || !role) {
    window.location.href = 'index.html';
    return;
  }
})();

document.write(`
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="menu_content">
      <ul class="menu_items">
        <div class="menu_title menu_dashboard"></div>
        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink"><div><strong>Name:</strong> <span id="sidebarUserName">-</span></div></span>
          </div>
           <div href="#" class="nav_link submenu_item">
            <span class="navlink"><div><strong>Role:</strong> <span id="sidebarUserRole">-</span></div></span>
          </div>
           <div href="#" class="nav_link submenu_item">
            <span class="navlink"><div><strong>Warehouse:</strong> <span id="sidebarUserWarehouse">-</span></div></span>
          </div>
        </li>
        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink_icon"><i class="bx bx-home-alt"></i></span>
            <span class="navlink">Dashboard</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu">
            <a href="store.html" class="nav_link sublink">store</a>
            <a href="product.html" class="nav_link sublink">products</a>
            <a href="customer.html" class="nav_link sublink">customers</a>
            <a href="report.html" class="nav_link sublink">reports</a>
            <a href="setting.html" class="nav_link sublink">settings</a>
            </ul>
        </li>
        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink_icon"><i class="bx bx-grid-alt"></i></span>
            <span class="navlink">Admin</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu">
            <a href="user.html" class="nav_link sublink">Users</a>
            <a href="role.html" class="nav_link sublink">Roles</a>
            <a href="warehouse.html" class="nav_link sublink">Warehouses</a>
            <a href="stock-movement.html" class="nav_link sublink">Stock Movement</a>
            <a href="stats.html" class="nav_link sublink">Analytics</a>
            <a href="category.html" class="nav_link sublink">Category</a>
            <a href="product.html" class="nav_link sublink">Products</a>
            <a href="product-variant.html" class="nav_link sublink">Product-variant</a>
          </ul>
        </li>
      </ul>
      <ul class="menu_items">
        <div class="menu_title menu_editor"></div>
        <li class="item">
          <a href="product.html" class="nav_link">
            <span class="navlink_icon"><i class="bx bxs-magic-wand"></i></span>
            <span class="navlink">Products</span>
          </a>
        </li>
        <li class="item">
          <a href="sale.html" class="nav_link">
            <span class="navlink_icon"><i class="bx bx-loader-circle"></i></span>
            <span class="navlink">Sales</span>
          </a>
        </li>
        <li class="item">
          <a href="report.html" class="nav_link">
            <span class="navlink_icon"><i class="bx bx-filter"></i></span>
            <span class="navlink">Report</span>
          </a>
        </li>
        <li class="item">
          <a href="#" class="nav_link">
            <span class="navlink_icon"><i class="bx bx-cloud-upload"></i></span>
            <span class="navlink">Stock</span>
          </a>
        </li>
        <li class="item">
          <a href="shipping.html" class="nav_link">
            <span class="navlink_icon"><i class="bx bx-van"></i></span>
            <span class="navlink">Shipping</span>
          </a>
        </li>
      </ul>
      <!-- Logout in its own section -->
      <div class="sidebar-actions">
        <div class="bottom" id="logoutBtn" style="cursor:pointer; border-top:1px solid #eee; padding-top:12px;">
          <span>Logout</span>
          <i class='bx bx-power-off'></i>
        </div>
      </div>
      <!-- Expand/Collapse in a separate section -->
      <div class="bottom_content">
        <div class="bottom expand_sidebar">
          <span>Expand</span>
          <i class='bx bx-log-in'></i>
        </div>
        <div class="bottom collapse_sidebar">
          <span>Collapse</span>
          <i class='bx bx-log-out'></i>
        </div>
      </div>
    </div>
  </nav>
`);

// Animation style (keep your main styles in assets/css/style.css)
const style = document.createElement('style');
style.innerHTML = `
.user_info-animated {
  animation: fadeInUserInfo 1s cubic-bezier(.4,0,.2,1);
  transition: background 0.3s;
}
@keyframes fadeInUserInfo {
  from { opacity: 0; transform: translateY(-20px);}
  to { opacity: 1; transform: translateY(0);}
}
.sidebar-actions {
  margin-top: 24px;
  margin-bottom: 8px;
}
#logoutBtn {
  color: #e53e3e;
  font-weight: 600;
}
`;
document.head.appendChild(style);

// Helper function to capitalize first letter of each word
function capitalizeWords(str) {
  if (!str) return '-';
  return str.replace(/\b\w/g, c => c.toUpperCase());
}

// Populate user info from localStorage
document.addEventListener('DOMContentLoaded', () => {
  const name = localStorage.getItem('name');
  const role = localStorage.getItem('role');
  const warehouse = localStorage.getItem('warehouse');

  document.getElementById('sidebarUserName').textContent = capitalizeWords(name);
  document.getElementById('sidebarUserRole').textContent = capitalizeWords(role);
  document.getElementById('sidebarUserWarehouse').textContent = capitalizeWords(warehouse);

  // Logout functionality
  const logoutBtn = document.getElementById('logoutBtn');
  if (logoutBtn) {
    logoutBtn.addEventListener('click', () => {
      localStorage.clear();
      window.location.href = 'index.html';
    });
  }
});
