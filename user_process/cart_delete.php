<?php
require '../config/connect.php';

session_start();

$response = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);

$id = $_POST['del_id'];
$query = "DELETE FROM `cart` WHERE `ct_id` = '" . $id . "'";
$result = mysqli_query($conn, $query);

if ($result == true) {
    $response['success'] = "100";
    $response['message'] = 'Successfully delete item!';
} else {
    $response['success'] = "400";
    $response['title'] = 'SOMETHING WENT WRONG!';
    $response['message'] = 'The Deleted files has Error Occured.';
}
echo json_encode($response);
