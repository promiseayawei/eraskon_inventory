<?php
session_start();
$pageTitle = "Login | E-networks Partners";
require_once "../layouts/auth.header.view.php";
require_once "../config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- Reference the index.css file -->
    <link rel="stylesheet" href="../dashboard/assets/css/index.css">

    <style>
        /* Modal Styling */
        .modal {
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        /* Button */
        .v-button-modern {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .v-button-modern:hover {
            background-color: #0056b3;
        }

        .v-form-input input:disabled,
        .v-form-input select:disabled {
            background-color: #f8f9fa;
            color: #888;
            cursor: not-allowed;
        }

        .v-form-input input,
        .v-form-input select {
            padding: 12px 14px;
            font-size: 15px;
        }

        /* Input group match */
        .input-group {
            display: flex;
            align-items: stretch;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .v-button-modern {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            height: 100%;
            white-space: nowrap;
        }

        .v-auth {
            min-height: 100vh;
            background: #f7f9fb;
            border-radius: 12px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .v-main-auth {
            padding: 2rem;
            background-color: white;
            border-radius: 12px;
        }

        .v-form-input {
            margin-bottom: 0.3rem;
        }

        .v-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }

        .v-subtext {
            font-size: 14px;
            color: #888;
        }

        .v-bottom-text {
            font-size: 14px;
            color: #666;
        }

        .v-form>div {
            display: flex;
            flex-direction: column;
        }

        .v-form .v-button-modern {
            margin-top: 1rem;
        }

        /* Buttons side-by-side */
        .v-form .step-buttons {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* Reduce spacing between input fields */
        .v-form-input {
            margin-bottom: 1rem;
            /* reduced from 1.5rem */
        }


        /* Carousel image container */
        .v-image-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            padding: 2rem;
            box-sizing: border-box;
            background-color: #f2f2f2;
            transition: all 0.5s ease-in-out;
            min-height: 280px;
        }

        .v-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease;
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(50px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeInUp 0.6s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slick carousel arrows */
        .slick-prev:before,
        .slick-next:before {
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #666;
            font-size: 24px;
        }

        .slick-prev:before {
            content: "\f104";
            /* fa-arrow-left */
        }

        .slick-next:before {
            content: "\f105";
            /* fa-arrow-right */
        }

        /* Remove excessive bottom space under carousel */
        .carousel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .slick-slider {
            margin-bottom: 0 !important;
        }

        @media (max-width: 768px) {
            .v-image-container {
                padding: 1rem;
                min-height: 200px;
            }

            .v-button {
                background-color: #0069d9;
                border: none;
                border-radius: 6px;
                color: #fff;
                padding: 10px 20px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .v-button:hover {
                background-color: #0056b3;
                transform: scale(1.03);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

        }
    </style>
</head>

<body>
    <div class="v-page-wrapper" id="v-wrapper" v-cloak>
        <main class="v-main" id="v-page-main">
            <div class="container-xl d-flex align-items-center justify-content-center v-auth-page-wrapper fade-in">
                <div class="col-11 col-md-12 col-xl-10 mx-auto v-auth-page-wrapper-inner overflow-hidden fade-in">
                    <div class="row col-12 v-auth m-0 align-items-stretch h-100">
                        <aside class="col-md-8 col-lg-6 mx-auto p-0 h-100 fade-in">
                            <div class="v-main-auth">
                                <div class="v-main-auth-inner">
                                    <div class="v-wrap col-12 col-sm-9 col-md-11 col-lg-9 mx-auto">
                                        <div class="text-center mb-4 fade-in">
                                            <img src="http://localhost/KALPEP2/dashboard/assets/images/logo.png" alt="E-networks Partners Logo" class="img-fluid" style="max-width: 150px;">
                                        </div>


                                        <header class="text-center mt-4 d-flex justify-content-center flex-column row-gap-2 mb-4 fade-in">
                                            <h3 class="text-center fade-in">E-networks Partners</h3>

                                            <h5>Login</h3>

                                        </header>
                                        
                                            <form @submit.prevent="loginUser" class="v-form fade-in">

                                                <div class="v-form-input">
                                                    <label for="email" class="v-label">Email</label>
                                                    <div class="position-relative">
                                                        <input type="email" v-model="loginData.email" class="form-control" id="email" placeholder="Enter your email" required />
                                                    </div>
                                                </div>
                                                <div class="v-form-input">
                                                    <label for="password" class="v-label">Password</label>
                                                    <div class="position-relative">
                                                        <input type="password" v-model="loginData.password" class="form-control" id="password" placeholder="Enter your password" required />
                                                        <button type="button" class="password-toggle" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                                                            <svg id="password-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-center">
                                                    <button type="submit" class="v-button-modern" :disabled="loading">
                                                        <span v-if="loading" class="loader"></span>
                                                        <span v-else>Login</span>
                                                    </button>
                                                    <div class="d-flex align-items-center justify-content-end mt-1">
                                                        <a href="./forgotpassword.php" class="v-forgot">Forgot password?</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-center v-bottom pb-3 mt-2 fade-in">
                                                <span class="v-bottom-text">
                                                    Don't have an account?
                                                    <b><a href="./register.php">Register here</a></b>
                                                </span>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </aside>
                        <aside class="col-lg-6 h-100 p-0 d-none d-lg-block overflow-hidden fade-in" role="presentation">

                            <section style="margin-top:10rem;" class="splide h-100">
                                <h3 class="text-center fade-in">Our Partners</h3>
                                <div class="splide__track h-100">
                                    <ul class="splide__list h-100">
                                        <li class="splide__slide">
                                            <figure class="v-image-container">
                                                <img src="../assets/media/images/karu-lga.jpg" alt="" class="img-fluid" />
                                            </figure>
                                        </li>
                                        <li class="splide__slide">
                                            <figure class="v-image-container">
                                                <img src="../assets/media/images/maan logo.png" alt="" class="img-fluid" />
                                            </figure>
                                        </li>
                                        <li class="splide__slide">
                                            <figure class="v-image-container">
                                                <img src="../assets/media/images/WhatsApp Image 2025-04-08 at 10.16.44.jpeg" alt="" class="img-fluid" />
                                            </figure>
                                        </li>
                                        <li class="splide__slide">
                                            <figure class="v-image-container">
                                                <img src="../assets/media/images/typing.jpg" alt="" class="img-fluid" />
                                            </figure>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                        </aside>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require_once "../layouts/auth.footer.view.php"; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css">

    <!-- Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/js/splide.min.js"></script>

    <!-- Vue & Axios -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        new Vue({
            el: "#v-wrapper",
            data: {
                loginData: {
                    email: "",
                    password: ""
                },
                loading: false
            },
            methods: {
                loginUser() {
                    this.loading = true; // Show loading indicator
                    const payload = {
                        email: this.loginData.email,
                        password: this.loginData.password
                    };

                    console.log("Login payload being sent:", payload);

                    axios.post('<?= $base_url; ?>/users/login', payload)
                        .then(response => {
                            console.log("Full Response from server:", response.data);

                            if (response.status === 200) {
                                alert(response.data.message || "Login successful!");

                                // Safely access user data
                                const userData = response.data?.data || {};
                                const firstName = userData.first_name || 'Guest'; // Default to 'Guest' if null
                                const lastName = userData.last_name || '';
                                const role = userData.role || '';
                                const state = userData.state || '';
                                const id = userData.id || ''; // Retrieve the user ID
                                const token = response.data?.token || ''; // Retrieve the Bearer token
                                const accountType = userData.account_type || ''; // Retrieve the account type

                                // New fields
                                const mobilizer = userData.mobilizer_id || '';
                                const fieldOfficer = userData.field_officer_id || '';
                                const supervisor = userData.supervisor_id || '';
                                const projectManager = userData.project_manager_id || '';
                                const projectDirector = userData.project_director_id || '';

                                console.log("First Name:", firstName); // Debugging log
                                console.log("Last Name:", lastName); // Debugging log
                                console.log("Role:", role); // Debugging log
                                console.log("State:", state); // Debugging log
                                console.log("ID:", id); // Debugging log
                                console.log("Token:", token); // Debugging log
                                console.log("Account Type:", accountType); // Debugging log
                                console.log("Mobilizer:", mobilizer); // Debugging log
                                console.log("Field Officer:", fieldOfficer); // Debugging log
                                console.log("Supervisor:", supervisor); // Debugging log
                                console.log("Project Manager:", projectManager); // Debugging log
                                console.log("Project Director:", projectDirector); // Debugging log

                                // Store data in localStorage
                                localStorage.setItem('first_name', firstName);
                                localStorage.setItem('last_name', lastName);
                                localStorage.setItem('role', role);
                                localStorage.setItem('state', state);
                                localStorage.setItem('id', id); // Store the user ID
                                localStorage.setItem('token', token); // Store the Bearer token
                                localStorage.setItem('account_type', accountType); // Store the account type

                                // Store new fields in localStorage
                                localStorage.setItem('mobilizer', mobilizer);
                                localStorage.setItem('field_officer', fieldOfficer);
                                localStorage.setItem('supervisor', supervisor);
                                localStorage.setItem('project_manager', projectManager);
                                localStorage.setItem('project_director', projectDirector);

                                console.log("Data stored in localStorage");

                                // Redirect to dashboard
                                window.location.href = "/KALPEP2/dashboard/index.php";
                            } else {
                                alert(response.data.message || "Login failed. Please check your credentials.");
                            }
                        })
                        .catch(error => {
                            console.error("Error during login:", error);

                            if (error.response) {
                                console.log("Error response data:", error.response.data);
                                alert(`Error: ${error.response.data.message || "An error occurred on the server."}`);
                            } else if (error.request) {
                                console.log("Error request:", error.request);
                                alert("No response from the server. Please check your connection.");
                            } else {
                                console.log("Error message:", error.message);
                                alert("An unexpected error occurred. Please try again.");
                            }
                        })
                        .finally(() => {
                            this.loading = false; // Hide loading indicator
                        });
                }
            }
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                passwordInput.type = 'password';
                passwordIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Add fade-in animation to dynamically loaded elements
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`; // Staggered animation
                el.classList.add('fade-in');
            });

            // Add hover effect to the login button
            const loginButton = document.querySelector('.v-button-modern');
            loginButton.addEventListener('mouseenter', () => {
                loginButton.style.transform = 'scale(1.05)';
                loginButton.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            });

            loginButton.addEventListener('mouseleave', () => {
                loginButton.style.transform = 'scale(1)';
                loginButton.style.boxShadow = 'none';
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Splide('.splide', {
                type: 'loop',
                perPage: 1,
                autoplay: true,
                interval: 3000,
                heightRatio: 0.6,
            }).mount();
        });
    </script>
</body>

</html>