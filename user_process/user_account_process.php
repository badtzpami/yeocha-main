<?php

include '../config/connect.php';
session_start();

// Regex pattern for Philippine phone numbers
$phone_pattern = "/^(\+639)\d{9}$/"; // Philippine phone number only

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

function validateStartYear($start_date)
{
    // Check if the input matches the YYYY-MM-DD format
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $start_date)) {

        $employed_year = date('Y-mm-dd', strtotime($start_date));
        $current_year = date('Y-mm-dd');
        $invalid_year = date('Y', strtotime($current_year)) - 60;
        $inv_year = date('Y-01-01', strtotime($invalid_year));

        if ($employed_year >= $current_year || $employed_year <= $inv_year) {
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

function validateAgeYear($birthday, $age)
{
    // Check if the input matches the YYYY-MM-DD format
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthday)) {
        $birth_year = date('Y', strtotime($birthday));
        $age_year = date('m', strtotime($age));
        $current_year = date('Y');

        $my_age = $current_year - $birth_year;


        // Check if the calculated age matches the fixed age
        if ($my_age != $age) {
            return true; // Age matches the fixed value
        }
    }
    return false; // Invalid date format or age does not match
}


// Add User Account
if (isset($_POST['valid_account'])) {
    $num_records = count($_POST['username']); // Get the number of records submitted

    for ($i = 0; $i < $num_records; $i++) {
        // Sanitize each input field
        $username = mysqli_real_escape_string($conn, $_POST['username'][$i]);
        $store = mysqli_real_escape_string($conn, $_POST['store'][$i]);
        $role = mysqli_real_escape_string($conn, $_POST['role'][$i]);
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname'][$i]);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname'][$i]);
        $email = mysqli_real_escape_string($conn, $_POST['email'][$i]);
        $phone1 = mysqli_real_escape_string($conn, $_POST['phone1'][$i]);
        $phone2 = mysqli_real_escape_string($conn, $_POST['phone2'][$i]);
        $phone = $phone1 . $phone2;
        $address = mysqli_real_escape_string($conn, $_POST['address'][$i]);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday'][$i]);
        $age = mysqli_real_escape_string($conn, $_POST['age'][$i]);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date'][$i]);


 

        $sql_username = "SELECT `username`, store FROM `users` WHERE `username` = '" . $username . "' AND `store` = '" . $store . "' ";
        $res_username = mysqli_query($conn, $sql_username);

        $sql_email = "SELECT `email`, store FROM `users` WHERE `email` = '" . $email . "'  AND `store` = '" . $store . "'";
        $res_email = mysqli_query($conn, $sql_email);



        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");



        // Example validation: Check if required fields are empty

        if (empty($username) || empty($store) || empty($firstname) || empty($lastname) || empty($email) || empty($phone2) || empty($address) || empty($role)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required.";
        } else if ($role == "Choose Role") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose right user role.";
        } else {
            if (mysqli_num_rows($res_username) > 0) {
                $response['success'] = "400";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "The ' . $username . ' username is already exist.";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['success'] = "400";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Invalid inputed email address.";
            } else if (mysqli_num_rows($res_email) > 0) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "The ' . $email . ' email is already exist.";
            } else if (!preg_match($phone_pattern, $phone) || !validatePhilippinePhoneNumber($phone)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid inputed phone number format.";
            } else if (!validateBirthday($birthday)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid inputed birthday format or date.";
            } else if (validateBirthdayYear($birthday)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid inputed birthday format or year.";
            } else if (validateStartYear($start_date)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid inputed start date format or year.";
            } else if (validateAgeYear($birthday, $age)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Age don't match to your birthday.";
            } else {
                $username =     date('Y') . $username;
                // Insert the record into the database
                $query = "INSERT INTO `users` (`username`, `store`, `firstname`, `lastname`, `email`, `phone`, `address`, `age`, `birthday`,`start_date`,`role`, `status`, `date_created_at`) 
        VALUES ('$username', '$store', '$firstname', '$lastname', '$email', '$phone', '$address',  '$age',  '$birthday',  '$start_date', '$role', 'ACTIVE', NOW())";

                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    $response['success'] = "100";
                    $response['title'] = 'User accounts added successfully!';
                    $response['message'] = "Valid credentials.";
                } else {
                    $response['success'] = "500";
                    $response['title'] = 'SOMETHING WENT WRONG!';
                    $response['message'] = "Error inserting records..";
                }
            }
        }
    }
    echo json_encode($response);
}





