(function () {
  const currentPath = window.location.pathname.split('/').pop();

  const pagePermissions = {
    'index.html':        ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'approve.html':      ['admin', 'finance'],
    'category.html':     ['admin', 'sales', 'inventory', 'warehouse'],
    'customer.html':     ['admin', 'sales', 'finance'],
    'invoiced.html':     ['admin', 'sales', 'finance'],
    'logistics.html':    ['admin', 'sales', 'warehouse'],
    'order-invoice.html':['admin', 'sales', 'finance'],
    'product.html':      ['admin', 'inventory', 'warehouse'],
    'product-variant.html': ['admin', 'inventory', 'warehouse'],
    'report.html':       ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'roles.html':        ['admin'],
    'sale.html':         ['admin', 'sales', 'finance'],
    'shipping.html':     ['admin', 'sales', 'warehouse'],
    'stats.html':        ['admin', 'sales', 'inventory', 'warehouse', 'finance'],
    'stock-movement.html': ['admin', 'inventory', 'warehouse'],
    'store.html':        ['admin', 'sales', 'inventory', 'warehouse'],
    'user.html':         ['admin'],
    'warehouse.html':    ['admin', 'inventory', 'warehouse'],
    'welcome.html':      ['admin', 'sales', 'inventory', 'warehouse', 'finance']
  };

  const userRole = localStorage.getItem('role');
  const allowedRoles = pagePermissions[currentPath];

  // Save current page as previous before leaving
  window.addEventListener("beforeunload", () => {
    localStorage.setItem("previousPage", window.location.href);
  });

  if (allowedRoles && !allowedRoles.includes(userRole)) {
    const previous = localStorage.getItem('previousPage');
    const pageName = currentPath || "this page";
    const message = `Access Denied: Your role <b>${userRole || 'unknown'}</b> is not permitted to view <b>${pageName}</b>.`;

    showAlert({
      title: "Unauthorized Access",
      message: message,
      confirmText: "Go Back",
      cancelText: "Exit",
      onConfirm: () => {
        if (previous && previous !== window.location.href) {
          window.location.href = previous;
        }
      },
      onCancel: () => {
        if (previous && previous !== window.location.href) {
          window.location.href = previous;
        }
      }
    });
  }
})();
