<?php
error_reporting(0);
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css" />

    <link rel="shortcut icon" type="../assets/images/default_images/yeocha.png" href="../assets/images/default_images/yeocha.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="signin.css">

    <title>Sign In</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            position: relative;
        }

        /* Container for the progress bar */
        .progress-div {
            display: none;
            /* Hidden by default, shown when needed */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            /* Adjust width as necessary */
            background-color: rgba(115, 132, 165, 0.678);
            /* Light background color */
            border: 1px solid #ccc;
            /* Border with a light gray color */
            border-radius: 5px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
            padding: 20px;
            /* Padding inside the box */
            text-align: center;
            z-index: 1000;
            /* Make sure it's above other elements */
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Message text above the progress bar */
        #progress_msg {
            color: #fff;
            font-weight: 500;
            font-family: 'Poppins-Regular', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;

            margin-bottom: 10px;
            /* Space between message and progress bar */
            font-size: 16px;
        }

        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: linear-gradient(45deg, #421710, #000);
            display: flex;
            justify-content: top;
            align-items: top;
            z-index: 9999;
        }

        .progress-circle {
            display: flex;
            justify-content: top;
            align-items: top;
            width: 150px;
            height: 150px;
            /* background-color: rgba(255, 255, 255, 0.8); */
            border-radius: 50%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            /* Keep it relative for z-index control */
            z-index: 10000;
        }

        .progress-value {
            position: absolute;
            top: 65px;
            left: 64px;
            font-weight: bold;
            color: #333;
            font-family: 'Montserrat', sans-serif;
            z-index: 10001;
            /* Make sure it's on top of everything */
        }


        .progress-ring {
            position: absolute;
            transform: rotate(-90deg);
        }

        .progress-ring__circle {
            transition: stroke-dasharray 0.5s;
            stroke-dasharray: 0 327;
            stroke-linecap: round;
        }

        /* For making the stroke visible with a background color */
        circle {
            stroke: darkred;
        }

        .progress-value {
            position: absolute;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            font-family: 'Montserrat', sans-serif;
            z-index: 10001;
            /* Make sure it's on top of everything */
        }


        .progress-ring {
            position: absolute;
            transform: rotate(-90deg);
        }

        .progress-ring__circle {
            transition: stroke-dasharray 0.5s;
            stroke-dasharray: 0 327;
            stroke-linecap: round;
        }

        /* For making the stroke visible with a background color */
        circle {
            stroke: black;
        }
    </style>

</head>

<body>
    <div class="progress-container" id="progressCircle" style="display: none;">
        <div class="progress-circle">
            <span class="progress-value">0%</span>
            <svg class="progress-ring" width="150" height="150">
                <circle class="progress-ring__circle" stroke-width="10" fill="transparent" r="70" cx="75" cy="75" />
            </svg>

        </div>
            <p id="progress_msg" style="float: bottom; position: absolute; align-items: bottom; width: 200px; top: 250px; bottom: 0;  font-weight: bold; font-size:12px"></p>
    </div>



    <div class="login-wrap">

        <!-- Message Box -->
        <div class="message-box" id="messageBox" style="display: none;">
            <div class="close-btn" id="closeBtn">
                <button type="button" class="close mr-1" style="border:0;" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="border:0; font-size: 22px;">&times;</span>
                </button>
            </div>
            <p id="error_msg"></p>
            <div class="loading-bar-container">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
        </div>

        <div class="login-card">

            <!-- Login Form -->
            <form id="login_form" class="login100-form validate-form">
                <span class="login100-form-logo">
                    <img src="../assets/images/default_images/yeocha_logo.jpg" class="yeocha" alt="" width="100%" height="90">
                </span>
                <span class="login100-form-title">
                    Sign-In
                </span>


                <div class="form">
                    <i id="account" class="mdi mdi-account menu-icon"></i>
                    <input type="text" id="username" name="username" class="username" placeholder="Username">
                    <div class="password-container">
                        <i id="lock" class="mdi mdi-lock menu-icon"></i>
                        <input type="password" id="password" class="password" name="password" placeholder="Enter Password" />
                        <span><i id="toggler" class="far fa-eye"></i></span>
                    </div>

                    <div id="container">
                        <h5><a class="txt1" id="attemptCount"></a></h5>
                    </div>

                    <button type="submit" id="signinBtn" style="align-items: center;">Sign In</button>



                    <div id="container">
                        <h5><a class="txt2" href="/yeocha_main/user_signin/reset-page.php">Forgotten you password?</a></h5>
                    </div>
                </div>
            </form>


        </div>
    </div>
    <!-- <script src="../assets/js/signin.js"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- modal -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <!-- sweetalert2 message -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>

