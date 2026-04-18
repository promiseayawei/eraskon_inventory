// ============================================================
// SIDEBAR — injected via insertAdjacentHTML
// BUG FIXES:
//   1. Section containers now get .open after render
//      → was: max-height 0 forever, everything invisible
//   2. Empty section cleanup uses correct DOM traversal
//      → was: closest() can't find siblings, never cleaned up
//   3. Dropdown outside-click delegated once at module level
//      → was: new listener per item per call, memory leak
//   4. Restored .menu_content scroll wrapper
//      → was: dropped, sidebar overflow:hidden clipped content
// ============================================================

const CONFIG = {
    permissions: {
        dashboard: {
            'store.html':         { roles: ['admin','sales','inventory'],                        icon: 'bx-store',           label: 'Store'             },
            'order-invoice.html': { roles: ['admin','sales','finance'],                          icon: 'bx-receipt',         label: 'Orders & Invoices' },
            'product.html':       { roles: ['admin','inventory','warehouse'],                    icon: 'bx-box',             label: 'Products'          },
            'customer.html':      { roles: ['admin','sales','finance'],                          icon: 'bx-user',            label: 'Customers'         },
            'report.html':        { roles: ['admin','sales','inventory','warehouse','finance'],   icon: 'bx-bar-chart-alt',   label: 'Reports'           },
            'setting.html':       { roles: ['admin'],                                            icon: 'bx-cog',             label: 'Settings'          },
            'chairman.html':      { roles: ['chairman','admin'],                                 icon: 'bx-briefcase-alt-2', label: 'Chairman Overview' },
        },
        admin: {
            'user.html':            { roles: ['admin'],                         icon: 'bx-user-circle',  label: 'Users'            },
            'roles.html':           { roles: ['admin'],                         icon: 'bx-shield',       label: 'Roles'            },
            'warehouse.html':       { roles: ['admin','inventory'],             icon: 'bx-buildings',    label: 'Warehouses'       },
            'stock.html':           { roles: ['admin','inventory','warehouse'],  icon: 'bx-transfer',     label: 'Stock Management' },
            'stats.html':           { roles: ['admin','finance'],               icon: 'bx-pie-chart',    label: 'Statistics'       },
            'category.html':        { roles: ['admin','sales','inventory'],      icon: 'bx-list-ul',      label: 'Categories'       },
            'product-variant.html': { roles: ['admin','inventory'],             icon: 'bx-layer',        label: 'Product Variants' },
            'approve.html':         { roles: ['admin','finance'],               icon: 'bx-check-circle', label: 'Approvals'        },
            'logistics.html':       { roles: ['admin','sales','warehouse'],      icon: 'bx-package',      label: 'Logistics'        },
        },
        operations: {
            'sale.html':           { roles: ['admin','sales'],                  icon: 'bx-cart',         label: 'Sales'         },
            'shipping.html':       { roles: ['admin','sales','warehouse'],       icon: 'bx-send',         label: 'Shipping'      },
            'stock-movement.html': { roles: ['admin','inventory','warehouse'],   icon: 'bx-transfer-alt', label: 'Stock Movement'},
        },
    },
};

// ── Auth guard ────────────────────────────────────────────────
(function () {
    if (!localStorage.getItem('name') || !localStorage.getItem('role')) {
        window.location.href = 'index.html';
    }
})();

