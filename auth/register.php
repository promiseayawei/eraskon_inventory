<?php
$pageTitle = "Register | E-networks Partners";
require_once "../layouts/auth.header.view.php";
require_once "../config.php";
?>
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
        margin-bottom: 1.5rem;
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
        margin-bottom: 0.5rem;
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
</style>




<div class="v-page-wrapper" id="v-wrapper" v-cloak>
    <main class="v-main" id="v-page-main">
        <div class="container-xl d-flex align-items-center justify-content-center v-auth-page-wrapper fade-in">
            <div class="col-11 col-md-12 col-xl-10 mx-auto v-auth-page-wrapper-inner overflow-hidden fade-in">
                <div class="row col-12 v-auth m-0 align-items-stretch h-100">
                    <aside class="col-md-8 col-lg-6 mx-auto p-0 h-100 fade-in">
                        <div class="v-main-auth">
                            <div class="v-main-auth-inner pb-5">
                                <div class="v-wrap col-12 col-sm-9 col-md-11 col-lg-9 mx-auto">
                                    <!-- Logo Section -->
                                    <div class="text-center mb-4 fade-in">
                                        <img src="http://localhost/KALPEP2/dashboard/assets/images/logo.png" alt="E-networks Partners Logo" class="img-fluid" style="max-width: 150px;">
                                    </div>

                
                                    <header class="text-center px-0 mt-4 d-flex justify-content-center flex-column row-gap-2 mb-4 fade-in">
                                    
                                    <h3 class="text-center fade-in">E-networks Partners Portal</h3>
    
                                    <h4>Register</h4>
                                        
                                    </header>
                                    <form @submit.prevent="registerUser" class="v-form fade-in">

                                        <!-- Step 1 -->
                                        <div v-if="step === 1">
                                            <!-- BVN Input -->
                                            <div class="v-form-input">
                                                <label for="bvnno" class="v-label">BVN</label>
                                                <div class="input-group">
                                                    <input type="text" v-model="userAuth.bvnno" class="form-control" id="bvnno" placeholder="Enter your BVN" required />
                                                    <div style="height:fit-content;" class="input-group-append">
                                                        <button style="height:fit-content;" type="button" class="v-button-modern" @click="validateBVN">Check</button>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="v-form-input">
                                                <label for="nin" class="v-label">NIN</label>
                                                <input type="text" v-model="userAuth.nin" :disabled="!canEdit" class="form-control" id="nin" placeholder="Enter your NIN" required />
                                            </div>

                                            <div class="v-form-input">
                                                <label for="phone" class="v-label">PHONE</label>
                                                <input type="text" v-model="userAuth.phone" :disabled="!canEdit" class="form-control" id="phone" placeholder="Enter your Phone number" required />
                                            </div>
                                            <button type="button" @click="nextStep" class="v-button-modern">Next</button>
                                        </div>

                                        <!-- Step 2 -->
                                        <div v-if="step === 2">
                                            <div class="v-form-input">
                                                <label for="first_name" class="v-label">First Name</label>
                                                <input type="text" v-model="userAuth.first_name" :disabled="!canEdit" class="form-control" id="first_name" placeholder="Enter your first name" required />
                                            </div>
                                            <div class="v-form-input">
                                                <label for="last_name" class="v-label">Last Name</label>
                                                <input type="text" v-model="userAuth.last_name" :disabled="!canEdit" class="form-control" id="last_name" placeholder="Enter your last name" required />
                                            </div>
                                            <div class="v-form-input">
                                                <label for="state" class="v-label">State</label>
                                                <input type="text" v-model="userAuth.state" :disabled="!canEdit" class="form-control" id="state" placeholder="Enter your state" required />
                                            </div>
                                            <button type="button" @click="prevStep" class="v-button-modern">Back</button>
                                            <button type="button" @click="nextStep" class="v-button-modern">Next</button>
                                        </div>

                                        <!-- Step 3 -->
                                        <div v-if="step === 3">
                                            <div class="v-form-input">
                                                <label for="email" class="v-label">Email</label>
                                                <input type="email" v-model="userAuth.email" :disabled="!canEdit" class="form-control" id="email" placeholder="Enter your email" required />
                                            </div>
                                            <div class="v-form-input">
                                                <label for="verify_email" class="v-label">Verify Email</label>
                                                <input type="email" v-model="userAuth.verify_email" :disabled="!canEdit" class="form-control" id="verify_email" placeholder="Re-enter your email" required />
                                            </div>
                                            <div class="v-form-input">
                                                <label for="account_type" class="v-label">Account Type</label>
                                                <select v-model="userAuth.account_type" :disabled="!canEdit" class="form-control" required>
                                                    <option value="">Select Account Type</option>
                                                    <option value="general account">General Account</option>
                                                    <option value="value account">Value Account</option>
                                                    <option value="value plus account">Value Plus Account</option>
                                                    <option value="corporate account">Corporate Account</option>
                                                </select>
                                            </div>
                                            <button type="button" @click="prevStep" class="v-button-modern">Back</button>
                                            <button type="button" @click="nextStep" class="v-button-modern">Next</button>
                                        </div>

                                        <!-- Step 4 -->
                                        <div v-if="step === 4">
                                        <div class="v-form-input">
                                                <label for="account_type" class="v-label">Partner Program</label>
                                                <select v-model="userAuth.partner" :disabled="!canEdit" class="form-control" required>
                                                    <option value="">Select Partner</option>
                                                    <option value="general account">MAJOC1.0</option>
                                                    <option value="value account">KALPEP</option>
                                                    <option value="value plus account">SABOS</option>
                                                    <option value="corporate account">AGRIC</option>
                                                </select>
                                            </div>
                                            <div class="v-form-input">
                                                <label for="password" class="v-label">Password</label>
                                                <input type="password" v-model="userAuth.password" :disabled="!canEdit" class="form-control" id="password" placeholder="Enter your password" required />
                                            </div>
                                            <div class="v-form-input">
                                                <label for="confirm_password" class="v-label">Confirm Password</label>
                                                <input type="password" v-model="userAuth.confirm_password" :disabled="!canEdit" class="form-control" id="confirm_password" placeholder="Confirm your password" required />
                                            </div>
                                            <button type="button" @click="prevStep" class="v-button-modern">Back</button>
                                            <button type="submit" @input="registerUser" class="v-button-modern">Register</button>
                                        </div>

                                    </form>
                                    <div class="text-center v-bottom pb-3 mt-2 fade-in">
                                        <span class="v-bottom-text">
                                            I have an account?
                                            <b><a href="./login.php">login here</a></b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <aside class="col-lg-6 h-100 p-0 d-none d-lg-block overflow-hidden fade-in" role="presentation">

                        <section style="margin-top:10rem;" class="splide h-100">
                            <h5 class="text-uppercase text-center v-pre-header-title">OUR PARTNERS</h5>
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
                    <!-- Modal for OTP -->
                    <div v-if="showOtpModal" id="otpModal" class="modal">
                        <div class="modal-content position-relative">
                            <span class="close" @click="closeOtpModal">&times;</span>
                            <h2>Enter OTP</h2>
                            <input type="text" v-model="otp" placeholder="Enter OTP" class="form-control mb-3" />
                            <button @click="submitOtp" class="v-button-modern">Submit</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
