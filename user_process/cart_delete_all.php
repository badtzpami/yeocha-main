<?php
require '../config/connect.php';

session_start();

$response = array(
    'success' => "500",
    'message' => 'Unknown Error',
    'title' => '',
    'session' => "0"
);

// Get user details (for the store)
$sql_user = "SELECT ca.ct_id, us.user_id, us.role, us.store FROM users us LEFT JOIN cart ca ON us.user_id = ca.user_id WHERE us.role = 'Supplier' GROUP BY us.user_id";
$res_user = mysqli_query($conn, $sql_user);

if (mysqli_num_rows($res_user) > 0) {
    while ($users = mysqli_fetch_array($res_user)) {
        if (!empty($users['ct_id'])) {
            // Query to fetch cart items for this supplier
            $sql_material = "SELECT ca.ct_id, ca.sell_price, ca.quantity, sm.sm_id, sm.material_name, sm.type, sm.stock, sm.selling_price, sm.image, us.user_id, us.role, us.store 
                             FROM cart ca 
                             LEFT JOIN supplier_material sm ON ca.sm_id = sm.sm_id 
                             LEFT JOIN users us ON us.user_id = sm.user_id 
                             WHERE us.user_id = '" . $users["user_id"] . "' ORDER BY us.user_id DESC";
            $res_material = mysqli_query($conn, $sql_material);

            if (mysqli_num_rows($res_material) > 0) {
                while ($materials = mysqli_fetch_array($res_material)) {
                    // Form field names should match the form's checkbox names
                    $checkbox = 'checkbox' . $materials['ct_id']; // example: checkbox1, checkbox2, ...
                    $ct_id = $materials['ct_id']; // Get the ct_id from the material

                    // Check if the checkbox is set in the form
                    if (isset($_POST[$checkbox])) {
                        // Delete the cart item using the ct_id
                        $cart_query = mysqli_query($conn, "DELETE FROM `cart` WHERE `ct_id` = '$ct_id'");

                        if ($cart_query) {
                            $response['success'] = "100";
                            $response['title'] = '';
                            $response['message'] = 'Successfully deleted item!';
                        } else {
                            $response['success'] = "400";
                            $response['title'] = 'SOMETHING WENT WRONG!';
                            $response['message'] = 'Error occurred while deleting the item.';
                        }
                    }
                }
            }
        }
    }

    // Return the response as JSON
    echo json_encode($response);
}
?>
