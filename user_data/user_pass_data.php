<?php
require '../config/connect.php';

if(isset($_GET['user_edit_id'])){
    $user_id = $_GET['user_edit_id'];
    $query = "SELECT * FROM users WHERE `user_id` = '" . $user_id . "'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $data['phone'] = substr_replace($data['phone'], "",0, 4);
    
    $res=[
        'status'=>200,
        'data'=>$data
    ];
    echo json_encode($res);
    return;
}


if(isset($_GET['edit_user_id'])){
    $user_pass_id = $_GET['edit_user_id'];
    $query = "SELECT * FROM users WHERE `user_id` = '" . $user_pass_id . "'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    
    $res=[
        'status'=>200,
        'data'=>$data
    ];
    echo json_encode($res);
    return;
}


?>