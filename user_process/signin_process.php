<?php
include '../config/connect.php';
session_start();

$response = array(
	'success' => "500",
	'message' => 'Unknown Error',
	'title' => '',
	'session' => "0"
);


$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';


if ($username == "" || $password == "") {

	$res = [
		'success' => 500,
		'title' => "Please try again!",
		'message' => "Fields are Required."
	];

	echo json_encode($res);
	return;
} else {

	$checkUser = "SELECT * FROM `users` WHERE (`username` = '" . $username . "' OR  `email` = '" . $username . "') AND  `status` != 'INACTIVE'";
	$checkUser_run = mysqli_query($conn, $checkUser);

	// check if the username exists
	if (mysqli_num_rows($checkUser_run) > 0) {

		$check = mysqli_fetch_assoc($checkUser_run);
		if ($check['session_attempt'] >= 5) {

			// unset($_SESSION['verify_email']);
			// unset($_SESSION['verify_code']);
			$_SESSION['checkUser'] = $username;
			$response['success'] = "900";
			$response['title'] = 'Attempt limit exceeded!';
			$response['message'] = "Reset your Password. or Contact your Admin.";
			$response['session'] = "Login Attempts: 5";
		} else {


			// check password
			$checkPassword = "SELECT * FROM `users` WHERE ( `username` = '" . $username . "' OR  `email` = '" . $username . "')  AND `password` = '" . md5($password) . "'";
			$checkPasswordrun = mysqli_query($conn, $checkPassword);

			$row = mysqli_fetch_assoc($checkPasswordrun);

			// If username exists, check if the password matches
			if (mysqli_num_rows($checkPasswordrun) > 0) {
				date_default_timezone_set('Asia/Manila');
				$currentDateTime = date("Y-m-d H:i:s");

				$_SESSION['name'] = $row['firstname'] . " " . $row['lastname'];
				if ($row['role'] == 'Admin' && $row['session_attempt'] <= 4 && $row['status'] != 'INACTIVE') {
					$_SESSION["user_id_admin"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `users` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`user_id`, `date_created_at`) 
				VALUE ('" . $row['user_id'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);


					$response['success'] = "100";
					$response['message'] = 'Admin Login Succesfully!';
				} else if ($row['role'] == 'Cashier' && $row['session_attempt'] <= 5 && $row['status'] != 'INACTIVE') {
					$_SESSION["user_id_cashier"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `users` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`user_id`, `date_created_at`) 
				VALUE ('" . $row['user_id'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);

					$response['success'] = "200";
					$response['message'] = 'Cashier Login Succesfully!';
				} else if ($row['role'] == 'Employee' && $row['session_attempt'] <= 5 && $row['status'] != 'INACTIVE') {
					
					$_SESSION["user_id_employee"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `users` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`user_id`, `date_created_at`) 
				VALUE ('" . $row['user_id'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);

					$response['success'] = "300";
					$response['message'] = 'Employee Login Succesfully!';
				} else if ($row['role'] == 'Supplier' && $row['session_attempt'] <= 5 && $row['status'] != 'INACTIVE') {

					$_SESSION["user_id_supplier"] = $row['user_id'];
					$_SESSION['name'];

					$session_attempt_query = "UPDATE `users` 
				SET `session_attempt` = 1
				WHERE `user_id` = " . $row['user_id'] . "  ";
					$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

					$login_query = "INSERT INTO `loginhistory` (`user_id`, `date_created_at`) 
				VALUE ('" . $row['user_id'] . "', '$currentDateTime')";
					$login_run = mysqli_query($conn, $login_query);

					$response['success'] = "400";
					$response['message'] = 'Supplier Login Succesfully!';
				} else {
					$response['success'] = "800";
					$response['title'] = 'ACCOUNT IS UNAVAILALE!';
					$response['message'] = 'Please Contact your Admin.';
					$response['session'] = "";
				}
			} else {
				// Increment attempts
				$session_attempt_query = "UPDATE `users` 
				SET `session_attempt` = " . $check['session_attempt'] + 1 . "
				WHERE `user_id` = " . $check['user_id'] . "  ";
				$session_attempt_query_run = mysqli_query($conn, $session_attempt_query);

				$response['success'] = "700";
				$response['title'] = 'SOMETHING WENT WRONG!';
				$response['message'] = "Invalid Username or Password. You only have " . 5 - $check['session_attempt'] . " Attempt";
				$response['session'] = "Login Attempts: " . $check['session_attempt'];
			}
		}
	} else {
		// unset($_SESSION['verify_email']);
		// unset($_SESSION['verify_code']);
		$response['success'] = "600";
		$response['title'] = 'Use other User Name!';
		$response['message'] = "Your username does not exist.";
		$response['session'] = "";
	}
}


$_SESSION['checkUser'] = $username;
echo json_encode($response);
