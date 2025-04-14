<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/KALPEP2/dashboard/referral.php

// Include necessary configurations
require_once "../config.php";
require_once "layouts/header.view.php";


// Get the referral code (id) from the URL
$referralCode = $_GET['code'] ?? null;

// Check if the referral code is provided
if (!$referralCode) {
    die("Invalid referral link. Please provide a valid referral code.");
}

// Verify the authenticity of the referral code (id)
$apiUrl = $base_url . "/users/read.php?id=" . urlencode($referralCode);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        .v-body-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            padding: 1rem 0;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="v-body-wrapper">
        <div class="container mt-5 fade-in">
            <!-- Logo Section -->
            <div class="text-center mb-4 fade-in">
                <img src="http://localhost/KALPEP2/dashboard/assets/images/logo.png" alt="E-networks Partners Logo" class="img-fluid" style="max-width: 150px;">
            </div>

            <h3 class="text-center fade-in">E-networks Partners Referral Portal</h3>

            <!-- Dynamic Invitation Message -->
            <p id="invitationMessage" class="text-center mt-3 fade-in" style="font-size: 1.2rem; font-weight: 500; color: #333;">
                Loading invitation details...
            </p>

            <form id="referralForm" class="mt-4 fade-in">
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <!-- Hidden fields -->
                <input type="hidden" id="fullname" name="fullname" value="Mobilizer A">
                <input type="hidden" id="mobilizer" name="mobilizer" value="Mobilizer A">
                <input type="hidden" id="field_officer" name="field_officer" value="Field Officer B">
                <input type="hidden" id="supervisor" name="supervisor" value="Supervisor C">
                <input type="hidden" id="project_manager" name="project_manager" value="Project Manager D">
                <input type="hidden" id="project_director" name="project_director" value="Project Director E">
                <input type="hidden" id="referral_code" name="referral_code" value="<?= htmlspecialchars($referralCode); ?>">
                <button type="submit" class="btn btn-primary fade-in">Submit Referral</button>
            </form>
        </div>

        <!-- Footer Section -->
        <footer class="text-center fade-in">
            <p class="mb-0">&copy; <?= date('Y'); ?> E-networks Partners. All rights reserved.</p>
            <small>Powered by E-networks Technologies</small>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Retrieve inviter details dynamically
            const apiUrl = "<?= $apiUrl; ?>";

            const referralCode = "<?= $referralCode ?>"; // PHP embeds the referral code

            // Function to safely set hidden input values
            function setInputValue(id, value) {
                const input = document.getElementById(id);
                if (input) input.value = value;
            }

            // Fetch inviter details using the referral code
            axios.get(`<?= $base_url; ?>/users/refUser?referral=${referralCode}`)
                .then(response => {
                    console.log("API Response:", response.data);

                    if (response.status === 200 && response.data.data) {
                        const userData = response.data.data;

                        const inviterFirstName = userData.first_name || "First";
                        const inviterLastName = userData.last_name || "Last";
                        const partnerName = userData.partner || "Partner";

                        const fullName = `${inviterFirstName} ${inviterLastName}`;

                        // Fill hidden fields

                        setInputValue('mobilizer', `${userData.mobilizer_id || '0'}`);
                        setInputValue('field_officer', `${userData.field_officer_id || '0'}`);
                        setInputValue('supervisor', `${userData.supervisor_id || '0'}`);
                        setInputValue('project_manager', `${userData.project_manager_id || '0'}`);
                        setInputValue('project_director', `${userData.project_director_id || '0'}`);

                        // Show invitation message if element exists
                        const invitationMessage = document.getElementById('invitationMessage');
                        if (invitationMessage) {
                            invitationMessage.textContent = `${fullName} is inviting you to join Majoc1.0 in partnership with ${partnerName}`;
                        }

                    } else {
                        alert("Invalid referral code. Please check the link or contact support.");
                    }
                })
                .catch(error => {
                    console.error("Error fetching inviter details:", error);
                    alert("An error occurred while fetching inviter details. Please try again.");
                });

            // Optional fade-in animation logic
            const fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.2}s`;
                el.classList.add('fade-in');
            });
            // Handle form submission
            document.getElementById('referralForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Collect form data
                const formData = {
                    user_id: document.getElementById('referral_code').value,
                    fullname: document.getElementById('fullname').value,
                    phone: document.getElementById('phone').value,
                    mobilizer_id: document.getElementById('mobilizer').value,
                    field_officer_id: document.getElementById('field_officer').value,
                    supervisor_id: document.getElementById('supervisor').value,
                    project_manager_id: document.getElementById('project_manager').value,
                    project_director_id: document.getElementById('project_director').value

                };

                console.log("Referral data being sent:", formData);

                // Send POST request to the API

                // send records to the api
                axios.post('<?= $base_url; ?>/records/create/refCreateRecord', formData, {

                    })
                    .then(response => {
                        console.log("API Response:", response.data);

                        if (response.status === 201) {
                            alert(response.data.message || "Referral record created successfully!");
                            // Optionally, reset the form
                            document.getElementById('referralForm').reset();
                            
                            setInputValue('fullname', `${''}`);
                            setInputValue('phone', `${''}`);
                            setInputValue('mobilizer', '');
                            setInputValue('field_officer', `${''}`);
                            setInputValue('supervisor', `${''}`);
                            setInputValue('project_manager', `${''}`);
                            setInputValue('project_director', `${''}`);

                        } else {
                            alert(response.data.message || "Failed to create referral record.");
                        }
                    })
                    .catch(error => {
                        console.error("Error during API request:", error);

                        if (error.response) {
                            alert(`Error: ${error.response.data.message || "An error occurred on the server."}`);
                        } else if (error.request) {
                            alert("No response from the server. Please check your connection.");
                        } else {
                            alert("An unexpected error occurred. Please try again.");
                        }
                    });
            });


        });
    </script>
</body>

</html>