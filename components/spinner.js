(function () {
  if (window.__spinnerLoaded) return;
  window.__spinnerLoaded = true;

  document.write(`
    <style>
      #loadingSpinner {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        z-index: 9999;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        transition: opacity 0.5s ease;
      }

      .circle-spinner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 18px;
      }

      .circle-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        gap: 12px;
        width: 48px;
        height: 48px;
        margin: 0 auto;
      }
      .circle-grid .circle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #007bff;
        opacity: 0.7;
        animation: circle-bounce 1.2s infinite;
      }
      .circle-grid .circle:nth-child(1) {
        grid-column: 1; grid-row: 1;
        animation-delay: 0s;
      }
      .circle-grid .circle:nth-child(2) {
        grid-column: 2; grid-row: 1;
        animation-delay: 0.2s;
      }
      .circle-grid .circle:nth-child(3) {
        grid-column: 2; grid-row: 2;
        animation-delay: 0.4s;
      }
      /* The fourth grid cell is empty for a square shape */

      @keyframes circle-bounce {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.4); opacity: 1; }
      }

      .loading-text {
        color: #007bff;
        font-weight: bold;
        margin-top: 1em;
      }
    </style>

    <div id="loadingSpinner">
      <div class="circle-spinner">
        <div class="circle-grid">
          <div class="circle"></div>
          <div class="circle"></div>
          <div></div>
          <div class="circle"></div>
        </div>
        <span id="spinnerText" class="loading-text">Loading...</span>
      </div>
    </div>
  `);

  let spinnerTimeout;

  function showSpinner(message = "Loading...") {
    const el = document.getElementById('loadingSpinner');
    const textEl = document.getElementById('spinnerText');
    if (el && textEl) {
      textEl.textContent = message;
      el.style.display = 'flex';
      el.style.opacity = '1';
      clearTimeout(spinnerTimeout);
      spinnerTimeout = setTimeout(hideSpinner, 10000); // auto-hide after 10s
    }
  }

  function hideSpinner() {
    const el = document.getElementById('loadingSpinner');
    if (el) {
      el.style.opacity = '0';
      setTimeout(() => {
        el.style.display = 'none';
      }, 500);
    }
    clearTimeout(spinnerTimeout);
  }

  window.showSpinner = showSpinner;
  window.hideSpinner = hideSpinner;

  // Axios support
  if (window.axios) {
    axios.interceptors.request.use(config => {
      showSpinner();
      return config;
    }, error => {
      hideSpinner();
      return Promise.reject(error);
    });

    axios.interceptors.response.use(response => {
      hideSpinner();
      return response;
    }, error => {
      hideSpinner();
      return Promise.reject(error);
    });
  }

  // Fetch support
  const originalFetch = window.fetch;
  window.fetch = async (...args) => {
    showSpinner();
    try {
      const res = await originalFetch(...args);
      return res;
    } catch (e) {
      throw e;
    } finally {
      hideSpinner();
    }
  };
})();

