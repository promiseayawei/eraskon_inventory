<?php require_once "layouts/header.view.php";
require_once "../config.php";
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="v-body-wrapper" id="v-wrapper">

  <!-- header @::start -->
  <?php require_once "layouts/nav.view.php" ?>
  <!-- header @::end -->
  <section id="v-main">
    <?php require_once "layouts/sidebar.view.php" ?>
    <main class="v-main-content">
      <div class="v-main-content-inner col-lg-11 col-xl-11 mx-auto">
        <!-- Welcome Section -->
        <div class="p-0">
          <header class="v-page-title d-flex align-items-center justify-content-between">
            <div>
              <h3 class="v-title">Welcome<b class="user_first_name"></b></h3>
              <span class="v-subtext">
                <b>Users<span class="v-day ms-1" data-daytime="day">View</span></b>
                <span class="d-flex align-items-center justify-content-center">
                  <img src="" data-icon="day" alt="" class="img-fluid ms-1" />
                </span>
              </span>
                <p>  <strong>Account Type:</strong> <span class="user_account_type"></span></p>
                <p><strong>Role:</strong> <span id="user_role">Loading...</span></p>
            </div>
          </header>
        </div>

        <!-- Modernized Statistics Cards -->
        <div class="card-container d-flex justify-content-between flex-wrap gap-4 mt-4">
          <!-- Card for Total Records -->
          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Total Records</h5>
              <p class="modern-card-text">1,234</p>
            </div>
          </div>

          <!-- Card for Total Users -->
          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Total Users</h5>
              <p class="modern-card-text">567</p>
            </div>
          </div>

          <!-- Card for Total Commissions -->
          <div class="modern-card text-center">
            <div class="modern-card-body">
              <h5 class="modern-card-title">Total Commissions</h5>
              <p class="modern-card-text">$12,345</p>
            </div>
          </div>
        </div>

        <!-- Referral Link Section -->
        <div class="text-center mt-5">
          <h4 class="mb-4">Referral Link</h4>
          <div class="d-inline-flex align-items-center referral-link-container">
            <input type="text" id="referralLink" class="form-control text-center" readonly>
            <button class="btn btn-primary ms-2" onclick="copyReferralLink()">Copy</button>
          </div>

          <!-- Social Media Sharing Buttons -->
          <div class="mt-4">
            <h5 class="mb-3">Share on:</h5>
            <div class="social-buttons d-flex justify-content-center flex-wrap gap-3">
              <button class="share-btn btn-facebook" share-btn" onclick="shareOnPlatform('facebook')">
                <img src="/KALPEP2/assets/media/images/facebook.png" alt="Facebook" class="social-icon">
              </button>
              <button class="share-btn btn-twitter" share-btn" onclick="shareOnPlatform('twitter')">
                <img src="/KALPEP2/assets/media/images/twitter.png" alt="Twitter" class="social-icon">
              </button>
              <button class="share-btn btn-whatsapp" share-btn" onclick="shareOnPlatform('whatsapp')">
                <img src="/KALPEP2/assets/media/images/whatsapp.png" alt="WhatsApp" class="social-icon">
              </button>
              <button class="btn btn-email share-btn" onclick="shareOnPlatform('email')">
                <img src="/KALPEP2/assets/media/images/email.png" alt="Email" class="social-icon">
              </button>
              <button class="btn btn-sms share-btn" onclick="shareOnPlatform('sms')">
                <img src="/KALPEP2/assets/media/images/sms.png" alt="SMS" class="social-icon">
              </button>
            </div>
          </div>
        </div>

        <!-- Graph Section -->
        <div class="mt-5">
          <h4 class="text-center">Referral Reports</h4>
          <div class="chart-container" style="position: relative; width: 100%; height: 400px;">
            <canvas id="referralChart"></canvas>
          </div>
        </div>

        <!-- User Details Section -->
        <div id="userDetails" class="mt-5">
          <h4 class="text-center">User Details</h4>
          <div class="card shadow-sm p-3">
            <p><strong>Full Name:</strong> <span id="userFullName"></span></p>
            <p><strong>State:</strong> <span id="userState"></span></p>
          </div>
        </div>
      </div>
    </main>
  </section>
