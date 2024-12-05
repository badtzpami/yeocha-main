<?php

include '../config/connect.php';
session_start();

// Initialize response
$response = [
    'success' => "200", // Default success code
    'title' => '',
    'message' => ''
];



if (isset($_POST['valid_material_supplier'])) {
    $material_names = $_POST['material_name']; // Get the array of material names
    $type_names = $_POST['type_name']; // Get the array of category names
    $stocks = $_POST['stock']; // Get the array of category names
    $selling_prices = $_POST['selling_price']; // Get the array of category names
    $unit_names = $_POST['unit_name']; // Get the array of category names

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });
    $duplicate_materials = array_filter(array_count_values($type_names), function ($count) {
        return $count > 1;
    });
    $duplicate_units = array_filter(array_count_values($unit_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_products) && !empty($duplicate_materials) && !empty($duplicate_units)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Product Found!';
        $response['message'] = "Duplicate products: " . implode(", ", array_keys($duplicate_products));
        echo json_encode($response);
        exit; // Stop further processing
    }
    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $material_name = $conn->real_escape_string($material_names[$i]);
        $type_name = $conn->real_escape_string($type_names[$i]);
        $stock = $conn->real_escape_string($stocks[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);
        $unit_name = $conn->real_escape_string($unit_names[$i]);


        $sql_product_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' AND `type` = '" . $type_name . "' ";
        $res_product_material = mysqli_query($conn, $sql_product_material);
        $material = mysqli_fetch_array($res_product_material);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($material_name) || empty($type_name) || empty($stock) || empty($selling_price)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for Material Name:" . $material_name;
            break; // Stop further processing
        } else if ($type_name == "Choose type of material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Type of Material Option.";
        } else if ($unit_name == "Choose unit of material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Unit of Material Option.";
        } else if (mysqli_num_rows($res_product_material) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The " . $material_name . " is already exist.";
        } else {

            if (!strpos($selling_price, '.') !== false) {
                $selling_price = $selling_price . ".00";
            } else {
                $selling_price;
            }

            if ($stock == 0 && $unit_name == 3) {
                $remarks = 'NO STOCK';
            } else if ($stock <= 30  && $unit_name == 3) {
                $remarks = 'LOW STOCK';
            } else if ($stock > 30  && $unit_name == 3) {
                $remarks = 'AVAILABLE';
            } else {
                $remarks = 'NEW';
            }

            // Insert the record into the database
            $query_material = "INSERT INTO `supplier_material` (`material_name`, `type`, `stock`, `selling_price`,  `unit`,`remarks`, `user_id`, `date_created_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$selling_price', '$unit_name', '$remarks',  ' " . $_SESSION["user_id_supplier"] . " ', '$date_created_at')";

            $query_material_run = mysqli_query($conn, $query_material);

            // Insert the record into the database
            $query_history = "INSERT INTO `supplier_history` (`material_name`, `type`, `stock`, `selling_price`,  `unit`,`remarks`, `user_id`, `date_created_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$selling_price', '$unit_name', '$remarks', ' " . $_SESSION["user_id_supplier"] . " ', '$date_created_at')";

            $query_history_run = mysqli_query($conn, $query_history);

            if ($query_material_run && $query_history_run) {
                $response['success'] = "100";
                $response['title'] = 'New material added successfully!';
                $response['message'] = "You can now check the product table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records..";
            }
        }
    }
    echo json_encode($response);
}







