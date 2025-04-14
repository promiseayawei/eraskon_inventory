<?php require_once "layouts/header.view.php" ?>
<div class="v-body-wrapper" id="v-wrapper">
	<!-- header @::start -->
	<?php require_once "layouts/nav.view.php" ?>
	<!-- header @::end -->
	<section id="v-main">
		<?php require_once "layouts/sidebar.view.php" ?>
		<main class="v-main-content">
			<div class="v-main-content-inner col-lg-11 col-xl-11 mx-auto">
				<div class="p-0">
					<header class="v-page-title">
						<h3 class="v-title">Welcome back!</h3>
						<span class="v-subtext">
							Good <span class="v-day ms-1" data-daytime="day">morning, be great today</span>
							<span class="d-flex align-items-center justify-content-center">
								<img src="" data-icon="day" alt="" class="img-fluid ms-1" />
							</span>
						</span>
					</header>
				</div>
				<div class="v-main-content-inner col-12 row mt-3 m-0 justify-content-between mx-auto position-relative">
					<div class="v-page-wrapper p-0">
						<canvas id="referralChart"></canvas>
					</div>
				</div>
			</div>
		</main>
	</section>
</div>
<?php require_once "layouts/footer.view.php" ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
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
</script>