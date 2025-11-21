// // ============================================
// // UPDATED SCRIPT.JS - Compatible with New Sidebar
// // ============================================

// const body = document.querySelector("body");
// const darkLight = document.querySelector("#darkLight");

// // Wait for sidebar to be initialized
// document.addEventListener('DOMContentLoaded', () => {
//     const sidebar = document.querySelector(".sidebar");
//     const sidebarBackdrop = document.querySelector("#sidebarBackdrop");
    
//     // Find mobile toggle button (try multiple selectors)
//     let sidebarOpen = document.querySelector("#sidebarOpen") || 
//                       document.querySelector("#mobileNavToggle") ||
//                       document.querySelector(".mobile-menu-toggle");
    
//     // Only set up mobile toggle if it exists
//     if (sidebarOpen && sidebar) {
//         sidebarOpen.addEventListener("click", (e) => {
//             e.stopPropagation();
            
//             if (window.innerWidth <= 768) {
//                 // Mobile behavior
//                 const isOpen = sidebar.classList.contains('mobile-open');
//                 if (isOpen) {
//                     sidebar.classList.remove('mobile-open');
//                     if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
//                 } else {
//                     sidebar.classList.add('mobile-open');
//                     if (sidebarBackdrop) sidebarBackdrop.classList.add('show');
//                 }
//             } else {
//                 // Desktop behavior
//                 sidebar.classList.toggle("close");
//                 const isCollapsed = sidebar.classList.contains('close');
//                 document.body.style.paddingLeft = isCollapsed ? '70px' : '260px';
//                 localStorage.setItem('sidebarState', isCollapsed ? 'close' : 'open');
//             }
//         });
//     } else {
//         console.warn('Mobile menu toggle button not found. Looking for: #sidebarOpen, #mobileNavToggle, or .mobile-menu-toggle');
//     }

//     // Dark mode toggle (if exists)
//     if (darkLight && body) {
//         darkLight.addEventListener("click", () => {
//             body.classList.toggle("dark");
//             if (body.classList.contains("dark")) {
//                 darkLight.classList.replace("bx-sun", "bx-moon");
//                 localStorage.setItem('theme', 'dark');
//             } else {
//                 darkLight.classList.replace("bx-moon", "bx-sun");
//                 localStorage.setItem('theme', 'light');
//             }
//         });

//         // Restore dark mode preference
//         if (localStorage.getItem('theme') === 'dark') {
//             body.classList.add('dark');
//             darkLight.classList.replace("bx-sun", "bx-moon");
//         }
//     }

//     // Handle old submenu items (if they exist from old code)
//     const submenuItems = document.querySelectorAll(".submenu_item");
//     if (submenuItems.length > 0) {
//         submenuItems.forEach((item, index) => {
//             item.addEventListener("click", () => {
//                 item.classList.toggle("show_submenu");
//                 submenuItems.forEach((item2, index2) => {
//                     if (index !== index2) {
//                         item2.classList.remove("show_submenu");
//                     }
//                 });
//             });
//         });
//     }

//     // Close mobile sidebar when clicking backdrop
//     if (sidebarBackdrop && sidebar) {
//         sidebarBackdrop.addEventListener('click', () => {
//             if (window.innerWidth <= 768) {
//                 sidebar.classList.remove('mobile-open');
//                 sidebarBackdrop.classList.remove('show');
//             }
//         });
//     }

//     // Handle window resize
//     let resizeTimer;
//     window.addEventListener('resize', () => {
//         clearTimeout(resizeTimer);
//         resizeTimer = setTimeout(() => {
//             if (sidebar) {
//                 if (window.innerWidth <= 768) {
//                     // Mobile
//                     sidebar.classList.remove('close');
//                     if (!sidebar.classList.contains('mobile-open')) {
//                         document.body.style.paddingLeft = '0';
//                     }
//                 } else {
//                     // Desktop
//                     sidebar.classList.remove('mobile-open');
//                     if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
                    
//                     const isCollapsed = localStorage.getItem('sidebarState') === 'close';
//                     if (isCollapsed) {
//                         sidebar.classList.add('close');
//                         document.body.style.paddingLeft = '70px';
//                     } else {
//                         sidebar.classList.remove('close');
//                         document.body.style.paddingLeft = '260px';
//                     }
//                 }
//             }
//         }, 250);
//     });
// });