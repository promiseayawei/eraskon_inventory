// ==========================
// Meta Manager - Strong SEO
// ==========================
(function(){
  function setMeta({ title, desc, image, url, favicon, keywords, pageType }) {
    if(title) document.title = title;

    const ensure = (name, content, prop=false) => {
      let el;
      if(prop) {
        el = document.querySelector(`meta[property='${name}']`) || document.createElement("meta");
        el.setAttribute('property', name);
      } else {
        el = document.querySelector(`meta[name='${name}']`) || document.createElement("meta");
        el.setAttribute('name', name);
      }
      el.content = content;
      document.head.appendChild(el);
    };

    // Core SEO
    ensure("description", desc || "Eraskon Inventory Management - Secure portal");
    ensure("keywords", keywords || "Inventory Management, Warehouse, Stock, Sales, Eraskon");
    ensure("author", "Ayaweisoft");

    // Open Graph (Facebook, LinkedIn)
    ensure("og:title", title || "Eraskon Inventory", true);
    ensure("og:description", desc || "Manage inventory efficiently.", true);
    ensure("og:image", image || "assets/images/eraskon_logo.webp", true);
    ensure("og:url", url || window.location.href, true);
    ensure("og:type", pageType || "website", true);

    // Twitter Card
    ensure("twitter:card", "summary_large_image");
    ensure("twitter:title", title || "Eraskon Inventory");
    ensure("twitter:description", desc || "Manage inventory efficiently.");
    ensure("twitter:image", image || "assets/images/eraskon_logo.webp");

    // Favicon
    let icon = document.querySelector("link[rel='icon']");
    if(!icon) {
      icon = document.createElement("link");
      icon.rel = "icon";
      document.head.appendChild(icon);
    }
    icon.href = favicon || "assets/images/eraskon_favicon.png";

    // Structured Data (JSON-LD)
    let ld = document.querySelector("script[type='application/ld+json']");
    if(!ld){
      ld = document.createElement("script");
      ld.type = "application/ld+json";
      document.head.appendChild(ld);
    }
    ld.textContent = JSON.stringify({
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": title || "Eraskon Inventory Management",
      "url": url || window.location.href,
      "logo": image || "assets/images/eraskon_logo.webp",
      "applicationCategory": "BusinessApplication",
      "operatingSystem": "Web",
      "description": desc || "Eraskon Inventory Management system to manage stock, sales, and warehouse operations efficiently.",
      "author": {
        "@type": "Organization",
        "name": "Ayaweisoft"
      }
    });
  }

  // Expose globally
  window.setMeta = setMeta;
})();
