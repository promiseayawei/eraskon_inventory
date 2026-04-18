// assets/js/alertMessage.js

window.showAlert = function ({
  title = "Alert",
  message = "",
  confirmText = "OK",
  cancelText = "Cancel",
  onConfirm = null,
  onCancel = null,
  autoClose = 6000,
  playSound = true,
  soundUrl = "https://www.myinstants.com/media/sounds/windows-error.mp3"
}) {
  // Remove any existing alert modal
  const existing = document.getElementById("custom-alert-modal");
  if (existing) existing.remove();

  // Play sound if enabled
  if (playSound && soundUrl) {
    const audio = new Audio(soundUrl);
    audio.volume = 0.7;
    audio.play().catch(e => console.warn("Sound play error:", e));
  }

  const modal = document.createElement("div");
  modal.id = "custom-alert-modal";
  modal.innerHTML = `
    <style>
      #custom-alert-modal {
        position: fixed;
        top: 0; left: 0;
        width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
      }

      .alert-box {
        background: var(--card-bg, #fff);
        color: var(--text-color, #090F3B);
        border: 2px solid #dc2626;
        border-radius: 10px;
        padding: 20px 24px;
        max-width: 460px;
        width: 90%;
        box-shadow: 0 4px 18px rgba(0,0,0,0.25);
        font-family: system-ui, sans-serif;
        animation: popUp 0.3s ease;
        position: relative;
      }

      .alert-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #dc2626;
      }

      .alert-title {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 6px;
      }

      .alert-message {
        margin-bottom: 20px;
        font-size: 0.96rem;
      }

      .alert-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
      }

      .alert-actions button {
        padding: 6px 14px;
        border-radius: 6px;
        border: none;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s ease;
      }

      .alert-actions .confirm {
        background: #ef4444;
        color: white;
      }

      .alert-actions .confirm:hover {
        background: #dc2626;
      }

      .alert-actions .cancel {
        background: #e5e7eb;
        color: #333;
      }

      .alert-actions .cancel:hover {
        background: #d1d5db;
      }

      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }

      @keyframes popUp {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
      }

      @media (max-width: 480px) {
        .alert-box {
          padding: 18px;
        }
        .alert-message {
          font-size: 0.88rem;
        }
      }
    </style>

    <div class="alert-box">
      <div class="alert-icon">⚠️</div>
      <div class="alert-title">${title}</div>
      <div class="alert-message">${message}</div>
      <div class="alert-actions">
        <button class="cancel">${cancelText}</button>
        <button class="confirm">${confirmText}</button>
      </div>
    </div>
  `;

  document.body.appendChild(modal);

  const confirmBtn = modal.querySelector(".confirm");
  const cancelBtn = modal.querySelector(".cancel");

  confirmBtn.addEventListener("click", () => {
    modal.remove();
    if (onConfirm) onConfirm();
  });

  cancelBtn.addEventListener("click", () => {
    modal.remove();
    if (onCancel) onCancel();
  });

  if (autoClose > 0) {
    setTimeout(() => {
      if (document.body.contains(modal)) {
        modal.remove();
        if (onCancel) onCancel();
      }
    }, autoClose);
  }
};