</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let circle = document.querySelector('.progress-ring__circle');
        let valueText = document.querySelector('.progress-value');

        // Total circumference of the circle
        const radius = circle.r.baseVal.value;
        const circumference = 2 * Math.PI * radius;

        circle.style.strokeDasharray = `${circumference} ${circumference}`;

        let progress = 0;
        let interval = setInterval(() => {
            progress += 1;
            if (progress > 99) {
                clearInterval(interval);
            }

            const offset = circumference - (progress / 100) * circumference;
            circle.style.strokeDasharray = `${circumference - offset} ${circumference}`;
            valueText.textContent = `${progress}%`;
        }, 50); // Adjust speed of animation
    });

    // Toggle password visibility
    var password = document.getElementById('password');
    var toggler = document.getElementById('toggler');
    showHidePassword = () => {
        if (password.type == 'password') {
            password.setAttribute('type', 'text');
            toggler.classList.add('fa-eye-slash');
        } else {
            toggler.classList.remove('fa-eye-slash');
            password.setAttribute('type', 'password');
        }
    };

    toggler.addEventListener('click', showHidePassword);

    // Function to show the custom message box
    function showMessageBox(title, message, icon) {
        // Update the message box content
        $('#error_msg').html(`<div class="alert alert-danger" role="alert" style="font-size: 16px;"><strong>${title}</strong><br>${message}</div>`);

        // Optionally, set different styles based on the icon
        if (icon === 'success') {
            $('#error_msg').css('color', 'green');
        } else if (icon === 'warning') {
            $('#error_msg').css('color', 'orange');
        } else if (icon === 'error') {
            $('#error_msg').css('color', 'red');
        }

        // Show the message box
        $('#messageBox').show();

        // Hide the message box after 4 seconds (adjust as needed)
        setTimeout(function() {
            $('#messageBox').fadeOut();
        }, 10000);
    }

    // Function to show the progress bar
    function showProgressBar(message) {
        $('#progressCircle').show();
        // Update the message box content
        $('#progress_msg').html(`<strong>${message}</strong>`);
        // Optionally, you can add animation to the progress bar here
        $('#progressCircle .progress-bar').css('width', '100%');

        // Hide the progress bar after the redirect
        setTimeout(function() {
            $('#progressCircle').fadeOut();
        }, 5000);
    }

    // Close message box on clicking the close button
    $('#closeBtn').on('click', function() {
        $('#messageBox').fadeOut();
    });




    $(document).ready(function() {

        $('#login_form').on('submit', function(e) {

            e.preventDefault();

            const username = $('#username').val();
            const password = $('#password').val();
            const login_form = $('#login_form').val();

            $.ajax({
                url: '../user_process/signin_process.php',
                type: 'POST',
                data: {
                    username: username,
                    password: password,
                    login_form: login_form
                },
                success: function(response) {
                    var res = jQuery.parseJSON(response);

                    if (res.success == 100) {
                        $('#messageBox').hide();

                        showProgressBar(res.message);
                        setTimeout(function() {
                            location.href = '/yeocha_main/admin/dashboard.php';
                        }, 5000);
                    } else if (res.success == 200) {
                        $('#messageBox').hide();

                        showProgressBar(res.message);
                        setTimeout(function() {
                            location.href = '/yeocha_main/cashier/home.php';
                        }, 5000);
                    } else if (res.success == 300) {
                        $('#messageBox').hide();

                        showProgressBar(res.message);
                        setTimeout(function() {
                            location.href = '/yeocha_main/employee/home.php';
                        }, 5000);
                    } else if (res.success == 400) {
                        $('#messageBox').hide();

                        showProgressBar(res.message);
                        setTimeout(function() {
                            location.href = '/yeocha_main/supplier/home.php';
                        }, 5000);
                    } else if (res.success == 500) {
                        showMessageBox(res.title, res.message, 'warning');

                    } else if (res.success == 600) {
                        showMessageBox(res.title, res.message, 'warning');
                    } else if (res.success == 700) {
                        showMessageBox(res.title, res.message, 'warning');
                        $("#attemptCount").html(res.session);

                    } else {
                        $('#messageBox').hide();

                        showProgressBar(res.message);

                        setTimeout(function() {
                            location.href = '/yeocha_main/user_signin/signin.php';
                        }, 5000);
                    }
                },
                error: function(error) {
                    showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                    console.log('error', error);
                }
            })
        });
    });
</script>