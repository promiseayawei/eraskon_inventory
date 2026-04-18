// sidebar.js (components/sidebar.js) handles all sidebar toggle,
// hover-expand, submenu, and mobile drawer logic.
// This file retains only the dark-mode toggle.

(function () {
  var body      = document.body;
  var darkLight = document.querySelector('#darkLight');

  if (darkLight) {
    darkLight.addEventListener('click', function () {
      body.classList.toggle('dark');
      if (body.classList.contains('dark')) {
        darkLight.classList.replace('bx-sun', 'bx-moon');
      } else {
        darkLight.classList.replace('bx-moon', 'bx-sun');
      }
    });
  }
})();
