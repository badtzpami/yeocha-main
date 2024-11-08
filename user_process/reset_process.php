<?php
include '../config/connect.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../user_signin/PHPMailer/Exception.php';
require '../user_signin/PHPMailer/PHPMailer.php';
require  '../user_signin/PHPMailer/SMTP.php';

$response = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);


// /////////////////////////////////////////////////////////////////////////////////////////////////////////////


//  Send verification code


if (isset($_POST['send_email_form'])) {

    $email_reset_page = isset($_POST['username']) ? trim($_POST['username']) : '';
    if ($email_reset_page == "") {
        $res = [
            'success' => 500,
            'title' => "Please try again!",
            'message' => "Fields are Required."
        ];

        echo json_encode($res);
        return;
    } else {
        if (!filter_var($email_reset_page, FILTER_VALIDATE_EMAIL)) {
            $res = [
                'success' => 500,
                'title' => "Please try again!",
                'message' => "Invalid email address please type a valid email!"
            ];

            echo json_encode($res);
            return;
        } else {
            // echo $email_reset_page;
            $check_email = "SELECT * FROM users WHERE email = '" . $email_reset_page . "'";
            $run_sql = mysqli_query($conn, $check_email);
            if (mysqli_num_rows($run_sql) > 0) {
                $info = mysqli_fetch_assoc($run_sql);
                $name = $info['firstname'] . " " . $info['lastname'];
                $username = $info['username'];
                $code = rand(999999, 111111);

                date_default_timezone_set('Asia/Manila');
                $time = new DateTime();

                $current_time = $time->format('H:i:s');

                $time->modify('+10 minutes');

                $new_time = $time->format('H:i:s');

                $insert_code = "UPDATE users SET code = '" . $code . "', time = '" . $new_time . "' WHERE email='" . $email_reset_page . "'";
                $run_query =  mysqli_query($conn, $insert_code);
                if ($run_query) {
                    $query = "SELECT code FROM users WHERE email = '" . $email_reset_page . "'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $email_code = $row['code'];

                    $mail = new PHPMailer;

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = "rh.mis0524@gmail.com";
                    $mail->Password = "dgpq kscg ljap wvyi";
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom("rh.mis0524@gmail.com", 'Yeocha Main');
                    $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
                    $mail->addAddress($email_reset_page);
                    $mail->isHTML(true);
                    $code = rand(999999, 111111);
                    $detect_device = $_SERVER['HTTP_USER_AGENT'];


                    $year = date("Y");

                    $email_logo = '<img height="110" src="../assets/images/default_images/yeocha_logo.jpg" title="yeocha_logo" alt="yeocha_logo care">';
                    $email_footer = '© ' . ' ' . "Yeocha Main" . ' '  . $year;
                    $email_name = strtok($name, " ");
                    $code = $email_code;
                    $email_device = $detect_device;
                    $email_username = $username;

                    $email_template = '../user_signin/template_mail/reset_password.html';
                    $message = file_get_contents($email_template);
                    $message = str_replace('%email_logo%', $email_logo, $message);
                    $message = str_replace('%email_footer%', $email_footer, $message);
                    $message = str_replace('%email_name%', $email_name, $message);
                    $message = str_replace('%email_username%', $email_username, $message);
                    $message = str_replace('%email_code%', $code, $message);
                    $message = str_replace('%email_device%', $email_device, $message);
                    $mail->Subject = 'Password Reset Code';
                    $mail->MsgHTML($message);
                    if ($mail->send()) {
                        // $info = "We've sent a password reset code to your email address - $email";
                        // $_SESSION['info'] = $info;
                        // $_SESSION['email'] = $email;
                        // $_SESSION['msg_status'] = array("msg" => "Success", "icon" => "success");
                        unset($_SESSION['checkUser']);


                        unset($_SESSION['verify_email']);
                        unset($_SESSION['verify_code']);
                        unset($_SESSION['resend_email']);
                        unset($_SESSION['resend_code']);

                        $_SESSION['send_email'] = $email_reset_page;
                        $response['success'] = "100";
                        $response['message'] = 'You may now proceed to enter code!';
                    } else {

                        $response['success'] = "700";
                        $response['title'] = 'SOMETHING WENT WRONG!';
                        $response['message'] = "Failed while sending password reset code";
                    }
                } else {

                    $response['success'] = "500";
                    $response['title'] = 'Please try again!';
                    $response['message'] = "Something went wrong.";
                }
            } else {
                $response['success'] = "600";
                $response['title'] = 'Please try again!';
                $response['message'] = "Email address does not exist. Try other email.";
            }
        }
    }

    echo json_encode($response);
}
$response1 = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);




// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Verify your Entered New Code



