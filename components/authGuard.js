// ======================
// AUTH GUARD FOR ERASKON
// ======================

// ROLE → DEFAULT LANDING PAGE
const defaultLanding = {
  admin: "stats.html",
  inventory: "stock-movement.html",
  sales: "store.html",
  warehouse: "warehouse.html",
  finance: "approve.html",
  chairman: "chairman.html"
};

// PAGE → ALLOWED ROLES
const pagePermissions = {
  // Chairman
  "chairman": ["chairman", "admin"],
  "chairman.html": ["chairman", "admin"],

  // Main pages
  "index": ["admin", "sales", "inventory", "warehouse", "finance"],
  "index.html": ["admin", "sales", "inventory", "warehouse", "finance"],

  "approve": ["admin", "finance"],
  "approve.html": ["admin", "finance"],

  "category": ["admin", "sales", "inventory", "warehouse"],
  "category.html": ["admin", "sales", "inventory", "warehouse"],

  "customer": ["admin", "sales", "finance"],
  "customer.html": ["admin", "sales", "finance"],

  "invoiced": ["admin", "sales", "finance"],
  "invoiced.html": ["admin", "sales", "finance"],

  "logistics": ["admin", "sales", "warehouse"],
  "logistics.html": ["admin", "sales", "warehouse"],

  "order-invoice": ["admin", "sales", "finance"],
  "order-invoice.html": ["admin", "sales", "finance"],

  "product": ["admin", "inventory", "warehouse"],
  "product.html": ["admin", "inventory", "warehouse"],

  "product-variant": ["admin", "inventory", "warehouse"],
  "product-variant.html": ["admin", "inventory", "warehouse"],

  "report": ["admin", "sales", "inventory", "warehouse", "finance"],
  "report.html": ["admin", "sales", "inventory", "warehouse", "finance"],

  "roles": ["admin"],
  "roles.html": ["admin"],

  "sale": ["admin", "sales", "finance"],
  "sale.html": ["admin", "sales", "finance"],

  "shipping": ["admin", "sales", "warehouse"],
  "shipping.html": ["admin", "sales", "warehouse"],

  "stats": ["admin", "sales", "inventory", "warehouse", "finance"],
  "stats.html": ["admin", "sales", "inventory", "warehouse", "finance"],

  "stock": ["admin", "inventory", "warehouse"],
  "stock.html": ["admin", "inventory", "warehouse"],

  "store": ["admin", "sales", "inventory", "warehouse"],
  "store.html": ["admin", "sales", "inventory", "warehouse"],

  "user": ["admin", "finance"],
  "user.html": ["admin", "finance"],

  "warehouse": ["admin", "inventory", "warehouse"],
  "warehouse.html": ["admin", "inventory", "warehouse"],

  "welcome": ["admin", "sales", "inventory", "warehouse", "finance", "chairman"],
  "welcome.html": ["admin", "sales", "inventory", "warehouse", "finance", "chairman"],

  // 🔥 NEW — Fix your LOOP here
  "stock-movement": ["admin", "inventory", "warehouse"],
  "stock-movement.html": ["admin", "inventory", "warehouse"]
};


// ===============
// AUTH GUARD INIT
// ===============
(function () {
  const token = localStorage.getItem("token");
  const userRole = (localStorage.getItem("role") || "").toLowerCase();

  const currentPage = window.location.pathname.split("/").pop() || "index.html";
  const cleanPage = currentPage.replace(".html", "");

  // If no login
  if (!token || !userRole) {
    return (window.location.href = "login.html");
  }

  const isDefault = defaultLanding[userRole] === currentPage;

  const allowedRoles =
    pagePermissions[currentPage] ||
    pagePermissions[cleanPage] ||
    null;

  // If page is not registered → go to allowed page (but prevent looping)
  if (!allowedRoles) {
    if (!isDefault) {
      return (window.location.href = defaultLanding[userRole]);
    }
    return;
  }

  // If role not allowed → redirect (avoid loops)
  if (!allowedRoles.includes(userRole)) {
    if (!isDefault) {
      return (window.location.href = defaultLanding[userRole]);
    }
    return;
  }

  console.log(`Access granted to ${currentPage} (role: ${userRole})`);
})();