</div>

<!-- Vue & Axios -->
<!-- Splide CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/css/splide.min.css">

<!-- Splide JS -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@3.6.9/dist/js/splide.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: "#v-wrapper",
        data: {
            step: 1,
            userAuth: {
                first_name: "",
                last_name: "",
                phone: "",
                state: "",
                email: "",
                verify_email: "",
                account_type: "",
                password: "",
                confirm_password: "",
                bvnno: "", // Changed from bvn to bvnno
                nin: ""
            },
            showOtpModal: false,
            baseUrl: '<?= $base_url ?>',
            canEdit: false,
            otp: ""
        },
        methods: {
            nextStep() {
                if (this.step < 4) {
                    this.step++;
                }
            },
            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            },
            registerUser() {
                if (this.userAuth.email !== this.userAuth.verify_email) {
                    alert("Emails do not match!");
                    return;
                }
                if (this.userAuth.password !== this.userAuth.confirm_password) {
                    alert("Passwords do not match!");
                    return;
                }

                // Create a new object with only the required fields
                const payload = {
                    bvnno: this.userAuth.bvnno,
                    first_name: this.userAuth.first_name,
                    last_name: this.userAuth.last_name,
                    phone: this.userAuth.phone,
                    state: this.userAuth.state,
                    email: this.userAuth.email,
                    account_type: this.userAuth.account_type,
                    password: this.userAuth.password,
                    nin: this.userAuth.nin
                };

                console.log("Payload being sent:", payload); // Log the payload to the console

                axios.post('<?= $base_url; ?>/users/signUp', payload)
                    .then(response => {
                        console.log("Response from server:", response.data);

                        // Check if the response contains a success flag
                        if (response.status === 201) {
                            alert(response.data.message || "Registration successful!");
                            // Optionally, redirect the user to another page
                            window.location.href = "<?= $base_url_front; ?>/auth/login.php";
                        } else {
                            // Handle server-side validation errors or failure messages
                            alert(response.data.message || "Registration failed. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error("Error during registration:", error);

                        // Handle specific HTTP errors
                        if (error.response) {
                            // Server responded with a status code outside the 2xx range
                            alert(`Error: ${error.response.data.message || "An error occurred on the server."}`);
                        } else if (error.request) {
                            // Request was made but no response was received
                            alert("No response from the server. Please check your connection.");
                        } else {
                            // Something else caused the error
                            alert("An unexpected error occurred. Please try again.");
                        }
                    });
            },
            validateBVN() {
                const bvnno = this.userAuth.bvnno; // Updated reference to bvnno

                if (bvnno.length === 11 && /^\d+$/.test(bvnno)) {
                    const payload = {
                        bvnno: bvnno
                    }; // Create payload object

                    axios.post('<?= $base_url; ?>/helper/bvn', payload, {
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            const res = response.data;
                            console.log("bvn datail check", res)
                            if (response.status === 200) {

                                alert(response.data?.message || 'OTP sent successfully'); // Optional: show the OTP message
                                this.showOtpModal = true;
                            } else {
                                alert(response.data?.message || 'BVN validation failed.');
                            }
                        })

                        .catch(error => {
                            console.error('Error:', error);
                            alert('An unexpected error occurred. Please try again.');
                        });
                } else {
                    alert('Invalid BVN. It must be 11 digits.');
                }
            },
            closeOtpModal() {
                this.showOtpModal = false;
            },
            submitOtp() {
                if (!this.otp) {

                    alert('Please enter the OTP.');
                    return;
                }
                const otp = this.otp;
                const payload = {
                    otp: otp,

                }; // Create payload object
                axios.get(`${this.baseUrl}/helper/bvn_verify`, {
                        params: {
                            otp: this.otp
                        },
                        // headers: {
                        //     'Content-Type': 'application/json'
                        // }
                    })
                    .then(response => {
                        
                        console.log("bvn_very data", response);

                        // Make sure the structure exists
                        if (response.status === 200 ) {
                            
                            // const info = response.data?.data;
                            // console.log("bvn_very info", info);
                            alert('BVN verified successfully!');
                            this.showOtpModal = false;
                            this.canEdit = true;

                        //     // Autofill the form using Vue's reactivity
                            
                        //     this.userAuth.nin = info.nin || '';
                        //     this.userAuth.phone = info.phone_number || '';
                        //     this.userAuth.first_name = info.first_name || '';
                        //     this.userAuth.last_name = info.last_name || '';
                        //     this.userAuth.state = info.state_of_origin || '';
                        //     this.userAuth.email = info.email || '';
                        //     this.userAuth.verify_email = info.email || '';
                        //     this.userAuth.gender = info.gender || '';
                        //     this.userAuth.dob = info.dob || '';
                        //     this.userAuth.account_type = 'general account'; // or make this dynamic if needed
                        } else {
                            alert("BVN error message", response?.data?.message || 'BVN verification failed.');
                        }

                    })
                    .catch(error => {
                        console.error('BVN Verification Error:', error);
                        alert('An error occurred while verifying your BVN. Please try again.');
                    });

            }

        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Add fade-in animation to dynamically loaded elements
        const fadeInElements = document.querySelectorAll('.fade-in');
        fadeInElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.2}s`; // Staggered animation
            el.classList.add('fade-in');
        });

        // Add hover effect to buttons
        const buttons = document.querySelectorAll('.v-button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'scale(1.05)';
                button.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            });

            button.addEventListener('mouseleave', () => {
                button.style.transform = 'scale(1)';
                button.style.boxShadow = 'none';
            });
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