if (isset($_POST['verify_code_form'])) {

    $code_verification_page = isset($_POST['verify_code']) ? trim($_POST['verify_code']) : '';
    $email_verification_page = isset($_POST['vc_email']) ? trim($_POST['vc_email']) : '';

    if ($code_verification_page == "") {
        $res1 = [
            'success' => 500,
            'title' => "Please try again!",
            'message' => "Fields are Required."
        ];

        echo json_encode($res1);
        return;
    } else {
        if (!(is_numeric($code_verification_page))) {
            $response1['success'] = "600";
            $response1['title'] = 'Please try again!';
            $response1['message'] = "Invalid input. Numbers only.";
        } else {
            if (strlen($code_verification_page) > 6) {
                $response1['success'] = "500";
                $response1['title'] = 'Please try again!';
                $response1['message'] = "Please enter the code exact size!";
            } else {
                $check_code = "SELECT email, code FROM users WHERE email = '" . $email_verification_page . "' AND code = '" . $code_verification_page . "'";
                $run_sql = mysqli_query($conn, $check_code);
                if (mysqli_num_rows($run_sql) > 0) {



                    $_SESSION['verify_email'] = $email_verification_page;
                    $_SESSION['verify_code'] = $code_verification_page;
                    $_SESSION['resend_email'] = $email_verification_page;
                    $_SESSION['resend_code'] = $code_verification_page;


                    $response1['success'] = "100";
                    $response1['message'] = 'Proceed to Reset Password!';
                } else {
                    $check_code1 = "SELECT * FROM `users` WHERE `email` = '" . $email_verification_page . "'";
                    $run_sql1 = mysqli_query($conn, $check_code1);

                    $info = mysqli_fetch_assoc($run_sql1);
                    $initial_time = $info['time'];

                    date_default_timezone_set('Asia/Manila');
                    // Get current time
                    $time = new DateTime();
                    $limit_time = $time->format('H:i:s');


                    if ($limit_time > $initial_time) {
                        $response1['success'] = "600";
                        $response1['title'] = 'SOMETHING WENT WRONG!';
                        $response1['message'] = "Your password reset code has expired.";
                    } else {
                        $response1['success'] = "700";
                        $response1['title'] = 'Please try again!';
                        $response1['message'] = "You've entered an invalid code!";
                    }
                }
            }
        }
    }
    echo json_encode($response1);
}

$response2 = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);





// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Send New code




if (isset($_POST['resend_code_form'])) {

    $email_verification_page = isset($_POST['rc_email']) ? trim($_POST['rc_email']) : '';

    if ($email_verification_page  < 10) {
        $response2['success'] = "500";
        $response2['title'] = 'Please try again!';
        $response2['message'] = "Unable to resend new code. Please Contact System Admin." . $email_verification_page;
    } else {
        $check_email = "SELECT * FROM users WHERE email='$email_verification_page'";
        $run_sql = mysqli_query($conn, $check_email);
        $info = mysqli_fetch_assoc($run_sql);
        $name = $info['firstname'] . " " . $info['lastname'];
        $username = $info['username'];
        $code = rand(999999, 111111);


        date_default_timezone_set('Asia/Manila');
        $time = new DateTime();

        $current_time = $time->format('H:i:s');

        $time->modify('+8 minutes');

        $new_time = $time->format('H:i:s');

        $insert_code = "UPDATE users SET code = '" . $code . "', time = '" . $new_time . "'  WHERE email='$email_verification_page'";
        $run_query =  mysqli_query($conn, $insert_code);

        if ($run_query) {
            $query = "SELECT code FROM users WHERE email = '" . $email_verification_page . "'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $email_code = $row['code'];

            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = "rh.mis0524@gmail.com";
            $mail->Password = "dgpq kscg ljap wvyi";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom("rh.mis0524@gmail.com", 'Yeocha Main');
            $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
            $mail->addAddress($email_verification_page);
            $mail->isHTML(true);
            $code = rand(999999, 111111);
            $detect_device = $_SERVER['HTTP_USER_AGENT'];


            $year = date("Y");

            $email_logo = '<img height="110" src="../assets/images/default_images/yeocha_logo.jpg" title="yeocha_logo" alt="yeocha_logo care">';
            $email_footer = '© ' . ' ' . "Yeocha Main" . ' '  . $year;
            $email_name = strtok($name, " ");
            $code = $email_code;
            $email_device = $detect_device;
            $email_username = $username;

            $email_template =  '../user_signin/template_mail/reset_password.html';
            $message = file_get_contents($email_template);
            $message = str_replace('%email_logo%', $email_logo, $message);
            $message = str_replace('%email_footer%', $email_footer, $message);
            $message = str_replace('%email_name%', $email_name, $message);
            $message = str_replace('%email_username%', $email_username, $message);
            $message = str_replace('%email_code%', $code, $message);
            $message = str_replace('%email_device%', $email_device, $message);
            $mail->Subject = 'New Password Reset Code';
            $mail->MsgHTML($message);
            if ($mail->send()) {
                $response2['success'] = "100";
                $response2['message'] = 'Code Succesfully Send!';
            } else {
                $response2['success'] = "600";
                $response2['title'] = 'Please try again!';
                $response2['message'] = "<br> Failed while sending new password reset code.";
            }
        } else {
            $response2['success'] = "700";
            $response2['title'] = 'SOMETHING WENT WRONG!';
            $response2['message'] = "Your password reset code has expired.";
        }
    }

    echo json_encode($response2);
}