// Update User Material
if (isset($_POST['update_material_supplier'])) {
    $sm_ids = $_POST['sm_id']; // Get the array of material names
    $material_names = $_POST['material_name']; // Get the array of material names
    $type_names = $_POST['type_name']; // Get the array of category names
    $stocks = $_POST['stock']; // Get the array of category names
    $selling_prices = $_POST['selling_price']; // Get the array of category names
    $unit_names = $_POST['unit_name']; // Get the array of category names

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });
    $duplicate_materials = array_filter(array_count_values($type_names), function ($count) {
        return $count > 1;
    });
    $duplicate_units = array_filter(array_count_values($unit_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_products) && !empty($duplicate_materials) && !empty($duplicate_units) && $stocks > 30 || $stocks <= 30) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Product Found!';
        $response['message'] = "Duplicate products: " . implode(", ", array_keys($duplicate_products));
        echo json_encode($response);
        exit; // Stop further processing
    }

    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $sm_id = $conn->real_escape_string($sm_ids[$i]);
        $material_name = $conn->real_escape_string($material_names[$i]);
        $type_name = $conn->real_escape_string($type_names[$i]);
        $stock = $conn->real_escape_string($stocks[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);
        $unit_name = $conn->real_escape_string($unit_names[$i]);

        // $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        // $res_material = mysqli_query($conn, $sql_material);
        // $material = mysqli_fetch_array($res_material);

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        $sql_product_material = "SELECT * FROM `supplier_material` WHERE `sm_id` != '" . $sm_id . "' AND `material_name` = '" . $material_name . "' AND `type` = '" . $type_name . "' AND `stock` > 30  ";
        $res_product_material = mysqli_query($conn, $sql_product_material);

        if (mysqli_num_rows($res_product_material) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The Row: " . $material_name . " product is already exist.";
        } else if (empty($material_name) || empty($type_name) || empty($stock) || empty($selling_price)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for Material Name:" . $material_name;
        } else if ($type_name == "Choose type of material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Type of Material Option.";
        } else if ($unit_name == "Choose unit of material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Unit of Material Option.";
        } else {

            if (!strpos($selling_price, '.') !== false) {
                $selling_price = $selling_price . ".00";
            } else {
                $selling_price;
            }


            if ($stock == 0 && $unit_name == 3) {
                $remarks = 'NO STOCK';
            } else if ($stock <= 30  && $unit_name == 3) {
                $remarks = 'LOW STOCK';
            } else if ($stock > 30  && $unit_name == 3) {
                $remarks = 'AVAILABLE';
            } else {
                $remarks = 'AVAILABLE';
            }

            // Update the record into the database

            $query_material = "UPDATE `supplier_material`
          SET `material_name` = '$material_name',
          `type` = '$type_name',
          `stock` = $stock,
          `selling_price` = $selling_price,
          `unit` = '$unit_name',
          `remarks` = '$remarks',
          `date_updated_at` = '$date_updated_at'
          WHERE `sm_id` = '$sm_id'
          ";

            $query_run_material = mysqli_query($conn, $query_material);

            // Insert the record into the database
            $query_history = "INSERT INTO `supplier_history` (`material_name`, `type`, `stock`, `selling_price`,  `unit`,`remarks`,  `date_created_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$selling_price', '$unit_name', '$remarks', '$date_updated_at')";

            $query_run_history = mysqli_query($conn, $query_history);


            if ($query_run_material && $query_run_history) {
                $response['success'] = "100";
                $response['title'] = 'New material updated successfully!';
                $response['message'] = "You can now check the product table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records..";
            }
        }
    }
    echo json_encode($response);
}