</div>
<?php require_once "layouts/footer.view.php" ?>
<style>
  .user_account_type {
    text-transform: capitalize; /* Capitalize the first letter of each word */
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Retrieve the user data from localStorage
    const userId = localStorage.getItem('id');
    const firstName = localStorage.getItem('first_name');
    const lastName = localStorage.getItem('last_name');
    const state = localStorage.getItem('state');
    const role = localStorage.getItem('role');
    const mobilizer = localStorage.getItem('mobilizer');
    const fieldOfficer = localStorage.getItem('field_officer');     
    const supervisor = localStorage.getItem('supervisor');
    const projectManager = localStorage.getItem('project_manager');
    const projectDirector = localStorage.getItem('project_director');
    const accountType = localStorage.getItem('account_type'); // Retrieve account type

    if (userId) {
        console.log("User ID retrieved from localStorage:", userId);

        // Update the welcome message with the user's first name
        document.querySelector('.user_first_name').textContent = `${firstName || 'User'}`;

        // Update the account type
        document.querySelector('.user_account_type').textContent = `${accountType || 'N/A'}`;

        // Update the user account type
        const accountTypeElement = document.querySelector('.user_account_type');
        if (accountType) {
            accountTypeElement.textContent = accountType.charAt(0).toUpperCase() + accountType.slice(1);
        } else {
            accountTypeElement.textContent = 'N/A';
        }
        // Update the user role
        const roleElement = document.querySelector('.user_role');   
        if (role) {
            roleElement.textContent = role.charAt(0).toUpperCase() + role.slice(1);
        } else {
            roleElement.textContent = 'N/A';
        }
        // Update the user mobilizer
        const mobilizerElement = document.querySelector('.user_mobilizer');
        // Update user details
        document.getElementById('userFullName').textContent = `${firstName || ''} ${lastName || ''}`;
        document.getElementById('userState').textContent = `${state || 'N/A'}`;

        // Generate the referral link dynamically
        const baseUrl_front = "<?= $base_url_front; ?>";
        const referralLink = `${baseUrl_front}/dashboard/referral.php?code=${userId}`;

        // Update the referral link input field
        document.getElementById('referralLink').value = referralLink;
    } else {
        console.log("No User ID found in localStorage.");
        document.getElementById('referralLink').value = "User ID not found. Please log in.";
    }

    // Add fade-in animation to dynamically loaded elements
    const fadeInElements = document.querySelectorAll('.modern-card, .referral-link-container, .social-buttons button, .chart-container canvas');
    fadeInElements.forEach((el, index) => {
      el.style.animationDelay = `${index * 0.2}s`; // Staggered animation
      el.classList.add('fade-in');
    });

    // Referral Chart Data
    const data = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June'], // X-axis labels
      datasets: [{
        label: 'Referrals',
        data: [12, 19, 3, 5, 2, 3], // Y-axis data points
        borderColor: 'rgba(54, 162, 235, 1)', // Line color
        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Fill color under the line
        borderWidth: 2, // Line thickness
        tension: 0.4, // Smoothness of the line (0 for straight lines)
        fill: true // Fill the area under the line
      }]
    };

    // Chart configuration for a line graph
    const config = {
      type: 'line', // Line graph
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top' // Position of the legend
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: 'Months' // X-axis title
            }
          },
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Referrals' // Y-axis title
            }
          }
        }
      }
    };

    // Render the line graph
    const ctx = document.getElementById('referralChart').getContext('2d');
    new Chart(ctx, config);
  });

  function shareOnPlatform(platform) {
    const referralLink = document.getElementById('referralLink').value;
    const message = `Join MAJOC-1.0 powered by e-networks Technology. Use my referral link: ${referralLink}`;

    switch (platform) {
      case 'facebook':
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(referralLink)}`, '_blank');
        break;
      case 'twitter':
        window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(message)}`, '_blank');
        break;
      case 'whatsapp':
        window.open(`https://wa.me/?text=${encodeURIComponent(message)}`, '_blank');
        break;
      case 'email':
        window.open(`mailto:?subject=Join this platform&body=${encodeURIComponent(message)}`, '_self');
        break;
      case 'sms':
        window.open(`sms:?body=${encodeURIComponent(message)}`, '_self');
        break;
      default:
        alert('Platform not supported!');
    }
  }

  function copyReferralLink() {
    const referralInput = document.getElementById('referralLink');
    referralInput.select();
    referralInput.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(referralInput.value).then(() => {
      alert('Referral link copied to clipboard!');
    }).catch(err => {
      console.error('Failed to copy referral link: ', err);
    });
  }
</script>