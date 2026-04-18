// ============================================================
// NAVBAR — programmatic injection, mobile-responsive.
// #sidebarOpen click is handled entirely by sidebar.js.
// ============================================================

(function () {
    const html = `
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<style id="navbar-style">
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    height: 60px;
    background: #344f9f;
    box-shadow: 0 2px 12px rgba(59,130,246,0.10);
    position: sticky;
    top: 0;
    z-index: 1000;
    gap: 12px;
    border-bottom: 1.5px solid rgba(59,130,246,0.13);
  }

  /* ── Left: hamburger + brand ── */
  .navbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
  }

  #sidebarOpen {
    font-size: 26px;
    cursor: pointer;
    color: #eff6ff;
    line-height: 1;
    flex-shrink: 0;
    padding: 4px;
    border-radius: 6px;
    transition: background 0.15s;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
  }
  #sidebarOpen:hover { background: #eff6ff; }

  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
  }
  .navbar-brand img {
    height: 32px;
    width: 32px;
    object-fit: contain;
    flex-shrink: 0;
  }
  .navbar-brand-name {
    font-size: 15px;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    letter-spacing: 0.04em;
    text-shadow: 0 1px 8px rgba(59,130,246,0.10);
  }

  /* ── Right: status + user ── */
  .navbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-shrink: 0;
  }

  .nav-network-badge {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    white-space: nowrap;
  }
  .nav-network-badge .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #10b981;
    flex-shrink: 0;
  }
  .nav-network-badge.offline .dot { background: #ef4444; }

  /* User chip */
  .nav-user-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 4px 10px 4px 4px;
    border-radius: 24px;
    background: rgba(59,130,246,0.10);
    border: 1px solid rgba(59,130,246,0.18);
    cursor: pointer;
    transition: background 0.15s, border 0.15s;
    -webkit-tap-highlight-color: transparent;
  }
  .nav-user-chip:hover { background: rgba(59,130,246,0.18); border-color: #9333ea; }
  .nav-user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg,#3b82f6,#9333ea);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(59,130,246,0.10);
  }
  .nav-user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
  }
  .nav-user-name {
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    max-width: 110px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-shadow: 0 1px 8px rgba(59,130,246,0.10);
  }
  .nav-user-role {
    font-size: 10px;
    color: #c7d2fe;
    text-transform: capitalize;
  }

  /* ── Mobile ── */
  @media (max-width: 768px) {
    .navbar { padding: 0 12px; height: 56px; }
    .navbar-brand { gap: 6px; min-width: 0; }
    .navbar-brand img { height: 28px; width: 28px; }
    .navbar-brand-name {
      display: block;
      font-size: 11px;
      letter-spacing: 0.02em;
      max-width: 135px;
      line-height: 1.05;
    }
    .nav-network-badge { display: none; }
    .nav-user-info { display: none; }
    .nav-user-chip {
      padding: 4px;
      border-radius: 50%;
      background: none;
      border: none;
    }
    .nav-user-chip:hover { background: #f1f5f9; border: none; }
  }
</style>

<nav class="navbar" id="mainNavbar">
  <div class="navbar-left">
  
    <i class="bx bx-menu" id="sidebarOpen" title="Toggle sidebar"></i>
    <div class="navbar-brand">
      <img src="assets/images/eraskon_logo.webp" alt="Eraskon">
      <span class="navbar-brand-name">Eraskon Nigeria Ltd</span>
    </div>
  </div>

  <div class="navbar-right">
    <div class="nav-network-badge" id="networkBadge">
      <span class="dot" id="netDot"></span>
      <span id="netText">Checking…</span>
    </div>
    <div class="nav-user-chip" id="navUserChip" title="Logged in user">
      <div class="nav-user-avatar" id="navAvatar">?</div>
      <div class="nav-user-info">
        <span class="nav-user-name" id="navUserName">Loading…</span>
        <span class="nav-user-role" id="navUserRole"></span>
      </div>
    </div>
  </div>
</nav>`;

    const script = document.currentScript;
    if (script && script.parentNode) {
        script.insertAdjacentHTML('afterend', html);
    } else {
        const attach = () => document.body.insertAdjacentHTML('afterbegin', html);
        document.readyState === 'loading'
            ? document.addEventListener('DOMContentLoaded', attach)
            : attach();
    }
})();

// ── Wire up after DOM ready ───────────────────────────────────
(function () {
    function run() {
        // ── Network status ────────────────────────────────────
        const badge   = document.getElementById('networkBadge');
        const dot     = document.getElementById('netDot');
        const netText = document.getElementById('netText');

        function updateNet() {
            const online = navigator.onLine;
            if (badge)   badge.classList.toggle('offline', !online);
            if (dot)     dot.style.background = online ? '#10b981' : '#ef4444';
            if (netText) netText.textContent   = online ? 'Online' : 'Offline';
        }
        window.addEventListener('online',  updateNet);
        window.addEventListener('offline', updateNet);
        updateNet();

        // ── User info from localStorage ───────────────────────
        const name = localStorage.getItem('name') || localStorage.getItem('firstName') || '';
        const role = localStorage.getItem('role') || '';
        const initials = name.trim().split(/\s+/).map(w => w[0]).join('').slice(0, 2) || '?';

        const avatar   = document.getElementById('navAvatar');
        const userName = document.getElementById('navUserName');
        const userRole = document.getElementById('navUserRole');
        if (avatar)   avatar.textContent   = initials.toUpperCase();
        if (userName) userName.textContent = name || 'User';
        if (userRole) userRole.textContent = role;

        // #sidebarOpen click is owned by sidebar.js — no listener here.
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }
})();
