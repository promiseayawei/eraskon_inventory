<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/KALPEP2/dashboard/referral.php

// Include necessary configurations
require_once "../config.php";
require_once "layouts/header.view.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Partner</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        html, body {
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

        /* Social Icons Styling */
        .social-icons a {
            display: inline-block;
            width: 50px; /* Increased size for better visibility */
            height: 50px;
            line-height: 50px;
            text-align: center;
            border-radius: 50%;
            color: #fff; /* White color for icons */
            font-size: 1.5rem; /* Increased font size for better legibility */
            margin: 0 10px; /* Add spacing between icons */
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            transform: scale(1.1); /* Slight zoom effect on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for better contrast */
        }

        /* Individual Button Colors */
        .btn-facebook {
            background-color: #4267B2; /* Facebook Blue */
        }

        .btn-twitter {
            background-color: #1DA1F2; /* Twitter Blue */
        }

        .btn-linkedin {
            background-color: #0077B5; /* LinkedIn Blue */
        }

        .btn-instagram {
           color: pink; /* Instagram Pink */
            background-color: #E1306C; /* Instagram Pink */
        }
    </style>
</head>
<body>
<div class="v-body-wrapper">
    <div class="container mt-5 fade-in">
        <!-- Logo Section -->
        <div class="text-center mb-4 fade-in">
            <img src="http://localhost/KALPEP2/dashboard/assets/images/logo.png" alt="E-networks Partners Logo" class="img-fluid">
        </div>

        <h3 class="text-center fade-in">Create Partner</h3>

        <form id="partnerForm" class="mt-4 fade-in" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="short_name" class="form-label">Short Name</label>
                <input type="text" class="form-control" name="short_name" id="short_name" placeholder="Enter short name" required>
            </div>

            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Enter full name" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" required>
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" name="logo" id="logo" required>
            </div>

            <button type="button" id="submitBtn" class="btn btn-primary w-100 fade-in">Submit</button>
        </form>

        <!-- Social Icons Section -->
        <div class="social-icons text-center mt-4 fade-in">
            <a href="https://facebook.com" target="_blank" class="btn btn-facebook me-2">
                <img src="/KALPEP2/assets/media/images/facebook.png" alt="Facebook" class="social-icon">
            </a>
            <a href="https://twitter.com" target="_blank" class="btn btn-twitter me-2">
                <img src="/KALPEP2/assets/media/images/twitter.png" alt="Twitter" class="social-icon">
            </a>
            <a href="https://linkedin.com" target="_blank" class="btn btn-linkedin me-2">
                <img src="/KALPEP2/assets/media/images/whatsapp.png" alt="whatsapp" class="social-icon">
            </a>
            <a href="https://instagram.com" target="_blank" class="btn btn-instagram">
                <img src="/KALPEP2/assets/media/images/instagram.png" alt="Instagram" class="social-icon">
            </a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="text-center fade-in">
        <p class="mb-0">&copy; <?= date('Y'); ?> E-networks Partners. All rights reserved.</p>
        <small>Powered by E-networks Technologies</small>
    </footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.getElementById('submitBtn').addEventListener('click', async () => {
        const form = document.getElementById('partnerForm');
        const formData = new FormData(form);

        // Retrieve the Bearer token from localStorage
        const token = localStorage.getItem('token');

        if (!token) {
            alert('No token found. Please log in first.');
            return;
        }

        try {
            const response = await fetch('http://localhost/KALPEP2/api3/partner/create/createPartner.php', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                body: formData
            });

            // Log the raw response for debugging
            const rawText = await response.text();
            console.log('Raw Response:', rawText);

            let result;
            if (rawText.trim() === '') {
                console.error('Empty response from server.');
                alert('The server returned an empty response.');
                return;
            }

            try {
                result = JSON.parse(rawText);
            } catch (error) {
                console.error('Failed to parse JSON:', error);
                alert('The server returned an invalid response.');
                return;
            }

            if (response.ok) {
                if (result) {
                    alert('Partner created successfully: ' + JSON.stringify(result));
                } else {
                    alert('Partner created successfully, but the server returned no additional data.');
                }
            } else {
                if (result) {
                    alert('Error: ' + JSON.stringify(result));
                } else {
                    alert('Error: The server returned no additional data.');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while creating the partner.');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        // Add fade-in animation to dynamically loaded elements
        const fadeInElements = document.querySelectorAll('.fade-in');
        fadeInElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.2}s`; // Staggered animation
            el.classList.add('fade-in');
        });

        // Add hover effect to the submit button
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.addEventListener('mouseenter', () => {
            submitBtn.style.transform = 'scale(1.05)';
            submitBtn.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
        });

        submitBtn.addEventListener('mouseleave', () => {
            submitBtn.style.transform = 'scale(1)';
            submitBtn.style.boxShadow = 'none';
        });
    });
</script>
</body>
</html>