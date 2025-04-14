<?php
session_start();
?>
<header id="v-header-container">
  <nav class="v-header-inner d-flex align-items-center justify-content-between">
    <a href="./index.php">
      <div class="v-logo">
        <!-- <img src="./assets/media/images/CardifyLogo.png" title="Cardify Logo" alt="" class="img-fluid" /> -->
        <h3>MAJOC1.0</h3>
      </div>
    </a>
    <div class="v-right-nav">
      <div class="position-relative">
        <button type="button" class="v-toggle-noti" data-target="v-noti-dropdown">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
              <path d="M19.4 14.9C20.2 16.4 21 17 21 17H3s3-2 3-9c0-3.3 2.7-6 6-6c.7 0 1.3.1 1.9.3M10.3 21a1.94 1.94 0 0 0 3.4 0" />
              <circle cx="18" cy="8" r="4" stroke="#12a632" fill="#12a632" />
            </g>
          </svg>
        </button>
        <div class="v-noti-dropdown v-dropdown" data-v-expanded="false" data-receiver="v-noti-dropdown">
          <header class="v-noti-header">
            <div class="v-top">
              <h6 class="v-title">Notifications</h6>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                  <path d="M19.4 14.9C20.2 16.4 21 17 21 17H3s3-2 3-9c0-3.3 2.7-6 6-6c.7 0 1.3.1 1.9.3M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                  <circle cx="18" cy="8" r="3" />
                </g>
              </svg>
            </div>
            <div class="v-bottom">
              <button type="button" class="v-noti-toggler active" data-target="all">
                <span class="v-text">All</span>
                <div class="v-num-of-noti">3</div>
              </button>
              <button type="button" class="v-noti-toggler" data-target="security">
                <span class="v-text">Security</span>
                <div class="v-num-of-noti">1</div>
              </button>
              <button type="button" class="v-noti-toggler" data-target="activities">
                <span class="v-text">My activities</span>
                <div class="v-num-of-noti">0</div>
              </button>
            </div>
          </header>
          <div class="v-dropdown-body">
            <div class="v-notifs-container active" data-receiver="all">
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You just logged in into your account. </span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You just logged in into your account. </span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> We noticed you just logged in. If this was not you, kindly chat with our support team. </span>
                <span class="v-datetime">20 Jan, 2023. 18:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> We noticed you just logged in. If this was not you, kindly chat with our support team. </span>
                <span class="v-datetime">20 Jan, 2023. 18:45</span>
              </div>
              <!-- each noti @::end -->
            </div>
            <div class="v-notifs-container" data-receiver="security">
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You just logged in into your account. </span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You just logged in into your account. </span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> We noticed you just logged in. If this was not you, kindly chat with our support team. </span>
                <span class="v-datetime">20 Jan, 2023. 18:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> We noticed you just logged in. If this was not you, kindly chat with our support team. </span>
                <span class="v-datetime">20 Jan, 2023. 18:45</span>
              </div>
              <!-- each noti @::end -->
            </div>
            <div class="v-notifs-container" data-receiver="activities">
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You bought 14$ Bitcoin </span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
              <!-- each noti @::start -->
              <div class="v-each-noti">
                <span class="v-main-noti"> You bought $30 USDT</span>
                <span class="v-datetime">20 Jan, 2023. 13:45</span>
              </div>
              <!-- each noti @::end -->
            </div>
          </div>
          <div class="v-dropdown-footer">
            <div class="d-flex align-items-center justify-content-center">
              <a href="./notification.html" class="v-see-all-noti"> View all notifications </a>
            </div>
          </div>
        </div>
      </div>
      <div class="position-relative">
        <div class="d-flex align-items-center gap-3">
          <button type="button" class="v-toggle-profile" data-target="v-profile-dropdown">
            <div class="v-right-nav-detail d-none d-sm-flex">
              <span class="v-user-name user_first_name">Loading...</span>
            </div>
          </button>
          <button type="button" class="v-mobile-menu-toggler d-md-none">
            <div class="v-toggle">
              <span class="v-stroke"></span>
              <span class="v-stroke"></span>
              <span class="v-stroke"></span>
            </div>
          </button>
        </div>
        <div class="v-profile-dropdown v-dropdown" data-v-expanded="false" data-receiver="v-profile-dropdown">
          <div class="v-step-container v-step-one">
            <div class="v-profile-image">
              <img src="./assets/media/webp/avatar.webp" alt="" class="img-fluid" />
            </div>
            <span  class="v-profile-name mt-2"> <b class="user_first_name"></b></span>
            <span class="v-profile-level">Role: <b class="user_role"></b></span>
          </div>
          <div class="v-step-container v-step-two">
            <ul class="v-dropdown-link-list">
              <li>
                <a href="./profile.html" class="v-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g transform="translate(24 0) scale(-1 1)">
                      <g fill="none" fill-rule="evenodd">
                        <path
                          d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                        <path
                          fill="currentColor"
                          d="M16 14a5 5 0 0 1 4.995 4.783L21 19v2a1 1 0 0 1-1.993.117L19 21v-2a3 3 0 0 0-2.824-2.995L16 16H8a3 3 0 0 0-2.995 2.824L5 19v2a1 1 0 0 1-1.993.117L3 21v-2a5 5 0 0 1 4.783-4.995L8 14h8ZM12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10Zm0 2a3 3 0 1 0 0 6a3 3 0 0 0 0-6Z" />
                      </g>
                    </g>
                  </svg>
                  <span class="v-link-name">Profile</span>
                </a>
              </li>
              <li>
                <a href="./notification.html" class="v-link">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <path d="M19.4 14.9C20.2 16.4 21 17 21 17H3s3-2 3-9c0-3.3 2.7-6 6-6c.7 0 1.3.1 1.9.3M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                      <circle cx="18" cy="8" r="3" />
                    </g>
                  </svg>
                  <span class="v-link-name">Notification</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="v-step-container v-step-four">
            <li class="v-dropdown-link-list">
              <a href="" class="v-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M3 21V3h9v2H5v14h7v2zm13-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z" />
                </svg>
                <span class="v-link-name">Log out</span>
              </a>
            </li>
          </div>
        </div>
      </div>
      <div id="v-backdrop"></div>
    </div>
  </nav>
</header>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Retrieve first_name and role from localStorage
    const first_name = localStorage.getItem('first_name') || "Guest";
    const role = localStorage.getItem('role') || "Guest";

    


    // Update the DOM with the first_name
    const userFirstNames = document.querySelectorAll('.user_first_name');
    userFirstNames.forEach((element) => {
      element.textContent = first_name.toUpperCase();
    });

    // Update the DOM with the user role
   const userRoles = document.querySelectorAll('.user_role');
    userRoles.forEach((element) => {
      element.textContent = role.toUpperCase();
    });
  });
</script>