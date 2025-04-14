<?php
$pageTitle = "Forgot Password | KALPEP";
require_once "../layouts/auth.header.view.php";
?>
   <div class="v-page-wrapper" id="v-wrapper" v-cloak>
		<!-- main @::body -->
		<main class="v-main" id="v-page-main">
			<div class="container-xl d-flex align-items-center justify-content-center v-auth-page-wrapper">
				<div class="col-11 col-md-8 col-lg-7 col-xl-10 col-xxl-6 mx-auto v-auth-page-wrapper-inner overflow-hidden">
					<div class="row col-12 v-auth m-0 align-items-stretch h-100">
						<div class="v-main-auth">
							<div class="v-main-auth-inner">
								<div class="v-wrap col-12 col-sm-9 col-md-11 col-lg-9 mx-auto">
									<div class="d-flex align-items-center justify-content-start gap-4 mb-5">
										<div class="v-logo-wrapper pt-0">
											<img src="../assets/media/logos/enetworks-main-logo.png" alt="" class="img-fluid" />
										</div>
									</div>
									<header class="text-start mt-4 d-flex align-items-start justify-content-center flex-column row-gap-2 mb-4">
										<h3>Reset Password</h3>
										<span class="v-subtext">Enter your email and password to access your account</span>
									</header>
									<form action="" class="v-form">
										<div class="v-form-input">
											<label for="email" class="v-label">Email</label>
											<div class="position-relative">
												<input type="email" v-model="userAuth.email" class="form-control" id="email" placeholder="Enter your email" />
											</div>
										</div>
										<div class="mt-2 text-center">
											<button type="submit" @click.prevent="resetPassword" class="v-button" :disabled="loading.btn">
											    <span v-if="loading.btn" class="loader"></span>
    											<span v-else>Reset Password</span>
											</button>
											<div class="d-flex align-items-center justify-content-end mt-1">
												<a href="./login.php" class="v-forgot">Remember password ?</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- main @::end -->
	</div>
<?php require_once "../layouts/auth.footer.view.php" ?>
	