// ── Inject markup ─────────────────────────────────────────────
(function () {
    const script = document.currentScript;
    const html = `
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<style id="sidebar-style">
:root{
  --sb-bg:        linear-gradient(180deg,#1e3a8a 0%,#172d6e 100%);
  --sb-glow:      0 0 32px 0 rgba(59,130,246,0.4);
  --sb-pill:      linear-gradient(90deg,#3b82f6,#9333ea);
  --sb-pill-glow: 0 0 12px 2px rgba(59,130,246,0.5);
  --sb-avatar:    linear-gradient(135deg,#3b82f6,#9333ea);
  --sb-div:       rgba(59,130,246,0.13);
  --sb-link:      #e0e7ff;
  --sb-link-h:    #fff;
  --sb-label:     #a5b4fc;
  --sb-tip-bg:    #172554;
  --sb-tip-txt:   #e0e7ff;
  --sb-font:      'DM Sans',sans-serif;
  --sb-ease:      cubic-bezier(0.4,0,0.2,1);
  --sb-spring:    cubic-bezier(0.34,1.56,0.64,1);
}
.sidebar{font-family:var(--sb-font);position:fixed;top:0;left:0;height:100vh;width:260px;background:var(--sb-bg);box-shadow:var(--sb-glow);border-right:1.5px solid var(--sb-div);z-index:999;display:flex;flex-direction:column;overflow:hidden;transition:width .28s var(--sb-ease);}
.sidebar.close{width:70px;}
.sidebar-header{display:flex;align-items:center;gap:10px;padding:0 14px;min-height:64px;flex-shrink:0;border-bottom:1.5px solid var(--sb-div);font-size:16px;font-weight:700;color:#fff;letter-spacing:.04em;}
.sidebar-logo-icon{font-size:24px;color:#60a5fa;flex-shrink:0;}
.sidebar-logo-text{flex:1;white-space:nowrap;overflow:hidden;transition:opacity .2s;}
.sidebar.close .sidebar-logo-text{opacity:0;pointer-events:none;}
#sidebarToggle{font-size:22px;cursor:pointer;color:#a5b4fc;padding:6px;border-radius:6px;flex-shrink:0;transition:background .15s,color .15s,transform .28s var(--sb-ease);line-height:1;}
#sidebarToggle:hover{background:#312e81;color:#fff;}
.sidebar.close #sidebarToggle{transform:rotate(180deg);}
.user_info-animated{display:flex;align-items:center;gap:12px;padding:16px 18px 12px;flex-shrink:0;border-bottom:1px solid rgba(255,255,255,.10);}
.sidebar-avatar{width:38px;height:38px;border-radius:50%;flex-shrink:0;background:var(--sb-avatar);color:#fff;font-size:1.05rem;font-weight:700;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(59,130,246,.35);text-transform:uppercase;letter-spacing:.04em;transition:box-shadow .2s;}
.user_info-animated:hover .sidebar-avatar{box-shadow:0 3px 14px rgba(59,130,246,.6);}
.user-info-text{display:flex;flex-direction:column;gap:2px;min-width:0;}
.user-info-text strong{font-weight:600;font-size:13px;color:#a5b4fc;}
.user-info-text span{font-size:13px;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

/* FIX 4: restored scroll wrapper */
.menu_content{flex:1;overflow-y:auto;overflow-x:hidden;padding:6px 0 8px;}
.menu_content::-webkit-scrollbar{width:3px;}
.menu_content::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:3px;}

.sidebar-section-label{font-size:10.5px;color:var(--sb-label);text-transform:uppercase;letter-spacing:.13em;padding:14px 18px 4px;font-weight:600;pointer-events:none;user-select:none;white-space:nowrap;overflow:hidden;transition:opacity .2s;}
.sidebar.close .sidebar-section-label{opacity:0;pointer-events:none;}

.sidebar .nav_link {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 4px 15px;
    border-radius: 8px;
    text-decoration: none;
    color: #cbcdde;
    white-space: nowrap;
    gap: 10px;
    margin: 1px 8px;
    font-size: 13.5px;
    font-weight: 500;
    cursor: pointer;
    user-select: none;
    position: relative;
    overflow: hidden;
    transition: background .15s, color .15s;
}
.nav_link:hover{background:rgba(59,130,246,.10);color:var(--sb-link-h);}
.navlink_icon{font-size:19px;width:22px;height:22px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.navlink{flex:1;overflow:hidden;transition:opacity .2s;}
.sidebar.close .navlink{opacity:0;pointer-events:none;}
.sidebar.close .nav_link{justify-content:center;}

.nav_link .rpl{position:absolute;border-radius:50%;background:rgba(255,255,255,.15);pointer-events:none;transform:scale(0);animation:rpl .5s linear forwards;}
@keyframes rpl{to{transform:scale(5);opacity:0;}}

a.nav_link.active{background:rgba(59,130,246,.14);color:#fff;font-weight:700;box-shadow:0 2px 8px rgba(59,130,246,.2);}
a.nav_link.active::before{content:'';position:absolute;left:6px;top:6px;bottom:6px;width:5px;border-radius:5px;background:var(--sb-pill);box-shadow:var(--sb-pill-glow);}

/* Tooltip */
.nav_link[data-tip]{position:relative;}
.nav_link[data-tip]::after{content:attr(data-tip);position:absolute;left:calc(100% + 10px);top:50%;transform:translateY(-50%) translateX(-5px);background:var(--sb-tip-bg);color:var(--sb-tip-txt);font-size:12px;font-weight:500;font-family:var(--sb-font);padding:5px 10px;border-radius:6px;white-space:nowrap;border:1px solid rgba(255,255,255,.1);box-shadow:0 4px 14px rgba(0,0,0,.35);opacity:0;pointer-events:none;transition:opacity .13s,transform .13s;z-index:9999;}
.sidebar.close .nav_link[data-tip]:hover::after{opacity:1;transform:translateY(-50%) translateX(0);}

/* FIX 1: section containers — use .section-list (NOT .submenu) so they
   don't start at max-height:0. They get .open added by JS after render. */
ul.section-list{list-style:none;padding:0;margin:0;max-height:0;overflow:hidden;transition:max-height .35s var(--sb-ease);}
ul.section-list.open{max-height:1000px;}

ul.section-list.open li{animation:sbFade .2s var(--sb-ease) both;}
ul.section-list.open li:nth-child(1){animation-delay:.02s;}
ul.section-list.open li:nth-child(2){animation-delay:.05s;}
ul.section-list.open li:nth-child(3){animation-delay:.08s;}
ul.section-list.open li:nth-child(4){animation-delay:.11s;}
ul.section-list.open li:nth-child(5){animation-delay:.14s;}
ul.section-list.open li:nth-child(6){animation-delay:.17s;}
ul.section-list.open li:nth-child(7){animation-delay:.20s;}
ul.section-list.open li:nth-child(8){animation-delay:.23s;}
ul.section-list.open li:nth-child(9){animation-delay:.26s;}
@keyframes sbFade{from{opacity:0;transform:translateX(-8px);}to{opacity:1;transform:none;}}

.nav_link.sublink{padding-left:42px;font-size:13px;}
.sidebar.close .nav_link.sublink{padding-left:14px;}

/* Inline sub-dropdown */
ul.sub-dropdown{
    list-style:none;
    padding:0;
    margin:0 0 0 20px;
    max-height:0;
    overflow:hidden;
    transition:max-height .35s var(--sb-spring);
    background: var(--sb-bg);
    border-radius: 10px;
    box-shadow: 0 4px 18px 0 rgba(59,130,246,0.10), 0 1.5px 0 #1e3a8a44;
    border: 1px solid #23336e;
}
ul.sub-dropdown.open{
    max-height:400px;
    transition:max-height .5s var(--sb-spring);
}
ul.sub-dropdown li{
    animation:sbFade .2s var(--sb-ease) both;
}
ul.sub-dropdown.open li:nth-child(1){animation-delay:.03s;}
ul.sub-dropdown.open li:nth-child(2){animation-delay:.06s;}
ul.sub-dropdown.open li:nth-child(3){animation-delay:.09s;}
   ul.sub-dropdown .nav_link.sublink {
       background: transparent;
       color: #f3f4fa;
       border-radius: 8px;
       margin: 2px 6px;
       transition: background .15s, color .15s;
   }
   ul.sub-dropdown .nav_link.sublink:hover, ul.sub-dropdown .nav_link.sublink.active {
       background: #3b82f6;
       color: #fff;
   }

.dropdown-chevron{font-size:15px;margin-left:auto;flex-shrink:0;transition:transform .22s var(--sb-spring);color:#a5b4fc;pointer-events:none;}
.dropdown-toggle.open .dropdown-chevron{transform:rotate(180deg);}
.sidebar.close .dropdown-chevron{display:none;}

/* Logout */
.sidebar-actions{flex-shrink:0;padding:8px 6px 10px;border-top:1px solid var(--sb-div);}
#logoutBtn{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:8px;cursor:pointer;color:#f87171;font-family:var(--sb-font);font-size:13.5px;font-weight:600;transition:background .15s,color .15s;white-space:nowrap;overflow:hidden;}
#logoutBtn:hover{background:rgba(239,68,68,.12);color:#fca5a5;}
#logoutBtn i{font-size:19px;flex-shrink:0;}
.logout-label{overflow:hidden;transition:opacity .2s;}
.sidebar.close #logoutBtn{justify-content:center;padding:10px 0;}
.sidebar.close .logout-label{opacity:0;pointer-events:none;}

.main-content{margin-left:260px;transition:margin-left .28s var(--sb-ease);}
.main-content.sb-closed{margin-left:70px;}

#sidebarBackdrop{display:none;position:fixed;inset:0;background:rgba(8,20,58,.6);z-index:998;backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px);}
#sidebarBackdrop.open{display:block;}

@media(max-width:768px){
  .sidebar{transform:translateX(-105%);transition:transform .32s var(--sb-spring);width:280px!important;z-index:1400;box-shadow:6px 0 32px rgba(14,42,102,.45);}
  .sidebar.mobile-open{transform:translateX(0);}
  .sidebar.close{width:280px!important;transform:translateX(-105%);}
  .sidebar.close.mobile-open{transform:translateX(0);}
  .sidebar.close .sidebar-logo-text,.sidebar.close .navlink,.sidebar.close .logout-label{opacity:1;pointer-events:auto;}
  .sidebar.close .nav_link{justify-content:flex-start;}
  .sidebar.close .nav_link.sublink{padding-left:42px;}
  .sidebar.close .user-info-text{display:flex;}
  .sidebar.close #logoutBtn{justify-content:flex-start;padding:10px 14px;}
  .sidebar.close .logout-label{opacity:1;}
  .sidebar.close .dropdown-chevron{display:flex;}
  .sidebar.close .sidebar-section-label{opacity:1;}
  [data-tip]::after{display:none;}
  .main-content,.main-content.sb-closed{margin-left:0!important;}
  #sidebarToggle{color:#a5b4fc;transform:none!important;}
  #sidebarToggle:hover{color:#f87171;background:rgba(239,68,68,.12);}
}
</style>

<div id="sidebarBackdrop"></div>

<nav class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <i class="bx bx-store-alt sidebar-logo-icon"></i>
    <span class="sidebar-logo-text">Dashboard</span>
    <i id="sidebarToggle" class="bx bx-chevron-left" title="Toggle sidebar"></i>
  </div>

  <div class="user_info-animated">
    <div class="sidebar-avatar" id="sidebarAvatar">--</div>
    <div class="user-info-text">
      <strong id="sidebarUserName">—</strong>
      <span id="sidebarUserRole">—</span>
      <span id="sidebarUserWarehouse">—</span>
    </div>
  </div>

  <div class="menu_content">
    <div class="sidebar-section-label dashboard-label">Dashboard</div>
    <ul class="section-list dashboard-links"></ul>

    <div class="sidebar-section-label admin-label">Admin</div>
    <ul class="section-list admin-links"></ul>

    <div class="sidebar-section-label operations-label">Operations</div>
    <ul class="section-list operations-links"></ul>
  </div>

  <div class="sidebar-actions">
    <div id="logoutBtn">
      <i class="bx bx-power-off"></i>
      <span class="logout-label">Logout</span>
    </div>
  </div>
</nav>`;

    if (script && script.parentNode) {
        script.insertAdjacentHTML('afterend', html);
    } else {
        document.write(html);
    }
})();

