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

    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="../assets/css/dataTables.bootstrap4.min.css">


    <link rel="shortcut icon" type="../assets/images/default_images/brindox.png" href="../assets/images/default_images/brindox.png">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="signin.css">

    <title>Reset Page</title>

</head>

<body>
    <div class="login-wrap">
        <!-- Message Box -->
        <div class="message-box" id="messageBox">
            <div class="close-btn" id="closeBtn">x</div>
            <p id="error_msg"><?php echo '' ? '' : 'Fields are required' ?></p>
            <div class="loading-bar-container">
                <div class="loading-bar" id="loadingBar"></div>
            </div>
        </div>

        <div class="login-card">

            <!-- Login Form -->
            <form id="login_form" class="login100-form validate-form" action="../user_process/resetpassword_process.php" method="POST">
                <span class="login100-form-logo">
                    <img src="../assets/images/default_images/brindox.png" class="brindox" alt="" width="100%" height="90">
                </span>
                <span class="login100-form-title">
                    FORGOT PASSWORD
                </span>


                <div class="form">
                    <i id="email" class="mdi mdi-email menu-icon"></i>
                    <input type="text" id="username" name="email" class="username" placeholder="Email Address">
                    <div id="container">
                        <h5><a class="txt1"></a></h5>
                    </div>
                    <button type="submit" name="check-email" id="signinBtn" style="align-items: center;">Continue</button>

                    <div id="container">
                        <h5><a class="txt2" href="/pharmacy/usersignin/signin.php">Back to Login</a></h5>
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
    <?php
    if (isset($_SESSION['forgot_pass'])) {
        $title = $_SESSION['forgot_pass'];
        $icon = $_SESSION['forgot_icon']; ?>
        <script>
            document.getElementById('error_msg').innerHTML = '<div class="alert alert-danger" role="alert" style="font-size:12px;"><?php echo $title ?></div>';
        </script>
    <?php    }
    unset($_SESSION['forgot_pass']);
    unset($_SESSION['forgot_icon']);
    ?>

    <script>
        // Function to show the message box
        function showMessage() {
            var messageBox = document.getElementById('messageBox');
            messageBox.style.display = 'block';

            // Hide the message box after 10 seconds
            setTimeout(function() {
                messageBox.style.display = 'none';
            }, 10000);
        }

        // Event listener to close the message box
        document.getElementById('closeBtn').addEventListener('click', function() {
            document.getElementById('messageBox').style.display = 'none';
        });

        // Show the message box when the page loads
        window.onload = showMessage;
    </script>
</body>

</html>