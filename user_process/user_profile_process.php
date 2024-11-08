<?php

include '../config/connect.php';
session_start();


$response = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);

// User Profile Picture
if (isset($_FILES["image"]["name"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];

    $imageName = $_FILES["image"]["name"];
    $imageSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) {
        $response['success'] = "200";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Invalid Extensions, Use: JPG, JPEG, PNG, SVG";
    } elseif ($imageSize > 1200000) {
        $response['success'] = "200";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Please Dont Use High Image Size.";
    } else {

        // unlink($user["image"]);
        if (isset($_SESSION["user_id_admin"])) {
            $id = $_SESSION["user_id_admin"];
        } else if (isset($_SESSION["user_id_cashier"])) {
            $id = $_SESSION["user_id_cashier"];
        } else {
            $id = $_SESSION["user_id_employee"];
        }

        $sessionId = $id;
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = $sessionId"));
        if($user["image"] !=''){
            unlink('../assets/images/user_images/' . $user["image"]);

        } else{
            
        }



        $newImageName = $name . "-" . date("Ymd") ; // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE users  SET `image` = '$newImageName' WHERE `user_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/user_images/' . $newImageName);

        
        $response['success'] = "100";
        $response['title'] = 'SUCCESS!';
        $response['message'] = "Successfully Change Profile.";
    }
    echo json_encode($response);
}




// Update own user information
if (isset($_POST['update_user_information'])) {

    $upd_id = $_POST['id'];

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone1 = mysqli_real_escape_string($conn, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['phone2']);
    $phone =  $phone1 . $phone2;

    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);

    $query_user_info = "SELECT * FROM `users` 
    WHERE  `firstname` = '" . $firstname . "'  AND `lastname` = '" . $lastname . "' AND `email` = '" . $email . "' AND `phone` = '" . $phone . "' AND `address` = '" . $address . "' AND `age` = '" . $age . "' AND `birthday` = '" . $birthday . "'  AND `about` = '" . $about . "'  ";
    $result = mysqli_query($conn, $query_user_info);

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");


    function validatePhilippinePhoneNumber($phone)
    {
        // Define the regex pattern to match +639 followed by 9 digits
        $phone_pattern = "/^(\+639)\d{9}$/";

        // Check if the phone number matches the pattern
        if (preg_match($phone_pattern, $phone)) {
            return true; // Valid Philippine phone number
        }
    }

    function validateBirthday($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
            // Parse the date into components
            $dateComponents = explode('-', $birthday);

            // Check if the date is valid
            if (checkdate($dateComponents[1], $dateComponents[2], $dateComponents[0])) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    function validateBirthdayYear($birthday)
    {
        // Check if the input matches the YYYY-MM-DD format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {

            $birth_year = date('Y', strtotime($birthday));
            $current_year = date('Y');
            $legal_year = $current_year - 18;
            $invalid_year = $current_year - 60;

            if ($birth_year >= $current_year || $birth_year > $legal_year || $birth_year <= $invalid_year) {
                return true; // Valid date
            }
        }
        return false; // Invalid date format or invalid date
    }

    $sql_upd_email = "SELECT `email` FROM `users` WHERE `email` = '" . $email . "' ";
    $res_upd_email = mysqli_query($conn, $sql_upd_email);



    if ($firstname == "" || $lastname == "" || $email == ""  || $about == "" || $phone2 == "" || $address == "" || $birthday == "" || $age == "") {
        $res_info['success'] = "400";
        $res_info['title'] = 'Please try again!';
        $res_info['message'] = "Invalid Current Password Please Try Again.";
    } else  if (mysqli_num_rows($result) > 0) {
        $res_info['success'] = "500";
        $res_info['title'] = 'SOMETHING WENT WRONG!';
        $res_info['message'] = "There has no changes in your data field.";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $res_info['success'] = "400";
        $res_info['title'] = 'Please try again!';
        $res_info['message'] = "Invalid email address please type a valid email.";
    } else if (!is_string($phone)) {
        $res_info['success'] = "400";
        $res_info['title'] = 'Please try again!';
        $res_info['message'] = "Invalid phone number format.";
    } else if (!validatePhilippinePhoneNumber($phone)) {
        $res_info['success'] = "400";
        $res_info['title'] = 'Please try again!';
        $res_info['message'] = "Invalid phone number format.";
    } else if (!validateBirthday($birthday)) {
        $res_info['success'] = "400";
        $res_info['title'] = 'Please try again!';
        $res_info['message'] = "Invalid birthday format or date.";
    } else if (validateBirthdayYear($birthday)) {
        $res_info['success'] = "500";
        $res_info['title'] = 'SOMETHING WENT WRONG!';
        $res_info['message'] = "Limit exceed of legal age required.";
    } else {
        $query_new_info = " UPDATE `users` 
        SET `firstname` = '" . $firstname . "',
        `lastname` = '" . $lastname . "',
        `email` = '" . $email . "',
        `phone` = '" . $phone . "', 
        `address` = '" . $address . "', 
        `age` = '" . $age . "', 
        `birthday` = '" . $birthday . "',
        `about` = '" . $about . "',
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `user_id` = '" . $upd_id . "'  ";
        $query_run_info = mysqli_query($conn, $query_new_info);
        if ($query_run_info) {
            $res_info['success'] = "200";
            $res_info['title'] = 'Your Information Updated Successfully!';
            $res_info['message'] = "Valid user cridential.";
        }
    }
    echo json_encode($res_info);
}



if (isset($_POST['update_user_password'])) {

    $user_id = $_POST['pass_id'];
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $newpassword1 = mysqli_real_escape_string($conn, $_POST['newpassword1']);
    $newpassword2 = mysqli_real_escape_string($conn, $_POST['newpassword2']);


    $user_sql = mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = '$user_id'");
    $row = mysqli_fetch_array($user_sql);
    $pass = $row['password'];


    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");

    if ($password == "" || $newpassword1 == "" || $newpassword2 == "") {
        $res_pass['success'] = "400";
        $res_pass['title'] = 'Please try again!';
        $res_pass['message'] = "Fields are Required.";
    } else {

        if (md5($password) != $pass) {
            $res_pass['success'] = "400";
            $res_pass['title'] = 'Please try again!';
            $res_pass['message'] = "Invalid Current Password Please Try Again.";
        } else if ($newpassword1 != $newpassword2) {
            $res_pass['success'] = "400";
            $res_pass['title'] = 'Please try again!';
            $res_pass['message'] = "New Password Are Not Match.";
        } else {
            if ($password == $newpassword1 || $password == $newpassword2) {
                $res_pass['success'] = "400";
                $res_pass['title'] = 'Please try again!';
                $res_pass['message'] = "Use Other New Password That Not Match Your Current Password.";
            } else if (strlen($newpassword1) < 8  || !preg_match('/[A-Z]/', $newpassword1) || !preg_match('/[a-z]/', $newpassword1) || !preg_match('/[0-9]/', $newpassword1)) {
                $res_pass['success'] = "400";
                $res_pass['title'] = 'Please try again!';
                $res_pass['message'] = "Invalid User Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit.";
            } else {
                $query = " UPDATE `users` 
        SET `password` = '" . md5($newpassword1) . "',
        `date_updated_at` = '" . $date_updated_at . "' 
        WHERE `user_id` = '" . $user_id . "'  ";
                $query_run = mysqli_query($conn, $query);
                if ($query_run) {
                    $res_pass['success'] = "200";
                    $res_pass['title'] = 'Password Updated Successfully!';
                    $res_pass['message'] = "Valid user cridential.";
                }
            }
        }
    }
    echo json_encode($res_pass);
}