// ── Helpers ───────────────────────────────────────────────────
function capitalizeWords(str) {
    if (!str) return '—';
    return String(str).toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
}
function getInitials(name) {
    if (!name) return '--';
    const parts = name.trim().split(/\s+/);
    return parts.length === 1 ? parts[0].slice(0,2).toUpperCase() : (parts[0][0] + parts[1][0]).toUpperCase();
}
function addRipple(el, e) {
    const r = el.getBoundingClientRect(), sz = Math.max(r.width, r.height);
    const sp = document.createElement('span');
    sp.className = 'rpl';
    Object.assign(sp.style, { width: sz+'px', height: sz+'px', left: (e.clientX-r.left-sz/2)+'px', top: (e.clientY-r.top-sz/2)+'px' });
    el.appendChild(sp);
    sp.addEventListener('animationend', () => sp.remove());
}

// FIX 3: single delegated outside-click listener — registered once, not in a loop
document.addEventListener('click', function(e) {
    if (e.target.closest('.dropdown-toggle')) return;
    document.querySelectorAll('.sub-dropdown.open').forEach(ul => {
        ul.classList.remove('open');
        ul.previousElementSibling?.classList.remove('open');
    });
});

// ── Wire up ───────────────────────────────────────────────────
function _initSidebar() {
    const role      = localStorage.getItem('role') || '';
    const name      = localStorage.getItem('name') || '';
    let   warehouse = localStorage.getItem('warehouse') || '';
    try { const u = JSON.parse(localStorage.getItem('user') || '{}'); if (u?.warehouse?.name) warehouse = u.warehouse.name; } catch(_) {}

    const $ = id => document.getElementById(id);
    $('sidebarUserName').textContent      = capitalizeWords(name);
    $('sidebarUserRole').textContent      = capitalizeWords(role);
    $('sidebarUserWarehouse').textContent = capitalizeWords(warehouse);
    $('sidebarAvatar').textContent        = getInitials(name);

    const sidebar     = $('sidebar');
    const toggleBtn   = $('sidebarToggle');
    const mainContent = document.querySelector('.main-content');
    const backdrop    = $('sidebarBackdrop');
    const currentPage = window.location.pathname.split('/').pop() || '';

    if (!sidebar || !toggleBtn) return;

    let manuallyCollapsed = false, hoverExpanded = false;

    function setVisualState(c) {
        sidebar.classList.toggle('close', c);
        mainContent?.classList.toggle('sb-closed', c);
        document.getElementById('navbar')?.classList.toggle('sb-closed', c);
    }

    const isMobile  = () => window.innerWidth <= 768;
    const isMobOpen = () => sidebar.classList.contains('mobile-open');
    function openMobile()  { sidebar.classList.add('mobile-open');    backdrop?.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeMobile() { sidebar.classList.remove('mobile-open'); backdrop?.classList.remove('open'); document.body.style.overflow = ''; }

    backdrop?.addEventListener('click', closeMobile);
    sidebar.addEventListener('click', e => { if (isMobile() && e.target.closest('a.nav_link')) closeMobile(); });

    window.toggleSidebar = function() {
        if (isMobile()) { isMobOpen() ? closeMobile() : openMobile(); return; }
        hoverExpanded = false; manuallyCollapsed = !manuallyCollapsed; setVisualState(manuallyCollapsed);
    };
    toggleBtn.addEventListener('click', e => { e.stopPropagation(); if (isMobile()) { closeMobile(); return; } window.toggleSidebar(); });
    document.addEventListener('click', e => { if (e.target.closest('#sidebarOpen')) { e.stopPropagation(); window.toggleSidebar(); } });
    sidebar.addEventListener('mouseenter', () => { if (isMobile() || !manuallyCollapsed || hoverExpanded) return; hoverExpanded = true; setVisualState(false); });
    sidebar.addEventListener('mouseleave', () => { if (isMobile() || !hoverExpanded) return; hoverExpanded = false; setVisualState(true); });

    function renderLinks(sectionKey) {
        const container = document.querySelector('.' + sectionKey + '-links');
        // FIX 2: label element is a known sibling — target it directly by class
        const label     = document.querySelector('.' + sectionKey + '-label');
        if (!container) return;

        const section = CONFIG.permissions[sectionKey] || {};
        let hasItems = false;

        for (const [href, entry] of Object.entries(section)) {
            if (!entry.roles.includes(role)) continue;
            const li = document.createElement('li');

            if (entry.submenu) {
                // Dropdown parent
                const toggle = document.createElement('div');
                toggle.className = 'nav_link sublink dropdown-toggle' + (currentPage === href ? ' active' : '');
                toggle.setAttribute('data-tip', entry.label);
                toggle.innerHTML =
                    '<span class="navlink_icon"><i class="bx ' + entry.icon + '"></i></span>' +
                    '<span class="navlink">' + entry.label + '</span>' +
                    '<i class="bx bx-chevron-down dropdown-chevron"></i>';
                li.appendChild(toggle);

                const subUl = document.createElement('ul');
                subUl.className = 'sub-dropdown';
                let subHas = false;

                for (const [subHref, sub] of Object.entries(entry.submenu)) {
                    if (!sub.roles.includes(role)) continue;
                    const subLi = document.createElement('li');
                    const subA  = document.createElement('a');
                    subA.href      = subHref;
                    subA.className = 'nav_link sublink' + (currentPage === subHref ? ' active' : '');
                    subA.setAttribute('data-tip', sub.label);
                    subA.innerHTML =
                        '<span class="navlink_icon"><i class="bx ' + sub.icon + '"></i></span>' +
                        '<span class="navlink">' + sub.label + '</span>';
                    subA.addEventListener('click', e => addRipple(subA, e));
                    subLi.appendChild(subA);
                    subUl.appendChild(subLi);
                    subHas = true;
                }

                if (subHas) {
                    li.appendChild(subUl);
                    // Auto-open if a child is the current page
                    if (subUl.querySelector('a.active')) { subUl.classList.add('open'); toggle.classList.add('open'); }

                    toggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        addRipple(this, e);
                        const isOpen = subUl.classList.contains('open');
                        // Close other open sub-dropdowns
                        document.querySelectorAll('.sub-dropdown.open').forEach(ul => {
                            if (ul !== subUl) { ul.classList.remove('open'); ul.previousElementSibling?.classList.remove('open'); }
                        });
                        subUl.classList.toggle('open', !isOpen);
                        this.classList.toggle('open', !isOpen);
                    });
                }

                container.appendChild(li);
                hasItems = true;
                continue;
            }

            // Normal link
            const link = document.createElement('a');
            link.href      = href;
            link.className = 'nav_link sublink' + (currentPage === href ? ' active' : '');
            link.setAttribute('data-tip', entry.label);
            link.innerHTML =
                '<span class="navlink_icon"><i class="bx ' + entry.icon + '"></i></span>' +
                '<span class="navlink">' + entry.label + '</span>';
            link.addEventListener('click', e => addRipple(link, e));
            li.appendChild(link);
            container.appendChild(li);
            hasItems = true;
        }

        if (hasItems) {
            // FIX 1: open the container so items are actually visible
            container.classList.add('open');
        } else {
            // FIX 2: remove both the container and its correctly-targeted label
            container.remove();
            label?.remove();
        }
    }

    renderLinks('dashboard');
    renderLinks('admin');
    renderLinks('operations');

    $('logoutBtn')?.addEventListener('click', () => {
        if (confirm('Are you sure you want to logout?')) { localStorage.clear(); window.location.href = 'index.html'; }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', _initSidebar);
} else {
    _initSidebar();
}