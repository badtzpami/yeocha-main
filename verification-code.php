<?php
error_reporting(0);
session_start();


// unset($_SESSION['checkUser']);
if (isset($_SESSION['checkUser']) || !isset($_SESSION['send_email']) || isset($_SESSION['verify_email']) || isset($_SESSION['verify_code']) || isset($_SESSION['resend_email']) || isset($_SESSION['resend_code'])) {
    header("Location: ../reset-page.php");
    session_destroy();
} else
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
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/animate.css">
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="./assets/vendors/mdi/css/materialdesignicons.min.css" />

    <link rel="shortcut icon" type="./assets/images/default_images/yeocha.png" href="./assets/images/default_images/yeocha.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="signin.css">

    <title>Verification Code</title>

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
            background-color: rgba(130, 138, 130, 0.678);
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

        /* Container for the progress bar itself */
        .progress-container {
            width: 50%;
            /* background-color: #e0e0e0; */
            /* Light gray background for the bar */
            border-radius: 5px;
            overflow: hidden;
            /* Ensures the progress bar stays within the rounded corners */
        }

        /* The progress bar */
        .progress-bar {
            height: 20px;
            /* Height of the progress bar */
            width: 0%;
            /* Start at 0% width, will be animated */
            background-color: #000;
            /* Green color */
            border-radius: 5px;
            left: 0;
            transition: width 1s ease-in-out;
            /* Smooth transition for width changes */
        }

        @keyframes progress {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }


        .message-box {
            position: fixed;
            /* Fixes it relative to the viewport */
            top: 20px;
            /* Distance from the top */
            left: 20px;
            /* Distance from the right */
            z-index: 1000;
            /* Ensures it is in front of other elements */
            background-color: white;
            /* Background color */
            border: 1px solid #ccc;
            /* Border styling */
            border-radius: 5px;
            /* Rounded corners */
            padding: 15px;
            /* Inner spacing */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        .close-btn {
            display: flex;
            align-items: right;
            border: 0;
            top: 0;
            right: 1px;
            margin: 10px;
        }
    </style>

</head>

<body>
    <div class="progress-div" id="progressDiv" style="display: none;">

        <p id="progress_msg"></p>
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>
    </div>

    <div class="login-wrap">

        <!-- Message Box -->
        <div class="message-box" id="messageBox" style="display: none;">
            <div class="close-btn" id="closeBtn">
                <button type="button" class="close mr-1" style="border:0; background: none;" aria-label="Close">
                    <span aria-hidden="true" style="border:0; font-size: 22px;">&times;</span>
                </button>
            </div>
            <i id="logo_msg"></i>
            <p id="new_msg"></p>
            <div class="loading-bar-container">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
        </div>

        <span class="login100-form-left-background">
            <img src="./assets/images/default_images/store.jpg" class="yeocha_background" alt="" width="100%" height="100">
        </span>

        <div class="login-card">

            <!-- Login Form -->
            <form id="verify_code_form" class="login100-form validate-form">
                <div class="login100-form-logo">
                    <img src="./assets/images/default_images/yeotrack_logo.png" class="yeocha_logo">
                </div>

                <span class="login100-form-title">
                    CODE VERIFICATION
                </span>


                <div class="form">
                    <div class="form-input">
                        <i id="email" class="mdi mdi-numeric menu-icon"></i>
                        <input type="text" id="verify_code" name="verify_code" class="verify_code" placeholder="Enter 6 digits code">
                    </div>

                    <div class="form-input">
                        <button type="submit" class="login100-form-btn button">
                            SUBMIT
                        </button>
                        <input type="hidden" id="vc_email" name="vc_email" value="<?php echo $_SESSION['send_email']; ?>">
                    </div>

            </form>

            <div id="container" style="font-size: 12px;">
                <div class="row" id="bottom-row">
                    <form id="resend_code_form">
                        <div class="form-input">
                            <input type="hidden" id="rc_email" name="rc_email" value="<?php echo $_SESSION['send_email']; ?>">
                        </div>
                        <div class="button-wrapper">
                            <a class="back_login " href="/index.php">Back to Log in</a>

                            <button type="submit" class="btn-resend">
                                Send new Code
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>


    </div>
    <!-- <script src="./assets/js/signin.js"></script> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <!-- modal -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <!-- sweetalert2 message -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" charset="utf-8"></script>


    <script>
        // Function to show the custom message box
        function showMessageBox(title, message, icon) {
            // Update the message box content

            $('#new_msg').html(`<div class="alert alert-info" role="alert" style="font-size: 14px;"><strong><span>${title}</span></strong><br><span>${message}</span></div>`);

            // Optionally, set different styles based on the icon
            if (icon === 'success') {
                $('#message').css('color', 'green');
                $('#logo_msg').css('color', 'green');
                $('#logo_msg').css('font-size', '52px');
                $('#logo_msg').css('display', 'flex');
                $('#logo_msg').css('justify-content', 'center');
                $('#logo_msg').css('text-align', 'center');
                $('#logo_msg').css('margin-bottom', '22px');
                $('#logo_msg').attr('class', 'bi bi-check-circle-fill'); // Set class for success
                $('#loadingBar').css('background-color', 'green');
            } else if (icon === 'warning') {
                $('#message').css('color', 'orange');
                $('#logo_msg').css('color', 'orange');
                $('#logo_msg').css('font-size', '52px');
                $('#logo_msg').css('display', 'flex');
                $('#logo_msg').css('justify-content', 'center');
                $('#logo_msg').css('text-align', 'center');
                $('#logo_msg').css('margin-bottom', '22px');
                $('#logo_msg').attr('class', 'bi bi-exclamation-circle-fill'); // Set class for success
                $('#loadingBar').css('background-color', 'orange');
            } else {
                $('#message').css('color', 'red');
                $('#logo_msg').css('color', 'red');
                $('#logo_msg').css('font-size', '52px');
                $('#logo_msg').css('display', 'flex');
                $('#logo_msg').css('justify-content', 'center');
                $('#logo_msg').css('text-align', 'center');
                $('#logo_msg').css('margin-bottom', '22px');
                $('#logo_msg').attr('class', 'bi bi-dash-circle-fill'); // Set class for success
                $('#loadingBar').css('background-color', 'red');
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
            $('#progressDiv').show();
            // Update the message box content
            $('#progress_msg').html(`<strong>${message}</strong>`);
            // Optionally, you can add animation to the progress bar here
            $('#progressDiv .progress-bar').css('width', '100%');

            // Hide the progress bar after the redirect
            setTimeout(function() {
                $('#progressDiv').fadeOut();
            }, 5000);
        }

        // Close message box on clicking the close button
        $('#closeBtn').on('click', function() {
            $('#messageBox').fadeOut();
        });


        $(document).ready(function() {

            $('#verify_code_form').on('submit', function(e) {

                e.preventDefault();

                const verify_code = $('#verify_code').val();
                const vc_email = $('#vc_email').val();
                const verify_code_form = $('#verify_code_form').val();

                $.ajax({
                    url: './user_process/reset_process.php',
                    type: 'POST',
                    data: {
                        verify_code: verify_code,
                        vc_email: vc_email,
                        verify_code_form: verify_code_form
                    },
                    success: function(response1) {
                        var res1 = jQuery.parseJSON(response1);

                        if (res1.success == 100) {
                            $('#messageBox').hide();

                            showProgressBar(res1.message);
                            setTimeout(function() {
                                location.href = '/resetpassword.php';
                            }, 3000);
                        } else if (res1.success == 500) {
                            showMessageBox(res1.title, res1.message, 'warning');
                        } else if (res1.success == 600) {
                            showMessageBox(res1.title, res1.message, 'warning');
                        } else {
                            showMessageBox(res1.title, res1.message, 'warning');
                        }
                    },
                    error: function(error) {
                        showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                        console.log('error', error);
                    }
                })
            });
        });


        $(document).ready(function() {

            $('#resend_code_form').on('submit', function(e) {

                e.preventDefault();

                const rc_email = $('#rc_email').val();
                const resend_code_form = $('#resend_code_form').val();

                $.ajax({
                    url: './user_process/reset_process.php',
                    type: 'POST',
                    data: {
                        rc_email: rc_email,
                        resend_code_form: resend_code_form
                    },
                    success: function(response2) {
                        var res2 = jQuery.parseJSON(response2);

                        if (res2.success == 100) {
                            $('#messageBox').hide();

                            showProgressBar(res2.message);
                            setTimeout(function() {
                                location.href = '/verification-code.php';
                            }, 3000);
                        } else if (res2.success == 500) {
                            showMessageBox(res2.title, res2.message, 'warning');
                        } else if (res2.success == 600) {
                            showMessageBox(res2.title, res2.message, 'warning');
                        } else {
                            showMessageBox(res2.title, res2.message, 'warning');
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
</body>

</html>