// ============================================================
// MOBILE FOOTER TAB BAR — Role-aware bottom navigation
// Everything is built programmatically on DOMContentLoaded —
// no document.write, no insertAdjacentHTML, no timing issues.
// ============================================================

(function () {

  // ── Role → 4 primary shortcuts ───────────────────────────
  var TAB_CONFIG = {
    admin: [
      { href: 'store.html',          icon: 'bx-store',           label: 'Store'     },
      { href: 'product.html',        icon: 'bx-box',             label: 'Products'  },
      { href: 'stock.html',          icon: 'bx-transfer',        label: 'Stock'     },
      { href: 'stats.html',          icon: 'bx-pie-chart',       label: 'Stats'     },
    ],
    sales: [
      { href: 'store.html',          icon: 'bx-store',           label: 'Store'     },
      { href: 'order-invoice.html',  icon: 'bx-receipt',         label: 'Orders'    },
      { href: 'customer.html',       icon: 'bx-user',            label: 'Customers' },
      { href: 'sale.html',           icon: 'bx-cart',            label: 'Sales'     },
    ],
    inventory: [
      // { href: 'stock-movement.html', icon: 'bx-transfer-alt',    label: 'Movement'  },
      { href: 'product.html',        icon: 'bx-box',             label: 'Products'  },
      { href: 'warehouse.html',      icon: 'bx-buildings',       label: 'Warehouses'},
      { href: 'category.html',       icon: 'bx-list-ul',         label: 'Categories'},
    ],
    warehouse: [
      { href: 'warehouse.html',      icon: 'bx-buildings',       label: 'Warehouses'},
      { href: 'stock.html',          icon: 'bx-transfer',        label: 'Stock'     },
      { href: 'shipping.html',       icon: 'bx-send',            label: 'Shipping'  },
      { href: 'logistics.html',      icon: 'bx-package',         label: 'Logistics' },
    ],
    finance: [
      { href: 'approve.html',        icon: 'bx-check-circle',    label: 'Approvals' },
      { href: 'order-invoice.html',  icon: 'bx-receipt',         label: 'Orders'    },
      { href: 'stats.html',          icon: 'bx-pie-chart',       label: 'Stats'     },
      { href: 'customer.html',       icon: 'bx-user',            label: 'Customers' },
    ],
    chairman: [
      { href: 'chairman.html',       icon: 'bx-briefcase-alt-2', label: 'Overview'  },
    ],
  };

  // ── Full link list for the More drawer ────────────────────
  var ALL_LINKS = {
    dashboard: {
      'store.html':          { roles: ['admin','sales','inventory'],                      icon: 'bx-store',           label: 'Store'            },
      'order-invoice.html':  { roles: ['admin','sales','finance'],                        icon: 'bx-receipt',         label: 'Orders & Invoices'},
      'product.html':        { roles: ['admin','inventory','warehouse'],                  icon: 'bx-box',             label: 'Products'         },
      'customer.html':       { roles: ['admin','sales','finance'],                        icon: 'bx-user',            label: 'Customers'        },
      'report.html':         { roles: ['admin','sales','inventory','warehouse','finance'], icon: 'bx-bar-chart-alt',   label: 'Reports'          },
      'chairman.html':       { roles: ['chairman','admin'],                               icon: 'bx-briefcase-alt-2', label: 'Chairman Overview'},
    },
    admin: {
      'user.html':            { roles: ['admin'],                         icon: 'bx-user-circle',  label: 'Users'           },
      'roles.html':           { roles: ['admin'],                         icon: 'bx-shield',       label: 'Roles'           },
      'warehouse.html':       { roles: ['admin','inventory'],             icon: 'bx-buildings',    label: 'Warehouses'      },
      'stock.html':           { roles: ['admin','inventory','warehouse'], icon: 'bx-transfer',     label: 'Stock Management'},
      'stats.html':           { roles: ['admin','finance'],               icon: 'bx-pie-chart',    label: 'Statistics'      },
      'category.html':        { roles: ['admin','sales','inventory'],     icon: 'bx-list-ul',      label: 'Categories'      },
      'product-variant.html': { roles: ['admin','inventory'],             icon: 'bx-layer',        label: 'Product Variants'},
      'approve.html':         { roles: ['admin','finance'],               icon: 'bx-check-circle', label: 'Approvals'       },
      'logistics.html':       { roles: ['admin','sales','warehouse'],     icon: 'bx-package',      label: 'Logistics'       },
    },
    operations: {
      'sale.html':            { roles: ['admin','sales'],                 icon: 'bx-cart',         label: 'Sales'           },
      'shipping.html':        { roles: ['admin','sales','warehouse'],     icon: 'bx-send',         label: 'Shipping'        },
      // 'stock-movement.html':  { roles: ['admin','inventory','warehouse'], icon: 'bx-transfer-alt', label: 'Stock Movement'  },
    },
  };

  // ── Inject CSS once ───────────────────────────────────────
  function injectCSS() {
    if (document.getElementById('footer-tab-style')) return;
    var style = document.createElement('style');
    style.id  = 'footer-tab-style';
    style.textContent = [
      /* hide sidebar margin on mobile */
      '@media (max-width:768px){',
        '.main-content{margin-left:0!important;padding-bottom:72px!important;}',
        '.navbar{left:0!important;}',
      '}',

      /* tab bar — always pinned at bottom, visible on scroll */
      '#mobileTabBar{',
        'display:none;position:fixed;bottom:0;left:0;right:0;height:60px;',
        'background:linear-gradient(90deg,#344f9f 0%,#344f9f 100%);',
        'border-top:1.5px solid rgba(59,130,246,0.13);',
        'box-shadow:0 -2px 18px rgba(59,130,246,0.10);z-index:1100;',
        'padding-bottom:env(safe-area-inset-bottom,0);',
        'pointer-events:auto;',
      '}',
      '@media (max-width:768px){#mobileTabBar{display:flex;}}',

      /* individual tab */
      '.mob-tab{',
        'flex:1;display:flex;flex-direction:column;align-items:center;',
        'justify-content:center;text-decoration:none;color:#e0e7ff;',
        'font-size:10px;font-family:Poppins,sans-serif;gap:2px;',
        'cursor:pointer;border:none;background:none;padding:0;',
        'transition:color .2s,background .2s;-webkit-tap-highlight-color:transparent;',
      '}',
      '.mob-tab i{font-size:22px;line-height:1;}',
      '.mob-tab span{line-height:1;}',
      '.mob-tab.active,.mob-tab:hover{color:#fff;background:rgba(59,130,246,0.18);}',
      '.mob-tab.active i{color:#fff;}',

      /* backdrop — bottom:60px so tab bar stays tappable */
      '#moreDrawerBackdrop{',
        'display:none;position:fixed;top:0;left:0;right:0;bottom:60px;',
        'background:rgba(0,0,0,.35);z-index:1200;',
      '}',
      '#moreDrawerBackdrop.open{display:block;}',

      /* drawer panel */
      '#moreDrawer{',
        'position:fixed;bottom:60px;left:0;right:0;background:#fff;',
        'border-radius:16px 16px 0 0;z-index:1300;max-height:70vh;',
        'overflow-y:auto;transform:translateY(calc(100% + 60px));',
        'transition:transform .3s cubic-bezier(.4,0,.2,1);',
        'box-shadow:0 -4px 20px rgba(0,0,0,.12);',
        'padding-bottom:env(safe-area-inset-bottom,0);',
      '}',
      '#moreDrawer.open{transform:translateY(0);}',

      '.more-drawer-handle{width:36px;height:4px;background:#d1d5db;border-radius:2px;margin:12px auto 4px;cursor:pointer;}',
      '.more-drawer-header{display:flex;align-items:center;justify-content:space-between;padding:4px 20px 0;}',
      '.more-drawer-title{font-size:13px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.06em;padding:8px 0 4px;}',
      '.more-drawer-close{background:none;border:none;font-size:22px;color:#9ca3af;cursor:pointer;padding:4px;line-height:1;-webkit-tap-highlight-color:transparent;}',
      '.more-drawer-close:hover{color:#374151;}',
      '.more-drawer-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:4px;padding:8px 12px 16px;}',
      '.more-drawer-item{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;padding:12px 4px;border-radius:12px;text-decoration:none;color:#374151;font-size:11px;text-align:center;transition:background .15s;-webkit-tap-highlight-color:transparent;}',
      '.more-drawer-item:active,.more-drawer-item.active{background:#3b82f6;color:#fff;}',
      '.more-drawer-item i{font-size:24px;color:#344f9f;}',
      '.more-drawer-logout{display:flex;align-items:center;gap:10px;padding:14px 20px;color:#ef4444;font-size:14px;font-weight:600;cursor:pointer;border-top:1px solid #f3f4f6;margin-top:4px;}',
      '.more-drawer-logout i{font-size:20px;}',
    ].join('');
    (document.head || document.documentElement).appendChild(style);
  }

  // ── Build everything in one shot ──────────────────────────
  function build() {
    injectCSS();

    // resolve role — try every possible storage pattern
    var raw = '';
    ['role', 'userRole', 'user_role'].forEach(function (key) {
      if (!raw) raw = (localStorage.getItem(key) || '').trim();
    });
    if (!raw) {
      try {
        var u = JSON.parse(localStorage.getItem('user') || '{}');
        raw = u.role || u.userRole || '';
      } catch (e) {}
    }
    raw = raw.toLowerCase();

    // match against known keys (handles 'Admin', 'ADMIN', 'administrator', etc.)
    var role = Object.keys(TAB_CONFIG).find(function (k) { return k === raw; })
            || Object.keys(TAB_CONFIG).find(function (k) { return raw.indexOf(k) !== -1; })
            || raw;

    var currentPage = window.location.pathname.split('/').pop() || '';

    // ── Tab bar ───────────────────────────────────────────
    var tabBar = document.createElement('div');
    tabBar.id  = 'mobileTabBar';

    var tabs = TAB_CONFIG[role] || [];
    tabs.forEach(function (t) {
      var a       = document.createElement('a');
      a.href      = t.href;
      a.className = 'mob-tab' + (currentPage === t.href ? ' active' : '');
      a.innerHTML = '<i class="bx ' + t.icon + '"></i><span>' + t.label + '</span>';
      tabBar.appendChild(a);
    });

    // More button
    var moreBtn       = document.createElement('button');
    moreBtn.type      = 'button';
    moreBtn.className = 'mob-tab';
    moreBtn.id        = 'moreTabBtn';
    moreBtn.setAttribute('aria-expanded', 'false');
    moreBtn.innerHTML = '<i class="bx bx-menu"></i><span>More</span>';
    tabBar.appendChild(moreBtn);

    // ── Backdrop ──────────────────────────────────────────
    var backdrop = document.createElement('div');
    backdrop.id  = 'moreDrawerBackdrop';

    // ── Drawer ────────────────────────────────────────────
    var drawer        = document.createElement('div');
    drawer.id         = 'moreDrawer';
    drawer.innerHTML  =
      '<div class="more-drawer-handle" id="moreDrawerHandle"></div>' +
      '<div class="more-drawer-header">' +
        '<span class="more-drawer-title">Menu</span>' +
        '<button type="button" class="more-drawer-close" id="moreDrawerClose" aria-label="Close">' +
          '<i class="bx bx-x"></i>' +
        '</button>' +
      '</div>' +
      '<div class="more-drawer-grid" id="moreDrawerGrid"></div>' +
      '<div class="more-drawer-logout" id="moreDrawerLogout">' +
        '<i class="bx bx-power-off"></i> Logout' +
      '</div>';

    // Populate drawer grid
    var drawerGrid = drawer.querySelector('#moreDrawerGrid');
    Object.keys(ALL_LINKS).forEach(function (section) {
      var links = ALL_LINKS[section];
      Object.keys(links).forEach(function (href) {
        var info = links[href];
        if (info.roles.indexOf(role) === -1) return;
        var item       = document.createElement('a');
        item.href      = href;
        item.className = 'more-drawer-item' + (currentPage === href ? ' active' : '');
        item.innerHTML = '<i class="bx ' + info.icon + '"></i><span>' + info.label + '</span>';
        drawerGrid.appendChild(item);
      });
    });

    // Append all to body
    document.body.appendChild(tabBar);
    document.body.appendChild(backdrop);
    document.body.appendChild(drawer);

    // ── Open / close ──────────────────────────────────────
    function openDrawer() {
      drawer.classList.add('open');
      backdrop.classList.add('open');
      moreBtn.classList.add('active');
      moreBtn.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
      drawer.classList.remove('open');
      backdrop.classList.remove('open');
      moreBtn.classList.remove('active');
      moreBtn.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
    function isOpen() { return drawer.classList.contains('open'); }

    moreBtn.addEventListener('click', function () {
      isOpen() ? closeDrawer() : openDrawer();
    });
    backdrop.addEventListener('click', closeDrawer);
    drawer.querySelector('#moreDrawerClose').addEventListener('click', closeDrawer);
    drawer.querySelector('#moreDrawerHandle').addEventListener('click', function () {
      if (isOpen()) closeDrawer();
    });

    // ── Logout ────────────────────────────────────────────
    drawer.querySelector('#moreDrawerLogout').addEventListener('click', function () {
      if (confirm('Are you sure you want to logout?')) {
        localStorage.clear();
        window.location.href = 'index.html';
      }
    });
  }

  // Run as soon as DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', build);
  } else {
    build();
  }

})();
