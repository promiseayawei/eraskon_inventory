<!DOCTYPE html>
<html lang="en">
	<head>
	<?php require_once "layouts/header.view.php";
require_once "../config.php";
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="v-body-wrapper" id="v-wrapper">

  <!-- header @::start -->
  <?php require_once "layouts/nav.view.php" ?>
  <!-- header @::end -->
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="theme-color" content="#12a632" />
		<link rel="shortcut icon" href="" type="image/x-icon" />
		<link rel="apple-touch-icon" sizes="180x180" href="" />
		<link rel="icon" type="image/png" sizes="32x32" href="" />
		<link rel="icon" type="image/png" sizes="16x16" href="" />

		<link rel="stylesheet" type="text/css" href="./assets/style/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./assets/style/default.css" />
		<link rel="stylesheet" type="text/css" href="./assets/style/index.css" />
		<link rel="stylesheet" type="text/css" href="./assets/style/media-query.css" />

		<title>Home</title>
	</head>
	<body>
		<div class="v-page-wrapper" id="v-wrapper">
			<!-- header @::start -->
			<header class="v-header" id="v-page-header">
			    Testing to see if this is working
			</header>
			<!-- header @::end -->
			<!-- main @::body -->
			<main class="v-main" id="v-page-main"></main>
			<!-- main @::end -->
			<!-- footer @::start-->
			<footer class="v-footer position-relative" id="v-page-footer"></footer>
			<!-- footer @::end -->

			<!-- offcanvas @::start -->
			<div class="offcanvas offcanvas-start" tabindex="-1" id="sideBar" aria-labelledby="sideBarLabel">
				<div class="offcanvas-header">
					<h5 class="offcanvas-title" id="sideBarLabel">Offcanvas</h5>
					<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body"></div>
			</div>
			<!-- offcanvas @::end -->
		</div>
		<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
		<script type="text/javascript" src="./assets/js/bootstrap.min.js" defer></script>
		<script src="./assets/js/vue.js" defer></script>
		<script type="module" src="./assets/js/index.custom.js" defer></script>
	</body>
</html>