// Update Account
if (isset($_POST['update_account'])) {
    $num_records = count($_POST['user_id']); // Get the number of records submitted

    for ($i = 0; $i < $num_records; $i++) {
        // Sanitize each input field
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id'][$i]);
        $store = mysqli_real_escape_string($conn, $_POST['store'][$i]);
        $role = mysqli_real_escape_string($conn, $_POST['role'][$i]);
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname'][$i]);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname'][$i]);
        $email = mysqli_real_escape_string($conn, $_POST['email'][$i]);
        $phone1 = mysqli_real_escape_string($conn, $_POST['phone1'][$i]);
        $phone2 = mysqli_real_escape_string($conn, $_POST['phone2'][$i]);
        $phone = $phone1 . $phone2;
        $address = mysqli_real_escape_string($conn, $_POST['address'][$i]);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday'][$i]);
        $age = mysqli_real_escape_string($conn, $_POST['age'][$i]);
        $start_date = mysqli_real_escape_string($conn, $_POST['start_date'][$i]);


        $sql_email = "SELECT `email` FROM `users` WHERE  `user_id` != '" . $user_id . "' AND  `email` = '" . $email . "'   ";
        $res_email = mysqli_query($conn, $sql_email);



        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($firstname) || empty($store) || empty($lastname) || empty($email) || empty($phone2) || empty($address) || empty($role) || empty($start_date)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required.";
        } else if ($role == "Choose Role") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose right user role.";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['success'] = "400";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Invalid email address please type a valid email!";
            } else if (mysqli_num_rows($res_email) > 0) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Inputed   " . $email . "  email is already exist.";
            } else if (!preg_match($phone_pattern, $phone) || !validatePhilippinePhoneNumber($phone)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid phone number format.";
            } else if (!validateBirthday($birthday)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid birthday format or date.";
            } else if (validateBirthdayYear($birthday)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Exceed of legal age required.";
            } else if (validateStartYear($start_date)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Invalid inputed start date format or year.";
            } else if (validateAgeYear($birthday, $age)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Age don't match to your birthday.";
            } else {

                // Update the record into the database
                $query = "UPDATE `users`
                SET `store` = '$store',
                 `firstname` = '$firstname',
                `lastname` = '$lastname',
                `email` = '$email',
                `phone` = '$phone',
                `address` = '$address',
                `age` = '$age',
                `birthday` = '$birthday',
                `start_date` = '$start_date',
                `role` = '$role',
                `date_created_at` = '$date_updated_at'
                WHERE `user_id` = $user_id
                ";

                $query_run = mysqli_query($conn, $query);

                if ($query_run) {
                    $response['success'] = "100";
                    $response['title'] = 'User accounts updated successfully!';
                    $response['message'] = "Valid credentials.";
                } else {
                    $response['success'] = "400";
                    $response['title'] = 'Please try again!';
                    $response['message'] = "Error inserting records.";
                }
            }
        }
    }
    echo json_encode($response);
}







?>


<?php

// Update Account Status 
if (isset($_POST['update_status'])) {

    $user_id = $_POST['user_id'];
    $user_list_query = "SELECT * FROM `users` WHERE `user_id` = $user_id ORDER BY `user_id` DESC";
    $user_list_result = mysqli_query($conn, $user_list_query);
    $row = mysqli_fetch_array($user_list_result);

    if ($row['status'] == 'ACTIVE') {
        $status = 'INACTIVE';
    } else {
        $status = 'ACTIVE';
    }


    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");

    $archive_query = "
    UPDATE `users` 
    SET `status` = '" . $status . "',
    `date_updated_at` = '" . $date_updated_at . "' 
    WHERE `user_id` = '" . $user_id . "' 
    ";

    $archive_query_run = mysqli_query($conn, $archive_query);


    if ($archive_query_run) {
        $response['success'] = "100";
        $response['title'] = 'User accounts status has been updated successfully!';
        $response['message'] = "Valid credentials.";
    } else {
        $response['success'] = "400";
        $response['title'] = 'Please try again!';
        $response['message'] = "Error inserting records.";
    }
    echo json_encode($response);
}




// Update User Password

if (isset($_POST['admin_password'])) {
    error_log("Update password initiated."); // Debugging line

    $log_user_id = $_SESSION["user_id_admin"];
    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);

    // Your existing query and checks...
    $query_admin = "SELECT * FROM `users` WHERE `user_id` = $log_user_id AND `password` != '" . md5($admin_password) . "' ORDER BY `user_id` ASC";
    $admin_result = mysqli_query($conn, $query_admin);

    date_default_timezone_set('Asia/Manila');
    $date_updated_at = date("Y-m-d H:i:s");


    if ($admin_password == "" || $user_password == "") {
        $response['success'] = "400";
        $response['title'] = 'Please try again!';
        $response['message'] = "Field are required.";
    } else if (mysqli_num_rows($admin_result) > 0) {
        $response['success'] = "400";
        $response['title'] = 'Please try again!';
        $response['message'] = "Invalid admin password. Please try again.";
    } else if (strlen($user_password) < 8  || !preg_match('/[A-Z]/', $user_password) || !preg_match('/[a-z]/', $user_password) || !preg_match('/[0-9]/', $user_password)) {
        $response['success'] = "400";
        $response['title'] = 'Please try again!';
        $response['message'] = "Invalid User Password! Check if the new password meets the required criteria. Example criteria: at least 8 characters long, contains at least one uppercase letter, one lowercase letter, and one digit.";
    } else {
        $user_password = md5($user_password);
        $user_id = $_POST['u_id'];

        $user_query = "UPDATE `users` 
        SET `password` = '$user_password', 
         `session_attempt` = '1',
        `date_updated_at` = '$date_updated_at' WHERE `user_id` = '$user_id'";

        $user_query_run = mysqli_query($conn, $user_query);
        if ($user_query_run) {
            $response['success'] = "100";
            $response['title'] = 'User password has been updated successfully!';
            $response['message'] = "Valid credentials.";
        } else {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Error inserting records.";
            error_log("SQL Error: " . mysqli_error($conn)); // Log the SQL error
        }
    }

    echo json_encode($response);
}

?>