$response3 = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);


// /////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['reset_password_form'])) {

    $email_reset_page = isset($_POST['email']) ? trim($_POST['email']) : '';
    $newpass_reset_page = isset($_POST['newpass']) ? trim($_POST['newpass']) : '';
    $verifypass_reset_page = isset($_POST['verifypass']) ? trim($_POST['verifypass']) : '';

    if ($newpass_reset_page == "" || $verifypass_reset_page == "") {
        $response3['success'] = "500";
        $response3['title'] = 'Please try again!';
        $response3['message'] = "Fields are Required.";
    } else if ($newpass_reset_page != $verifypass_reset_page) {
        $response3['success'] = "600";
        $response3['title'] = 'Please try again!';
        $response3['message'] = "The input password did not match.";
    } else if (strlen($newpass_reset_page) < 8  || !preg_match('/[A-Z]/', $newpass_reset_page) || !preg_match('/[a-z]/', $newpass_reset_page) || !preg_match('/[0-9]/', $newpass_reset_page)) {
        $response3['success'] = "600";
        $response3['title'] = "Please try again!";
        $response3['message'] = 'Invalid User New Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit';
    } else if (strlen($verifypass_reset_page) < 8  || !preg_match('/[A-Z]/', $verifypass_reset_page) || !preg_match('/[a-z]/', $verifypass_reset_page) || !preg_match('/[0-9]/', $verifypass_reset_page)) {
        $response3['success'] = "600";
        $response3['title'] = "Fields are Required.";
        $response3['message'] = 'Invalid User Confirm New Password! Check if the confirm new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit';
    } else {
        $password = $newpass_reset_page;
        $changesql = "SELECT * FROM users WHERE email='$email_reset_page'";
        $changequery = mysqli_query($conn, $changesql);
        if (mysqli_num_rows($changequery) > 0) {
            $info = mysqli_fetch_assoc($changequery);
            $name = $info['firstname'] . " " . $info['lastname'];
            $username = $info['username'];
            $updatesql = "UPDATE users SET password='" . md5($password) . "',session_attempt = 1 WHERE email = '$email_reset_page'";
            $updatequery = mysqli_query($conn, $updatesql);
            if ($updatequery) {
                $query = "SELECT code FROM users WHERE email = '" . $email_reset_page . "'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $email_code = $row['code'];

                $mail = new PHPMailer;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = "rh.mis0524@gmail.com";
                $mail->Password = "dgpq kscg ljap wvyi";
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom("rh.mis0524@gmail.com", 'Yeocha Main');
                $mail->addReplyTo('donotreply@gmail.com', 'DONOTREPLY');
                $mail->addAddress($email_reset_page);
                $mail->isHTML(true);
                $code = rand(999999, 111111);
                $detect_device = $_SERVER['HTTP_USER_AGENT'];


                $year = date("Y");

                $email_logo = '<img height="110" src="../assets/images/default_images/yeocha_logo.jpg" title="yeocha_logo" alt="yeocha_logo care">';
                $email_footer = '© ' . ' ' . "Yeocha Main" . ' '  . $year;
                $email_name = strtok($name, " ");
                $code = $email_code;
                $email_device = $detect_device;
                $email_username = $username;
                $email_password = $password;

                $email_template = '../user_signin/template_mail/reset_account.html';
                $message = file_get_contents($email_template);
                $message = str_replace('%email_logo%', $email_logo, $message);
                $message = str_replace('%email_footer%', $email_footer, $message);
                $message = str_replace('%email_name%', $email_name, $message);
                $message = str_replace('%email_username%', $email_username, $message);
                $message = str_replace('%email_password%', $email_password, $message);

                $mail->Subject = 'Password Reset';
                $mail->MsgHTML($message);
                if ($mail->send()) {
                    $_SESSION['email_reset'] = $email_reset_page;
                    $response3['success'] = "100";
                    $response3['message'] = 'You have successfully updated your password. You may now log in with your new password. We\'ve sent also your username and new password to your email address ' . $email_reset_page;
                } else {
                    $response3['success'] = "500";
                    $response3['title'] = 'Please try again!';
                    $response3['message'] = "Sorry, we're unable to send your username and new password to your e-mail address.";
                }
            } else {
                $response3['success'] = "700";
                $response3['title'] = 'SOMETHING WENT WRONG!';
                $response3['message'] = "Updating password failed.";
            }
        }
    }
    echo json_encode($response3);
}
