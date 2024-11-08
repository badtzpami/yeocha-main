<?php

include '../config/connect.php';
session_start();


// User Signature Picture
if (isset($_FILES["image_signature"]["name"])) {
    $id = $_POST["id_signature"];
    $name = $_POST["name_signature"];

    $imageName = $_FILES["image_signature"]["name"];
    $imageSize = $_FILES["image_signature"]["size"];
    $tmpName = $_FILES["image_signature"]["tmp_name"];

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
        if($user["signature"] !=''){
            unlink('../assets/images/signature_images/' . $user["signature"]);

        } else{
            
        }

        $newImageName = $name . "-" . date("Ymd") ; // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE users  SET `signature` = '$newImageName' WHERE `user_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/signature_images/' . $newImageName);


        $response['success'] = "100";
        $response['title'] = 'SUCCESS!';
        $response['message'] = "Successfully Change Signature.";


    }
    
    echo json_encode($response);
}
?>