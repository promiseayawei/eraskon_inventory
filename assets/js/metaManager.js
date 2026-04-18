(function () {
  const DEFAULT_FAVICON = "assets/images/eraskon_logo.webp";
  const PAGE_META_MAP = {
    "index.html": {
      title: "Eraskon | Login & Activation",
      description: "Sign in to Eraskon Inventory or activate your account.",
      keywords: "Eraskon, Inventory, Login, Activation",
    },
    "inventory-check.html": {
      title: "Eraskon | Inventory Check",
      description: "Review current stock levels and reorder statuses.",
      keywords: "Inventory, Warehouse, Stock, Reorder",
    },
    "product-variant22.html": {
      title: "Eraskon | Product Variant",
      description: "Access the Eraskon Inventory portal to manage product variants.",
      keywords: "Inventory, Warehouse, Stock, Sales, Product Variant",
    },
  };

  const getPageName = () => {
    const file = window.location.pathname.split("/").pop();
    return file && file.length ? file.toLowerCase() : "index.html";
  };

  const toReadableLabel = (value) => {
    return String(value || "")
      .replace(/\.html$/i, "")
      .replace(/[-_]+/g, " ")
      .replace(/\s+/g, " ")
      .trim();
  };

  const fallbackDescription = (title, pageName) => {
    const subject = toReadableLabel(title).replace(/^Eraskon\s*/i, "").trim() || toReadableLabel(pageName);
    return subject
      ? `Open ${subject} in the Eraskon Inventory system.`
      : "Open the Eraskon Inventory system.";
  };

  const fallbackKeywords = (title, pageName) => {
    const parts = [
      "Eraskon",
      "Inventory",
      toReadableLabel(title).replace(/^Eraskon\s*/i, "").trim(),
      toReadableLabel(pageName),
    ].filter(Boolean);
    return [...new Set(parts)].join(", ");
  };

  const ensureMetaTag = (selector, attrName, attrValue) => {
    let tag = document.querySelector(selector);
    if (!tag) {
      tag = document.createElement("meta");
      tag.setAttribute(attrName, attrValue);
      document.head.appendChild(tag);
    }
    return tag;
  };

  const ensureLinkTag = (selector, relValue) => {
    let tag = document.querySelector(selector);
    if (!tag) {
      tag = document.createElement("link");
      tag.setAttribute("rel", relValue);
      document.head.appendChild(tag);
    }
    return tag;
  };

  const applyMeta = (meta = {}) => {
    const title = meta.title || document.title || "Eraskon";
    const pageName = getPageName();
    const description = meta.description || meta.desc || fallbackDescription(title, pageName);
    const keywords = meta.keywords || fallbackKeywords(title, pageName);
    const favicon = meta.favicon || meta.icon || DEFAULT_FAVICON;
    const image = meta.image || favicon;

    document.title = title;

    if (description) {
      ensureMetaTag('meta[name="description"]', "name", "description").setAttribute("content", description);
      ensureMetaTag('meta[property="og:description"]', "property", "og:description").setAttribute("content", description);
      ensureMetaTag('meta[name="twitter:description"]', "name", "twitter:description").setAttribute("content", description);
    }

    if (keywords) {
      ensureMetaTag('meta[name="keywords"]', "name", "keywords").setAttribute("content", keywords);
    }

    if (title) {
      ensureMetaTag('meta[property="og:title"]', "property", "og:title").setAttribute("content", title);
      ensureMetaTag('meta[name="twitter:title"]', "name", "twitter:title").setAttribute("content", title);
    }

    if (image) {
      ensureMetaTag('meta[property="og:image"]', "property", "og:image").setAttribute("content", image);
      ensureMetaTag('meta[name="twitter:image"]', "name", "twitter:image").setAttribute("content", image);
    }

    ensureLinkTag('link[rel="icon"]', "icon").setAttribute("href", favicon);
    ensureLinkTag('link[rel="shortcut icon"]', "shortcut icon").setAttribute("href", favicon);
  };

  window.setMeta = (meta = {}) => applyMeta(meta);

  const autoApply = () => {
    const pageName = getPageName();
    const pageMeta = window.PAGE_META || PAGE_META_MAP[pageName] || {};
    applyMeta(pageMeta);
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", autoApply);
  } else {
    autoApply();
  }
})();
