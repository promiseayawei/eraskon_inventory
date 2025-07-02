document.write(`
  <style>
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 18px;
      background: #e2dcdc;
      box-shadow: 0 2px 8px #0001;
      flex-wrap: wrap;
      position: relative;
      transition: background 0.3s, color 0.3s;
    }
    .logo_item {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: bold;
      font-size: 1.1rem;
    }
    .logo_item img {
      height: 32px;
      width: 32px;
      object-fit: contain;
    }
    .navbar_content {
      display: flex;
      align-items: center;
      gap: 14px;
      transition: max-height 0.3s;
    }
    .navbar_content .profile {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
    }
    #networkStatus {
      padding: 8px;
      font-weight: bold;
      font-size: 11px;
      margin-left: 8px;
    }
    .dropdown-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.5rem;
      margin-left: 10px;
      cursor: pointer;
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 10px;
      top: 48px;
      background: #fff;
      box-shadow: 0 2px 8px #0001;
      border-radius: 8px;
      min-width: 140px;
      z-index: 200;
      padding: 8px 0;
      transition: background 0.3s, color 0.3s;
    }
    .dropdown-menu.show {
      display: block;
    }
    .dropdown-menu .dropdown-item {
      padding: 8px 18px;
      cursor: pointer;
      font-size: 1rem;
      color: #222;
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .dropdown-menu .dropdown-item:hover {
      background: #f3f4f6;
    }
   
    @media (max-width: 600px) {
      .navbar {
        flex-direction: row;
        align-items: flex-start;
        padding: 10px 6px;
      }
      .logo_item {
        font-size: 1rem;
        gap: 6px;
      }
      .dropdown-toggle {
        display: block;
      }
      .navbar_content {
        display: none;
      }
    }
  </style>
  <!-- Navbar -->
  <nav class="navbar" id="mainNavbar">
    <div class="logo_item">
      <i class="bx bx-menu" id="sidebarOpen"></i>
      <img src="assets/images/eraskon_logo.webp" alt=""> Inventory System
    </div>
    <button class="dropdown-toggle" id="navbarDropdown">&#9776;</button>
    <div class="navbar_content" id="navbarContent">
      <i class="bi bi-grid"></i>
      <i class='bx bx-sun' id="darkLight" style="cursor:pointer;" title="Toggle dark/light mode"></i>
      <i class='bx bx-bell'></i>
      <img src="assets/images/avatar.png" alt="" class="profile" />
      <div id="networkStatus" style="padding: 8px; font-weight: bold; font-size: 11px;"></div>
    </div>
    <div class="dropdown-menu" id="navbarDropdownMenu">
      <button class="dropdown-item"><i class="bi bi-grid"></i> Notification</button>
      <button class="dropdown-item" id="themeToggleDropdown"><i class='bx bx-sun'></i> Theme</button>
      <button class="dropdown-item"><img src="assets/images/avatar.png" alt="" class="profile" style="margin-right:8px;"> Profile</button>
      <div class="dropdown-item" id="networkStatusMobile" style="padding: 8px; font-weight: bold; font-size: 11px;"></div>
    </div>
  </nav>
  <script>
    // Network status
    function updateStatus() {
      const statusDiv = document.getElementById("networkStatus");
      const statusDivMobile = document.getElementById("networkStatusMobile");
      const online = navigator.onLine;
      if (statusDiv) {
        statusDiv.textContent = online ? "🟢 ONLINE" : "🔴 OFFLINE";
        statusDiv.style.color = online ? "green" : "red";
      }
      if (statusDivMobile) {
        statusDivMobile.textContent = online ? "🟢 ONLINE" : "🔴 OFFLINE";
        statusDivMobile.style.color = online ? "green" : "red";
      }
    }
    window.addEventListener("online", updateStatus);
    window.addEventListener("offline", updateStatus);
    document.addEventListener("DOMContentLoaded", updateStatus);

    // Dropdown for mobile
    const dropdownBtn = document.getElementById('navbarDropdown');
    const dropdownMenu = document.getElementById('navbarDropdownMenu');
    dropdownBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdownMenu.classList.toggle('show');
    });
    // Optional: close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.remove('show');
      }
    });

    // Dark/Light mode toggle
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      document.getElementById('mainNavbar').classList.toggle('dark-mode');
      dropdownMenu.classList.toggle('dark-mode');
      // Save preference
      if(document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
      } else {
        localStorage.setItem('theme', 'light');
      }
    }
    // Icon in navbar
    document.getElementById('darkLight').addEventListener('click', toggleDarkMode);
    // Theme button in dropdown
    document.getElementById('themeToggleDropdown').addEventListener('click', function() {
      toggleDarkMode();
      dropdownMenu.classList.remove('show');
    });
    // On load, set theme from localStorage
    document.addEventListener('DOMContentLoaded', function() {
      const theme = localStorage.getItem('theme');
      if(theme === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById('mainNavbar').classList.add('dark-mode');
        dropdownMenu.classList.add('dark-mode');
      }
    });
  </script>
`);