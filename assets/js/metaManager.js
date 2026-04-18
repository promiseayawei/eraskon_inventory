// metaManager.js
function setMeta({ title, description, favicon }) {
  // Set document title
  document.title = title || "Default Title";

  // Set or update meta description
  let descMeta = document.querySelector('meta[name="description"]');
  if (!descMeta) {
    descMeta = document.createElement('meta');
    descMeta.setAttribute('name', 'description');
    document.head.appendChild(descMeta);
  }
  descMeta.setAttribute('content', description || "Default description");

  // Set or update favicon
  let iconLink = document.querySelector('link[rel="icon"]');
  if (!iconLink) {
    iconLink = document.createElement('link');
    iconLink.setAttribute('rel', 'icon');
    document.head.appendChild(iconLink);
  }
  iconLink.setAttribute('href', favicon || "/assets/images/eraskon_logo.webp");
}
