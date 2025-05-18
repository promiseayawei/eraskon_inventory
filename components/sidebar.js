document.write(`
  <!-- Sidebar -->
  <nav class="sidebar">
    <div class="menu_content">
      <ul class="menu_items">
        <div class="menu_title menu_dahsboard"></div>

        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink_icon"><i class="bx bx-home-alt"></i></span>
            <span class="navlink">Home</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu">
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
          </ul>
        </li>

        <li class="item">
          <div href="#" class="nav_link submenu_item">
            <span class="navlink_icon"><i class="bx bx-grid-alt"></i></span>
            <span class="navlink">Overview</span>
            <i class="bx bx-chevron-right arrow-left"></i>
          </div>
          <ul class="menu_items submenu">
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
            <a href="#" class="nav_link sublink">Nav Sub Link</a>
          </ul>
        </li>
      </ul>

      <ul class="menu_items">
        <div class="menu_title menu_editor"></div>
        <li class="item">
          <a href="#" class="nav_link">
            <span class="navlink_icon"><i class="bx bxs-magic-wand"></i></span>
            <span class="navlink">Products</span>
          </a>
        </li>
        <li class="item">
          <a href="#" class="nav_link">
            <span class="navlink_icon"><i class="bx bx-loader-circle"></i></span>
            <span class="navlink">Sales</span>
          </a>
        </li>
        <li class="item">
          <a href="#" class="nav_link">
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
      </ul>

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
