<?php
include '../config/connect.php';
session_start();
$response = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);
if (isset($_POST['valid_order'])) {
    // Check if 'material_name' is set and is an array
    if (isset($_POST['material_name']) && is_array($_POST['material_name'])) {
        $checked_array = $_POST['material_name'];

        // Iterate through the array of material names
        foreach ($checked_array as $key => $material_name) {
            // Ensure that each necessary field is set and not empty before accessing
            $order_code = isset($_POST['order_code'][$key]) ? $_POST['order_code'][$key] : '';
            $user_id = isset($_POST['user_id'][$key]) ? $_POST['user_id'][$key] : '';
            $sm_id = isset($_POST['sm_id'][$key]) ? $_POST['sm_id'][$key] : '';
            $quantity = isset($_POST['quantity'][$key]) ? $_POST['quantity'][$key] : '';
            $sell_price = isset($_POST['sell_price'][$key]) ? $_POST['sell_price'][$key] : '';
            $total = isset($_POST['total'][$key]) ? $_POST['total'][$key] : '';
            $cash = isset($_POST['cash'][$key]) ? $_POST['cash'][$key] : '';
            $change = isset($_POST['change'][$key]) ? $_POST['change'][$key] : '';
            $alltotal = isset($_POST['alltotal'][$key]) ? $_POST['alltotal'][$key] : '';
            $time_arrival = isset($_POST['time_arrival'][$key]) ? $_POST['time_arrival'][$key] : '';
            $day_arrival = isset($_POST['day_arrival'][$key]) ? $_POST['day_arrival'][$key] : '';
            $status = isset($_POST['status'][$key]) ? $_POST['status'][$key] : '';

            date_default_timezone_set('Asia/Manila');
            $date_created_at = date("Y-m-d H:i:s");

            // Validate if cash and change are provided
            if (empty($cash) || empty($change)) {
                $response['status'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = 'Fields are Required in Cash.';
            } else if (empty($sm_id)) {
                $response['status'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = 'Fields are Required.' . $material_name . "<br>";
            } else if ($cash < $alltotal &&  1 < $alltotal) {
                $response['status'] = "400";
                $response['title'] = 'Something went wrong!';
                $response['message'] = 'Try Higher Amount Cash';
            } else {
                // Insert into order table
                $insertqry = "INSERT INTO `order`(`order_code`, `user_id`, `sm_id`, `quantity`, `sell_price`, `total`, `cash`, `change`, `day_arrival`, `time_arrival`, `status`, `date_created_at`) 
                VALUES ('$order_code', '$user_id', '$sm_id', '$quantity', '$sell_price', '$total', '$cash', '$change', '$day_arrival', '$time_arrival', '$status', '$date_created_at')";
                $insertres = mysqli_query($conn, $insertqry);

                $insertqry = "INSERT INTO `order_history`(`order_code`, `user_id`, `sm_id`, `quantity`, `sell_price`, `total`, `cash`, `change`, `day_arrival`, `time_arrival`, `status`, `date_created_at`) 
                VALUES ('$order_code', '$user_id', '$sm_id', '$quantity', '$sell_price', '$total', '$cash', '$change', '$day_arrival', '$time_arrival', '$status', '$date_created_at')";
                $insertres = mysqli_query($conn, $insertqry);

                // Delete from cart table
                $deletequery = "DELETE FROM `cart` WHERE `sm_id` = '$sm_id' AND `user_id` = '$user_id'";
                $deleteresult = mysqli_query($conn, $deletequery);

                $sql_order = "SELECT * FROM `supplier_material` WHERE sm_id = $sm_id";
                $res_order = mysqli_query($conn, $sql_order);
                $order = mysqli_fetch_array($res_order);
                $stock = $order['stock'] - $quantity;
                // Update stock in supplier_material table
                $querystock = "UPDATE `supplier_material` SET `stock` = '" . $stock . "' WHERE `sm_id` = '$sm_id'";
                $querystock_res = mysqli_query($conn, $querystock);


                // Check if everything was successful
                if ($insertres && $deleteresult && $querystock_res && $insertres) {
                    $response['success'] = "100";
                    $response['message'] = 'Item Check Out Successfully!';
                } else {
                    $response['status'] = "500";
                    $response['message'] = 'Something went wrong!';
                }
            }
        }
    } else {
        // Handle case where 'material_name' is not set or not an array
        $response['status'] = "400";
        $response['message'] = 'Materials are not selected or not set correctly.';
    }

    echo json_encode($response);
    return;
}



// Update User Category of a Product

if (isset($_POST['update_order'])) {
    $or_id = $_POST['or_id'];
    date_default_timezone_set('Asia/Manila');
    $date_created_at = date("Y-m-d H:i:s");

    $sql_all = "SELECT * FROM `order` WHERE or_id = " . $or_id . " ";
    $res_all = mysqli_query($conn, $sql_all);
    $all = mysqli_fetch_array($res_all);

    if ($all['status'] == 'Cancelled') {
        $status = 'Buy Again';

        // Query cart
        $sql_cart = "SELECT * FROM `cart` WHERE `sm_id` = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param('i', $all['sm_id']);
        $stmt_cart->execute();
        $res_cart = $stmt_cart->get_result();
        $cart = $res_cart->fetch_array(MYSQLI_ASSOC);

        // Check if product exists in cart
        if ($cart) {
            // Update cart with new quantity and total
            $new_quantity = $cart['quantity'] + $all['quantity'];
            $query_insert_sale = "UPDATE `cart` SET `sell_price` = ?, `quantity` = ?, `total` = ?, `user_id` = ?, `date_created_at` = ? WHERE `sm_id` = ?";
            $stmt_sale = $conn->prepare($query_insert_sale);
            $stmt_sale->bind_param('diissi', $all['sell_price'], $new_quantity, $all['total'], $all['user_id'], $date_created_at, $all['sm_id']);
            $stmt_sale->execute();
        } else {
            // Insert into cart
            $query_insert_sale = "INSERT INTO `cart` (sm_id, sell_price, quantity, total, user_id, date_created_at) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_sale = $conn->prepare($query_insert_sale);
            $stmt_sale->bind_param('diissi', $all['sm_id'], $all['sell_price'], $all['quantity'], $all['total'], $all['user_id'], $date_created_at);
            $stmt_sale->execute();
        }
    } else if ($all['status'] == 'Check Out') {

        if (isset($_SESSION["user_id_admin"])) {
            $status = 'Cancelled';
        } else if (isset($_SESSION["user_id_supplier"])) {
            $status = 'To Pack';
        } else {
        }
    } else if ($all['status'] == 'To Pack') {
        $status = 'To Ship';
    } else if ($all['status'] == 'To Ship') {
        $status = 'At Your Shop';
    } else if ($all['status'] == 'At Your Shop') {
        $status = 'Completed';
    } else {
        $status = 'Buy Again';

        // Query cart
        $sql_cart = "SELECT * FROM `cart` WHERE `sm_id` = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param('i', $all['sm_id']);
        $stmt_cart->execute();
        $res_cart = $stmt_cart->get_result();
        $cart = $res_cart->fetch_array(MYSQLI_ASSOC);

        // Check if product exists in cart
        if ($cart) {
            // Update cart with new quantity and total
            $new_quantity = $cart['quantity'] + $all['quantity'];
            $query_insert_sale = "UPDATE `cart` SET `sell_price` = ?, `quantity` = ?, `total` = ?, `user_id` = ?, `date_created_at` = ? WHERE `sm_id` = ?";
            $stmt_sale = $conn->prepare($query_insert_sale);
            $stmt_sale->bind_param('diissi', $all['sell_price'], $new_quantity, $all['total'], $all['user_id'], $date_created_at, $all['sm_id']);
            $stmt_sale->execute();
        } else {
            // Insert into cart
            $query_insert_sale = "INSERT INTO `cart` (sm_id, sell_price, quantity, total, user_id, date_created_at) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_sale = $conn->prepare($query_insert_sale);
            $stmt_sale->bind_param('diissi', $all['sm_id'], $all['sell_price'], $all['quantity'], $all['total'], $all['user_id'], $date_created_at);
            $stmt_sale->execute();
        }
    }
    // Update the record into the database
    $query_status = "UPDATE `order`
 SET `status` = '$status',
 `date_created_at` = '$date_created_at'
 WHERE `or_id` = '$or_id'";
    $query_status_run = mysqli_query($conn, $query_status);

    // Insert into order table
    $insertqry = "INSERT INTO `order_history`(`order_code`, `user_id`, `sm_id`, `quantity`, `sell_price`, `total`, `cash`, `change`, `day_arrival`, `time_arrival`, `status`, `date_created_at`) 
VALUES ('" . $all['order_code'] . "', '" . $all['user_id'] . "', '" . $all['sm_id'] . "', '" . $all['quantity'] . "', '" . $all['sell_price'] . "', '" . $all['total'] . "', '" . $all['cash'] . "', '" . $all['change'] . "', '" . $all['day_arrival'] . "', '" . $all['time_arrival'] . "', '$status', '" . $all['date_created_at'] . "')";

    $insertres = mysqli_query($conn, $insertqry);


    if ($all['status'] == 'Cancelled') {
        $value = '$query_insert_sale && $query_status_run && $insertres';
        $title = 'New product add to cart successfully!';
        $message = 'You can now check the your cart.';
        $success = "200";
    } else if ($all['status'] == 'Check Out') {

        if (isset($_SESSION["user_id_admin"])) {
            $value = '$query_status_run && $insertres';
            $title = 'New product cancelled successfully!';
            $message = 'You can now check the your order.';
            $success = "100";
        } else if (isset($_SESSION["user_id_supplier"])) {
            $value = '$query_status_run && $insertres';
            $title = 'New product proceed successfully!';
            $message = 'You can now check the your order.';
            $success = "100";
        } else {
        }
    } else if ($all['status'] == 'To Pack') {
        $value = '$query_status_run && $insertres';
        $title = 'New product proceed successfully!';
        $message = 'You can now check the your order.';
        $success = "100";
    } else if ($all['status'] == 'To Ship') {
        $value = '$query_status_run && $insertres';
        $title = 'Drop Off successfully!';
        $message = 'You can now wait for the Shop owner respond.';
        $success = "100";
    } else if ($all['status'] == 'At Your Shop') {
        $value = '$query_status_run && $insertres';
        $title = 'Order completed successfully!';
        $message = 'You can now view completed order.';
        $success = "100";
    } else {
        $value = '$query_insert_sale && $query_status_run && $insertres';
        $title = 'New product add to cart successfully!';
        $message = 'You can now check the your cart.';
        $success = "200";
    }
    if ($value) {
        $response['success'] = $success;
        $response['title'] = $title;
        $response['message'] = $message;
    } else {
        $response['success'] = "500";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Error updating records for material name: ";
    }




    echo json_encode($response);
}
