document.write(`
  <style>
    @import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
    
    /* Main Content Push (for sidebar) */
    body {
      margin: 0;
      padding: 0;
    }
    
    .main-content {
      margin-left: 260px;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 100vh;
    }
    
    .sidebar.close ~ * .main-content,
    body.sidebar-collapsed .main-content {
      margin-left: 70px;
    }
    
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0 !important;
      }
    }
    
    /* Navbar Base */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between; 
      padding: 12px 20px;
      background: #fff; /* Default color: White */
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); 
      position: sticky; 
      top: 0;
      z-index: 1100;
      height: 60px;
      box-sizing: border-box;
      transition: background 0.3s ease; /* Added transition for smooth color change */
    }

    /* === NEW: Offline State Style === */
    .navbar.offline {
      background: #fef2f2; /* Very light red background */
      border-bottom: 3px solid #ef4444; /* Red bottom border */
    }
    
    /* Logo/Title */
    .logo_item {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 700;
      font-size: 18px;
      color: #1e293b;
    }
    
    .logo_item img {
      height: 35px;
      width: 35px;
      object-fit: contain;
    }
    
    /* Mobile menu button - hidden on desktop */
    .logo_item i.bx-menu {
      align-self: center;
      font-size: 30px;
      cursor: pointer;
      color: #3b82f6;
      display: none;
      padding: 4px;
      border-radius: 6px;
      transition: background 0.2s;
    }
    
    .logo_item i.bx-menu:active {
      background: #eff6ff;
    }
    
    @media (max-width: 768px) {
      .logo_item i.bx-menu {
        display: block;
      }
      
      .navbar {
        padding: 10px 15px;
        height: 56px;
      }
      
      .logo_item {
        font-size: 15px;
        gap: 10px;
      }
      
      .logo_item img {
        height: 30px;
        width: 30px;
      }
    }
    
    @media (max-width: 480px) {
      .logo_item {
        font-size: 14px;
        gap: 8px;
      }
      
      .logo_item img {
        height: 26px;
        width: 26px;
      }
    }

    /* Desktop Content */
    .navbar_content {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    
    .navbar_content .profile {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
      border: 2px solid #e5e7eb;
      transition: border-color 0.2s;
    }
    
    .navbar_content .profile:hover {
      border-color: #3b82f6;
    }

    /* Network Status Badge */
    #networkStatus {
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 12px;
      display: flex;
      align-items: center;
      gap: 6px;
      background: #f1f5f9;
    }

    /* Mobile Dropdown Toggle */
    .dropdown-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 28px;
      cursor: pointer;
      color: #475569;
      padding: 4px;
      line-height: 1;
      border-radius: 6px;
      transition: background 0.2s;
    }
    
    .dropdown-toggle:active {
      background: #f1f5f9;
    }

    /* Mobile Dropdown Menu */
    .dropdown-menu {
      display: none;
      position: fixed;
      right: 10px;
      top: 66px;
      background: #fff;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
      border-radius: 12px;
      min-width: 200px;
      z-index: 1050;
      padding: 8px 0;
      animation: slideDown 0.2s ease-out;
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .dropdown-menu.show {
      display: block;
    }
    
    .dropdown-menu .dropdown-item {
      padding: 12px 18px;
      cursor: pointer;
      font-size: 14px;
      color: #334155;
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: background 0.2s;
    }
    
    .dropdown-menu .dropdown-item:hover {
      background: #f1f5f9;
    }
    
    .dropdown-menu .dropdown-item img.profile {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      border: 2px solid #e5e7eb;
    }
    
    .dropdown-menu .dropdown-item i {
      font-size: 20px;
      color: #64748b;
    }
    
    /* Mobile Network Status - Now a button/item */
    .dropdown-item.network-status-item {
      cursor: default; /* Not clickable */
      font-weight: 600;
      font-size: 13px;
      color: #475569;
      background: none;
    }

    /* Responsive Mobile Styles */
    @media (max-width: 768px) {
      .dropdown-toggle {
        display: block;
      }
      
      .navbar_content {
        display: none;
      }
      
      .dropdown-menu {
        top: 60px;
      }
       /* Ensure the sidebar open button is correctly aligned on mobile */
      .logo_item {
        justify-content: flex-start;
      }
    }
    
    /* Tablet adjustments */
    @media (min-width: 769px) and (max-width: 1024px) {
      .navbar {
        padding: 12px 18px;
      }
      .logo_item {
        font-size: 16px;
      }
    }
    
    /* Very small screens */
    @media (max-width: 360px) {
      .logo_item span {
        display: none;
      }
    }
    
    /* === DESKTOP CENTERING LOGIC (769px+) === */
    .navbar-center-spacer {
      display: none; 
    }
    
    @media (min-width: 769px) {
      .navbar {
        justify-content: flex-start; 
      }
      
      .navbar-center-spacer {
        display: block; 
        flex-basis: 0;
        flex-grow: 1; 
      }
      
      .logo_item {
        order: 2; 
        flex-grow: 0; 
        flex-shrink: 0;
      }
      
      .navbar_content {
        order: 3; 
        flex-basis: 0;
        flex-grow: 1; 
        justify-content: flex-end; 
      }
      
      .logo_item {
        justify-content: flex-start;
      }
    }
  </style>
  
  <nav class="navbar" id="mainNavbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="assets/images/eraskon_logo.webp" alt="Eraskon Logo"> 
      <span class="logo-text">Eraskon Nigeria Ltd</span>
    </div>
    
    <div class="navbar-center-spacer"></div>
    
    <button class="dropdown-toggle" id="navbarDropdown">
      <i class='bx bx-dots-vertical-rounded'></i>
    </button>
    
    <div class="navbar_content" id="navbarContent">
      <div id="networkStatus"></div>
      <img src="assets/images/avatar.png" alt="User Profile" class="profile" title="User Profile" />
    </div>
    
    <div class="dropdown-menu" id="navbarDropdownMenu">
      <button class="dropdown-item network-status-item" id="mobileNetworkStatusItem">
        <span>Network:</span>
        <span id="mobileStatusText"></span>
      </button>
      
      <button class="dropdown-item" id="mobileProfileBtn">
        <img src="assets/images/avatar.png" alt="Profile" class="profile">
        <span>Profile</span>
      </button>
      
    </div>
  </nav>
  
  <script>
    (function() {
      // Network status update and navbar color change
      function updateStatus() {
        const navbar = document.getElementById("mainNavbar");
        const statusDiv = document.getElementById("networkStatus");
        const statusTextSpan = document.getElementById("mobileStatusText");
        const online = navigator.onLine;
        const statusText = online ? "ONLINE" : "OFFLINE";
        const statusSymbol = online ? "🟢" : "🔴";
        
        // Toggle red navbar color
        if (navbar) {
          navbar.classList.toggle('offline', !online);
        }
        
        // Desktop view
        if (statusDiv) {
          statusDiv.innerHTML = statusSymbol + " " + statusText;
          statusDiv.style.color = online ? "#10b981" : "#ef4444";
        }
        
        // Mobile view
        if (statusTextSpan) {
          statusTextSpan.innerHTML = statusSymbol + " " + statusText;
          statusTextSpan.style.color = online ? "#10b981" : "#ef4444";
        }
      }
      
      window.addEventListener("online", updateStatus);
      window.addEventListener("offline", updateStatus);
      document.addEventListener("DOMContentLoaded", updateStatus);

      // Wait for DOM to be ready
      document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar open button
        const sidebarOpenBtn = document.getElementById('sidebarOpen');
        
        if (sidebarOpenBtn) {
          sidebarOpenBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Hamburger menu clicked'); // Debug log
            
            // Check if function exists
            if (typeof window.openMobileSidebar === 'function') {
              window.openMobileSidebar();
            } else {
              // Fallback: directly manipulate sidebar
              console.log('Using fallback method');
              const sidebar = document.getElementById('sidebar');
              const overlay = document.getElementById('sidebarOverlay');
              
              if (sidebar && overlay) {
                sidebar.classList.add('mobile-open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
              }
            }
          });
        }

        // Mobile dropdown toggle
        const dropdownBtn = document.getElementById('navbarDropdown');
        const dropdownMenu = document.getElementById('navbarDropdownMenu');
        
        if (dropdownBtn && dropdownMenu) {
          dropdownBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
          });
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
          if (dropdownBtn && dropdownMenu) {
            if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
              dropdownMenu.classList.remove('show');
            }
          }
        });
        
        // Close dropdown on item click
        // Filter out the network status item from closing the menu
        document.querySelectorAll('.dropdown-item:not(.network-status-item)').forEach(item => {
          item.addEventListener('click', function() {
            if (dropdownMenu) {
              dropdownMenu.classList.remove('show');
            }
          });
        });
      });
      
      // Responsive text handling
      function handleResize() {
        const logoText = document.querySelector('.logo-text');
        if (!logoText) return;
        
        if (window.innerWidth < 400) {
          logoText.textContent = 'Eraskon';
        } else {
          logoText.textContent = 'Eraskon Nigeria Ltd';
        }
      }
      
      window.addEventListener('resize', handleResize);
      document.addEventListener('DOMContentLoaded', handleResize);
    })();
  </script>
`);