if (isset($_POST['valid_cart'])) {
    // Initialize response
    $response = [];

    // Get POST data
    $product_names = $_POST['product_name']; // Array of product names
    $enter_stocks = $_POST['enter_stock']; // Array of stocks
    $selling_prices = $_POST['selling_price']; // Array of selling prices
    $total_amounts = $_POST['total_amount']; // Array of total amounts
    $stores = $_POST['store']; // Array of stores

    // Initialize an array to hold total stock per store
    $store_stock_totals = [];

    // Sum up the enter stock for each store
    for ($i = 0; $i < count($product_names); $i++) {
        $store = $stores[$i];
        $enter_stock = $conn->real_escape_string($enter_stocks[$i]);

        if (!isset($store_stock_totals[$store])) {
            $store_stock_totals[$store] = 0;
        }
        $store_stock_totals[$store] += $enter_stock;
    }

    // Process each item to update stock based on store totals
    for ($i = 0; $i < count($product_names); $i++) {
        $product_name = $conn->real_escape_string($product_names[$i]);
        $stock = $conn->real_escape_string($enter_stocks[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);
        $total_amount = $conn->real_escape_string($total_amounts[$i]);
        $store = $conn->real_escape_string($stores[$i]);

        // Get total enter stock for the store
        $total_enter_stock = $store_stock_totals[$store];

        // Query product record
        $sql_product = "SELECT * FROM `supplier_material` WHERE `material_name` = ?";
        $stmt = $conn->prepare($sql_product);
        $stmt->bind_param('s', $product_name);
        $stmt->execute();
        $res_product = $stmt->get_result();
        $product = $res_product->fetch_array(MYSQLI_ASSOC);

        if ($product) {
            // Query for material details
            $sql_mat = "SELECT * FROM `supplier_material` WHERE `sm_id` = ? ORDER BY `sm_id` DESC";
            $stmt_mat = $conn->prepare($sql_mat);
            $stmt_mat->bind_param('i', $product['sm_id']);
            $stmt_mat->execute();
            $res_mat = $stmt_mat->get_result();

            // Initialize an array for material new stock values
            $material_new_stocks = [];

            // Calculate new stock for each material
            while ($mat = $res_mat->fetch_array(MYSQLI_ASSOC)) {
                $new_stock = $mat['stock'] - $total_enter_stock;
                $material_new_stocks[$mat['sm_id']] = $new_stock;
            }

            // Check if any stock is zero or negative
            $any_zero_or_negative = false;
            foreach ($material_new_stocks as $sm_id => $new_stock) {
                if ($new_stock < 0) {
                    $any_zero_or_negative = true;
                    break;
                }
            }

            // Current date
            date_default_timezone_set('Asia/Manila');
            $date_created_at = date("Y-m-d H:i:s");

            // Validate fields
            if ($any_zero_or_negative) {
                $response['success'] = "400";
                $response['title'] = 'Unavailable to add product!';
                $response['message'] = "Stock is insufficient for product: <strong>" . $product_name . "</strong>. You may decrease your order.";
            } else if (empty($product_name) || empty($enter_stock)) {
                $response['success'] = "400";
                $response['title'] = 'Please try again!';
                $response['message'] = "Fields are required for: <strong>" . $product_name . "</strong>";
            } else {
                // Query cart
                $sql_cart = "SELECT * FROM `cart` WHERE `sm_id` = ?";
                $stmt_cart = $conn->prepare($sql_cart);
                $stmt_cart->bind_param('i', $product['sm_id']);
                $stmt_cart->execute();
                $res_cart = $stmt_cart->get_result();
                $cart = $res_cart->fetch_array(MYSQLI_ASSOC);

                // Check if product exists in cart
                if ($cart) {
                    // Update cart with new quantity and total
                    $new_quantity = $cart['quantity'] + $stock;
                    $query_update_sale = "UPDATE `cart` SET `sell_price` = ?, `quantity` = ?, `total` = ?, `user_id` = ?, `date_created_at` = ? WHERE `sm_id` = ?";
                    $stmt_sale = $conn->prepare($query_update_sale);
                    $stmt_sale->bind_param('diissi', $selling_price, $new_quantity, $total_amount, $product["user_id"], $date_created_at, $product['sm_id']);
                    $stmt_sale->execute();
                } else {
                    // Insert into cart
                    $query_insert_sale = "INSERT INTO `cart` (sm_id, sell_price, quantity, total, user_id, date_created_at) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt_sale = $conn->prepare($query_insert_sale);
                    $stmt_sale->bind_param('diissi', $product['sm_id'], $selling_price, $stock, $total_amount, $product["user_id"], $date_created_at);
                    $stmt_sale->execute();
                }

                if ($stmt_sale) {
                    $response['success'] = "100";
                    $response['title'] = 'Product added successfully!';
                    $response['message'] = "You can now check the sale table.";
                } else {
                    $response['success'] = "500";
                    $response['title'] = 'Something went wrong!';
                    $response['message'] = "Error inserting records.";
                }
            }
        } else {
            // Product not found
            $response['success'] = "404";
            $response['title'] = 'Product Not Found';
            $response['message'] = "The product could not be found in the database.";
        }
    }

    // Ensure the response is always a valid JSON
    echo json_encode($response);
}



?>


