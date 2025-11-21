// ============================================
// NAVBAR SYSTEM - Final Cleaned Version (Fixed Position Layout)
// ============================================

// Check for login status (retaining the existing check from the sidebar context)
(function () {
    const name = localStorage.getItem('name');
    const role = localStorage.getItem('role');
    if (!name || !role) {
        // NOTE: Keeping this logic separate from the navbar script's core purpose.
    }
})();

// Navbar UI 
document.write(`
  <style>
    /* Import Boxicons for the icons */
    @import url('https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css');
    
    /* --- Navbar Base (FIXED POSITION) --- */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      /* Adjusted padding for better fit on all screens */
      padding: 10px 18px; 
      background: #fff; 
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); 
      flex-wrap: wrap;
      
      /* CRITICAL FIX: Use fixed position for true viewport locking */
      position: fixed; 
      top: 0;
      left: 0; 
      width: 100%; 
      /* Ensure navbar is high priority */
      z-index: 1000; 
    }

    /* --- Logo/Title --- */
    .logo_item {
      display: flex;
      align-items: center;
      gap: 12px;
      font-weight: 700;
      font-size: 16px;
      color: #1e293b;
    }
    .logo_item img {
      height: 30px;
      width: 30px;
      object-fit: contain;
    }
    .logo_item i.bx-menu {
        font-size: 28px;
        cursor: pointer;
        color: #3b82f6;
    }

    /* --- Desktop Content --- */
    .navbar_content {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .navbar_content .profile {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      cursor: pointer;
    }
    .navbar_content i {
        display: none; 
    }

    /* Network Status Badge */
    #networkStatus {
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: 600;
      font-size: 11px;
      margin-left: 8px;
      background: #f1f5f9;
    }

    /* --- Mobile Dropdown Toggle --- */
    .dropdown-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 24px; 
      cursor: pointer;
      color: #475569;
    }

    /* --- Mobile Dropdown Menu --- */
    .dropdown-menu {
      display: none;
      /* Needs to be fixed or absolute to the fixed navbar parent */
      position: fixed; 
      right: 10px;
      /* Use a top value relative to the viewport height */
      top: 70px; 
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      min-width: 180px;
      z-index: 1050;
      padding: 8px 0;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown-menu .dropdown-item {
      padding: 10px 18px;
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
    }
    .dropdown-menu .dropdown-item:hover {
      background: #f1f5f9;
    }
    
    .dropdown-menu .dropdown-item img.profile {
        width: 24px;
        height: 24px;
        border-radius: 50%;
    }
    
    /* Mobile Network Status in Dropdown */
    #networkStatusMobile {
        padding: 10px 18px 10px 18px;
        font-weight: 600;
        font-size: 13px;
        border-top: 1px solid #e2e8f0;
        margin-top: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }


    /* --- Responsive Mobile Styles --- */
    @media (max-width: 768px) {
      .navbar {
        padding: 8px 10px; 
      }
      .logo_item {
        font-size: 14px;
        gap: 8px;
      }
      .dropdown-toggle {
        display: block;
      }
      .navbar_content {
        display: none;
      }
      /* Adjust mobile dropdown top offset if Navbar height changes */
      .dropdown-menu {
        top: 60px;
      }
    }
  </style>
  <nav class="navbar" id="mainNavbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="assets/images/eraskon_logo.webp" alt=""> Eraskon Nigeria Ltd
    </div>
    <button class="dropdown-toggle" id="navbarDropdown"><i class='bx bx-dots-vertical-rounded'></i></button>
    
    <div class="navbar_content" id="navbarContent">
      <div id="networkStatus"></div>
      <img src="assets/images/avatar.png" alt="" class="profile" title="User Profile" />
    </div>
    
    <div class="dropdown-menu" id="navbarDropdownMenu">
      
      <button class="dropdown-item">
        <img src="assets/images/avatar.png" alt="" class="profile" style="margin-right:8px;"> Profile
      </button>
      
      <div id="networkStatusMobile">
        <span>Network Status:</span>
        <span id="mobileStatusText"></span>
      </div>
      
    </div>
  </nav>
  <script>
    // Network status (unchanged)
    function updateStatus() {
      const statusDiv = document.getElementById("networkStatus");
      const statusTextSpan = document.getElementById("mobileStatusText");
      const online = navigator.onLine;
      const statusText = online ? "ONLINE" : "OFFLINE";
      const statusSymbol = online ? "🟢 " : "🔴 ";
      
      // Desktop view
      if (statusDiv) {
        statusDiv.textContent = statusSymbol + statusText;
        statusDiv.style.color = online ? "green" : "red";
      }
      
      // Mobile view
      if (statusTextSpan) {
        statusTextSpan.textContent = statusSymbol + statusText;
        statusTextSpan.style.color = online ? "green" : "red";
      }
    }
    window.addEventListener("online", updateStatus);
    window.addEventListener("offline", updateStatus);
    document.addEventListener("DOMContentLoaded", updateStatus);

    // Dropdown for mobile (unchanged)
    const dropdownBtn = document.getElementById('navbarDropdown');
    const dropdownMenu = document.getElementById('navbarDropdownMenu');
    dropdownBtn?.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdownMenu?.classList.toggle('show');
    });
    // Optional: close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!dropdownBtn?.contains(e.target) && !dropdownMenu?.contains(e.target)) {
        dropdownMenu?.classList.remove('show');
      }
    });

  </script>
`);