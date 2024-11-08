<?php

include '../config/connect.php';
session_start();




///////////////////////////////
// /////// CATEGORY //////// //
///////////////////////////////

// Initialize response
$response = [
    'success' => "200", // Default success code
    'title' => '',
    'message' => ''
];

// Add User Category of Products
if (isset($_POST['valid_category'])) {
    $category_names = $_POST['category_name']; // Get the array of category names

    // Check for duplicates
    $duplicate_categories = array_filter(array_count_values($category_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_categories)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Category Found!';
        $response['message'] = "Duplicate categories: " . implode(", ", array_keys($duplicate_categories));
        echo json_encode($response);
        exit; // Stop further processing
    }

    // Process each item
    for ($i = 0; $i < count($category_names); $i++) {
        $category_name = $conn->real_escape_string($category_names[$i]);

        $sql_category = "SELECT `category_name` FROM `category` WHERE `category_name` = '" . $category_name . "' ";
        $res_category = mysqli_query($conn, $sql_category);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($category_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: " . '<strong>' . $i + 1 . '</strong>';
        } else if (mysqli_num_rows($res_category) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The ' . $category_name . ' is already exist.";
        } else {

            // Insert the record into the database
            $query = "INSERT INTO `category` (`category_name`,  `date_created_at`) 
            VALUES ('$category_name',  '$date_created_at')";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'Product category added successfully!';
                $response['message'] = "You can now check the category table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}



// Update User Category of a Product
if (isset($_POST['update_category'])) {
    $ca_ids = $_POST['ca_id']; // Get the array of IDs
    $category_names = $_POST['category_name']; // Get the array of category names


    // Check for duplicates
    $duplicate_categories = array_filter(array_count_values($category_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_categories)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Category Found!';
        $response['message'] = "Duplicate categories: " . implode(", ", array_keys($duplicate_categories));
        echo json_encode($response);
        exit; // Stop further processing
    }



    // Process each item
    for ($i = 0; $i < count($category_names); $i++) {
        $ca_id = $conn->real_escape_string($ca_ids[$i]);
        $category_name = $conn->real_escape_string($category_names[$i]);

        // Example validation: Check if required fields are empty
        if (empty($category_name)) {
            // Set error response and break out of the loop
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are required for Category Name: " . $category_name;
            break; // Stop further processing
        }

        // Update the record into the database
        $query_category = "UPDATE `category`
            SET `category_name` = '$category_name'
            WHERE `ca_id` = '$ca_id'";

        $query_category_run = mysqli_query($conn, $query_category);
        if ($query_category_run) {
            $response['success'] = "100";
            $response['title'] = 'Product category updated successfully!';
            $response['message'] = "You can now check the category table.";
        } else {
            $response['success'] = "500";
            $response['title'] = 'SOMETHING WENT WRONG!';
            $response['message'] = "Error updating records for category ID: " . $ca_id;
            break; // Stop processing on error
        }
    }

    echo json_encode($response);
}




// Delete User Category of a Product
if (isset($_POST['delete_category'])) {

    $ca_id = $_POST['ca_id'];

    $query_result = "DELETE FROM `category` WHERE `ca_id` = " . $ca_id . " ";
    $query_run = mysqli_query($conn, $query_result);

    if ($query_run) {
        $response['success'] = "100";
        $response['title'] = 'New category deleted successfully!';
        $response['message'] = "You can now check the category table..";
    } else {
        $response['success'] = "500";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Error inserting records..";
    }
    echo json_encode($response);
}














////////////////////////////
// ////// PRODUCT//////// //
////////////////////////////


// Add User Products
if (isset($_POST['valid_product'])) {
    $product_names = $_POST['product_name']; // Get the array of category names
    $category_names = $_POST['category_name']; // Get the array of category names
    $selling_prices = $_POST['selling_price']; // Get the array of category names

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($product_names), function ($count) {
        return $count > 1;
    });
    $duplicate_categories = array_filter(array_count_values($category_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_products) && !empty($duplicate_categories)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Product Found!';
        $response['message'] = "Duplicate products: " . implode(", ", array_keys($duplicate_products));
        echo json_encode($response);
        exit; // Stop further processing
    }

    // Process each item
    for ($i = 0; $i < count($product_names); $i++) {
        $product_name = $conn->real_escape_string($product_names[$i]);
        $category_name = $conn->real_escape_string($category_names[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);

        $sql_category = "SELECT * FROM `category` WHERE `ca_id` = '" . $category_name . "'";
        $res_category = mysqli_query($conn, $sql_category);
        $category = mysqli_fetch_array($res_category);

        $sql_product = "SELECT * FROM `product` WHERE `product_name` = '" . $product_name . "' AND `ca_id` = '" . $category['ca_id'] . "' ";
        $res_product = mysqli_query($conn, $sql_product);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($product_name) || empty($category_name) || empty($selling_price)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for Product Name:" . $product_name;
            break; // Stop further processing
        } else if (mysqli_num_rows($res_product) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The " . $product_name . " is already exist.";
        } else if ($category_name == "Choose Category") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Category Option.";
        } else if (!is_numeric($selling_price)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Input must be a non-decimal numeric value.";
        } else {

            if (!strpos($selling_price, '.') !== false) {
                $selling_price = $selling_price . ".00";
            } else {
                $selling_price;
            }

            // Insert the record into the database
            $query = "INSERT INTO `product` (`product_name`, `ca_id`, `selling_price`, `date_created_at`) 
            VALUES ('$product_name', '" . $category['ca_id'] . "', '$selling_price', '$date_created_at')";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'New product added successfully!';
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

// Update User Products
if (isset($_POST['update_product'])) {
    $pr_ids = $_POST['pr_id'];
    $product_names = $_POST['product_name'];
    $ca_ids = $_POST['ca_id'];
    $selling_prices = $_POST['selling_price'];

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($product_names), function ($count) {
        return $count > 1;
    });
    $duplicate_categories = array_filter(array_count_values($ca_ids), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_products) && !empty($duplicate_categories)) {
        $response2['success'] = "400";
        $response2['title'] = 'Duplicate Product Found!';
        $response2['message'] = "Duplicate products: " . implode(", ", array_keys($duplicate_products));
        echo json_encode($response2);
        exit;
    }

    $updateSuccess = true; // Flag for overall success

    // Process each item
    for ($i = 0; $i < count($product_names); $i++) {
        $pr_id = $conn->real_escape_string($pr_ids[$i]);
        $product_name = $conn->real_escape_string($product_names[$i]);
        $ca_id = $conn->real_escape_string($ca_ids[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);

        $sql_product = "SELECT * FROM `product` WHERE `pr_id` != '" . $pr_id . "' AND `product_name` = '" . $product_name . "' AND `ca_id` = '" . $ca_id . "' ";
        $res_product = mysqli_query($conn, $sql_product);

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        // Validate fields
        if (empty($product_name) || empty($ca_id) || empty($selling_price) || $ca_id == "Choose Category" || !is_numeric($selling_price)) {
            $response2['success'] = "400";
            $response2['title'] = 'Please try again!';
            $response2['message'] = "Invalid input for product #: " . ($i + 1);
            $updateSuccess = false; // Set flag to false
            break;
        } else if (mysqli_num_rows($res_product) > 0) {
            $response2['success'] = "400";
            $response2['title'] = 'Please try again!';
            $response2['message'] = "The Row: " . $product_name . " product already exists.";
            $updateSuccess = false; // Set flag to false
            break;
        }

        // Format selling price
        if (!strpos($selling_price, '.') !== false) {
            $selling_price = $selling_price . ".00";
        } else {
            $selling_price;
        }


        // Update the record into the database
        $query = "UPDATE `product` SET `product_name` = '$product_name', `ca_id` = '$ca_id', `selling_price` = '$selling_price', `date_updated_at` = '$date_updated_at' WHERE `pr_id` = '$pr_id'";
        $query_run = mysqli_query($conn, $query);

        if (!$query_run) {
            $response2['success'] = "500";
            $response2['title'] = 'SOMETHING WENT WRONG!';
            $response2['message'] = "Error updating records.";
            $updateSuccess = false; // Set flag to false
            break;
        }
    }

    if ($updateSuccess) {
        $response2['success'] = "100";
        $response2['title'] = 'New product updated successfully!';
        $response2['message'] = "You can now check the product table.";
    }


    // Check if there is an image upload
    if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
        $id = $_POST["id"];
        $name = $_POST["name"];

        $imageName = $_FILES["image"]["name"];
        $imageSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];

        // Image validation
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $validImageExtension)) {
            $response['success'] = "200";
            $response['title'] = 'SOMETHING WENT WRONG!';
            $response['message'] = "Invalid Extensions, Use: JPG, JPEG, PNG.";
            echo json_encode($response);
            exit; // Stop further processing
        } else if ($imageSize > 1200000) {
            $response['success'] = "200";
            $response['title'] = 'SOMETHING WENT WRONG!';
            $response['message'] = "Please Don't Use High Image Size.";
            echo json_encode($response);
            exit; // Stop further processing
        }

        // Process the image update
        $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `product` WHERE `pr_id` = $id"));
        if ($product["image"] != '') {
            unlink('../assets/images/product_images/' . $product["image"]);
        }

        $newImageName = $name . "-" . date("Ymd") . '.' . $imageExtension;
        $query = "UPDATE product SET `image` = '$newImageName' WHERE `pr_id` = $id";
        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/product_images/' . $newImageName);

        $response2['success'] = "100";
        $response2['title'] = 'SUCCESS!';
        $response2['message'] = "Successfully Changed Product Image.";
    }

    echo json_encode($response2);
    exit; // Stop further processing

}



// Delete User Category of a Product
if (isset($_POST['delete_product'])) {

    $pr_id = $_POST['pr_id'];

    $sql_product = "SELECT * FROM `menu` WHERE `pr_id` = '" . $pr_id . "'";
    $res_product = mysqli_query($conn, $sql_product);


    // $query_result2 = "DELETE FROM `menu` WHERE `pr_id` = " . $pr_id . " ";
    // $query_run2 = mysqli_query($conn, $query_result2);


    if (mysqli_num_rows($res_product) > 0) {
        $response['success'] = "400";
        $response['title'] = 'SOMETHING WENT WRONG!!';
        $response['message'] = "This row cannot be deleted. Thee product exist in the menu.";
    } else {

        $query_result = "DELETE FROM `product` WHERE `pr_id` = " . $pr_id . " ";
        $query_run = mysqli_query($conn, $query_result);
        if ($query_run) {
            $response['success'] = "100";
            $response['title'] = 'New product deleted successfully!';
            $response['message'] = "You can now check the product table." . $pr_id;
        } else {
            $response['success'] = "500";
            $response['title'] = 'SOMETHING WENT WRONG!';
            $response['message'] = "Error inserting records..";
        }
    }
    echo json_encode($response);
}






//////////////////////////////
// /////// MATERIAL /////// //
//////////////////////////////


// Add User Material
if (isset($_POST['valid_material'])) {
    $material_names = $_POST['material_name']; // Get the array of material names
    $type_names = $_POST['type_name']; // Get the array of category names
    $stocks = $_POST['stock']; // Get the array of category names
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
        $unit_name = $conn->real_escape_string($unit_names[$i]);


        $sql_product_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' AND `type` = '" . $type_name . "' ";
        $res_product_material = mysqli_query($conn, $sql_product_material);
        $material = mysqli_fetch_array($res_product_material);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($material_name) || empty($type_name) || empty($stock)) {
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


            if ($stock == 0 && $unit_name == 3) {
                $remarks = 'NO STOCK';
            } else if ($stock <= 30  && $unit_name == 3) {
                $remarks = 'LOW STOCK';
            } else if ($stock > 30  && $unit_name == 3) {
                $remarks = 'AVAILABLE';
            } else {
                $remarks = 'AVAILABLE';
            }

            // Insert the record into the database
            $query_material = "INSERT INTO `material` (`material_name`, `type`, `stock`,  `unit`,`remarks`, `date_created_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$unit_name', '$remarks', '$date_created_at')";

            $query_material_run = mysqli_query($conn, $query_material);

            // Insert the record into the database
            $query_history = "INSERT INTO `history` (`material_name`, `type`, `stock`,  `unit`,`remarks`, `date_created_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$unit_name', 'NEW', '$date_created_at')";

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
if (isset($_POST['update_material'])) {
    $ma_ids = $_POST['ma_id']; // Get the array of material names
    $material_names = $_POST['material_name']; // Get the array of material names
    $type_names = $_POST['type_name']; // Get the array of category names
    $stocks = $_POST['stock']; // Get the array of category names
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
        $ma_id = $conn->real_escape_string($ma_ids[$i]);
        $material_name = $conn->real_escape_string($material_names[$i]);
        $type_name = $conn->real_escape_string($type_names[$i]);
        $stock = $conn->real_escape_string($stocks[$i]);
        $unit_name = $conn->real_escape_string($unit_names[$i]);

        // $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        // $res_material = mysqli_query($conn, $sql_material);
        // $material = mysqli_fetch_array($res_material);

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        $sql_product_material = "SELECT * FROM `material` WHERE `ma_id` != '" . $ma_id . "' AND `material_name` = '" . $material_name . "' AND `type` = '" . $type_name . "' ";
        $res_product_material = mysqli_query($conn, $sql_product_material);

        if (mysqli_num_rows($res_product_material) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The Row: " . $material_name . " product is already exist.";
        } else if (empty($material_name) || empty($type_name) || empty($stock)) {
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

            // Update the record into the database

            if ($stock == 0 && $unit_name == 3) {
                $remarks = 'NO STOCK';
            } else if ($stock <= 30  && $unit_name == 3) {
                $remarks = 'LOW STOCK';
            } else if ($stock > 30  && $unit_name == 3) {
                $remarks = 'AVAILABLE';
            } else {
                $remarks = 'AVAILABLE';
            }


            $query_material = "UPDATE `material`
          SET `material_name` = '$material_name',
          `type` = '$type_name',
          `stock` = $stock,
          `unit` = '$unit_name',
          `remarks` = '$remarks',
          `date_updated_at` = '$date_updated_at'
          WHERE `ma_id` = '$ma_id'
          ";

            $query_run_material = mysqli_query($conn, $query_material);

            // Insert the record into the database
            $query_history = "INSERT INTO `history` (`material_name`, `type`, `stock`,  `unit`,`remarks`, `date_updated_at`) 
            VALUES ('$material_name', '$type_name', '$stock', '$unit_name', '$remarks', '$date_updated_at')";

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


if (isset($_FILES["imagematerial"]["name"])) {
    $id = $_POST["idmaterial"];
    $name = $_POST["namematerial"];

    $imageName = $_FILES["imagematerial"]["name"];
    $imageSize = $_FILES["imagematerial"]["size"];
    $tmpName = $_FILES["imagematerial"]["tmp_name"];

    // Image validation
    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $imageName);
    $imageExtension = strtolower(end($imageExtension));

    if (!in_array($imageExtension, $validImageExtension)) {
        $response['success'] = "200";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Invalid Extensions, Use: JPG, JPEG, PNG, SVG";
        return;
    } elseif ($imageSize > 1200000) {
        $response['success'] = "200";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Please Dont Use High Image Size.";
        return;
    } else {


        $material = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `material` WHERE `ma_id` = $id"));
        if ($material["image"] != '') {
            unlink('../assets/images/material_images/' . $material["image"]);
        } else {
        }



        $newImageName = $name . "-" . date("Ymd"); // Generate new image name

        $newImageName = $newImageName . '.' . $imageExtension;
        $query = "UPDATE material  SET `image` = '$newImageName' WHERE `ma_id` = $id ";

        mysqli_query($conn, $query);
        move_uploaded_file($tmpName, '../assets/images/material_images/' . $newImageName);


        $response['success'] = "100";
        $response['title'] = 'SUCCESS!';
        $response['message'] = "Successfully Change Material Image.";
    }
    echo json_encode($response);
}






//////////////////////////
// /////// MENU /////// //
//////////////////////////


// Add User Menu
if (isset($_POST['valid_menu'])) {
    $product_names = $_POST['product_name']; // Get the array of product names
    $material_names = $_POST['material_name']; // Get the array of material names

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($product_names), function ($count) {
        return $count > 1;
    });
    $duplicate_materials = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });

    // Find common duplicates
    $common_duplicates = array_intersect(array_keys($duplicate_products), array_keys($duplicate_materials));

    if (!empty($common_duplicates)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Found!';
        $response['message'] = "Duplicate products/materials: " . implode(", ", $common_duplicates);
        echo json_encode($response);
        exit; // Stop further processing
    }



    // Process each item
    for ($i = 0; $i < count($product_names); $i++) {
        $product_name = $conn->real_escape_string($product_names[$i]);
        $material_name = $conn->real_escape_string($material_names[$i]);


        $sql_menu = "SELECT * FROM `menu` WHERE `pr_id` = '" . $product_name . "' AND `ma_id` = '" . $material_name . "' ";
        $res_menu = mysqli_query($conn, $sql_menu);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");
        $counter = 1; // Initialize counter 


        // Example validation: Check if required fields are empty
        if (empty($product_name) || empty($material_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required.";
            break; // Stop further processing
        } else if ($product_name == "Choose Product") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Product Option.";
        } else if ($material_name == "Choose Material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Material Option.";
        } else if (mysqli_num_rows($res_menu) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The Row: " . $product_name . " product is already exist.";
        } else {

            // Insert the record into the database
            $query = "INSERT INTO `menu` (`pr_id`, `ma_id`,  `date_created_at`) 
            VALUES ('$product_name', '$material_name', '$date_created_at')";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'New product added successfully in the menu!';
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


// Update User Menu
if (isset($_POST['update_menu'])) {
    $me_ids = $_POST['me_id']; // Get the array of product names
    $product_names = $_POST['product_name']; // Get the array of product names
    $material_names = $_POST['material_name']; // Get the array of material names
    $stocks = $_POST['stock']; // Get the array of material stocks

    // Check for duplicates
    $duplicate_products = array_filter(array_count_values($product_names), function ($count) {
        return $count > 1;
    });
    $duplicate_materials = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_products) && !empty($duplicate_materials)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Product Found!';
        $response['message'] = "Duplicate products: " . implode(", ", array_keys($duplicate_products));
        echo json_encode($response);
        exit; // Stop further processing
    }



    // Process each item
    for ($i = 0; $i < count($product_names); $i++) {
        $me_id = $conn->real_escape_string($me_ids[$i]);
        $product_name = $conn->real_escape_string($product_names[$i]);
        $material_name = $conn->real_escape_string($material_names[$i]);
        $stock = $conn->real_escape_string($stocks[$i]);

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($product_name) || empty($material_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for Product Name: " . $i;
            break; // Stop further processing
        } else if ($product_name == "Choose Product") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Product Option.";
        } else if ($material_name == "Choose Material") {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Choose other Material Option.";
        } else {
            // Insert the record into the database
            $menu_query = "UPDATE `menu` 
            SET `pr_id` = '$product_name', 
            `ma_id` = '$material_name',
            `date_updated_at` = '$date_updated_at'
            WHERE `me_id` = '$me_id'";

            $material_query = "UPDATE `material` 
            SET `stock` = '$stock', 
            `date_updated_at` = '$date_updated_at'
            WHERE `ma_id` = '$material_name'";

            $menu_query_run = mysqli_query($conn, $menu_query);
            $material_query_run = mysqli_query($conn, $material_query);

            if ($menu_query_run || $material_query_run) {
                $response['success'] = "100";
                $response['title'] = 'Menu updated successfully!';
                $response['message'] = "You can now check the menu table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records..";
            }
        }
    }
    echo json_encode($response);
}











// Delete User Category of a Product
if (isset($_POST['delete_menu'])) {
    $counter = 1; // Initialize counter 

    $del_id = $_POST['ma_id'];

    $query_result = "DELETE FROM `menu` WHERE `me_id` = $del_id  ";
    $query_run = mysqli_query($conn, $query_result);
    if ($query_run) {
        $response['success'] = "100";
        $response['title'] = 'New product deleted successfully!';
        $response['message'] = "The Row: " . $del_id . " are deleted. You can now check the menu table.";
    } else {
        $response['success'] = "500";
        $response['title'] = 'SOMETHING WENT WRONG!';
        $response['message'] = "Error inserting records..";
    }
    echo json_encode($response);
}









// Add User Category of Products
if (isset($_POST['valid_inventory'])) {
    $material_names = $_POST['material_name']; // Get the array of category names

    // Check for duplicates
    $duplicate_materials = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_materials)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Material Found!';
        $response['message'] = "Duplicate materials: " . implode(", ", array_keys($duplicate_materials));
        echo json_encode($response);
        exit; // Stop further processing
    }

    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $material_name = $conn->real_escape_string($material_names[$i]);

        $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        $res_material = mysqli_query($conn, $sql_material);
        $material = mysqli_fetch_array($res_material);


        $sql_inventory = "SELECT `ma_id` FROM `inventory` WHERE `ma_id` = ' " . $material['ma_id'] . " ' ";
        $res_inventory = mysqli_query($conn, $sql_inventory);
        $inventory = mysqli_fetch_array($res_inventory);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($material_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: " . '<strong>' . $i + 1 . '</strong>';
        } else if (mysqli_num_rows($res_inventory) > 0) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The ' . $material_name . ' is already exist.";
        } else {

            // Insert the record into the database
            $query = "INSERT INTO `inventory` (`ma_id`,  `date_created_at`) 
            VALUES (' " . $material['ma_id'] . " ',  '$date_created_at')";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'Product added successfully!';
                $response['message'] = "You can now check the physical inventory table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}





if (isset($_POST['valid_enter_stock'])) {
    $material_names = $_POST['material_name']; // Get the array of category names
    $enter_stocks = $_POST['enter_stock']; // Get the array of category names

    // Check for duplicates
    $duplicate_materials = array_filter(array_count_values($material_names), function ($count) {
        return $count > 1;
    });
    $duplicate_enter_stocks = array_filter(array_count_values($enter_stocks), function ($count) {
        return $count > 1;
    });

    if (!empty($duplicate_materials) && !empty($duplicate_enter_stocks)) {
        $response['success'] = "400";
        $response['title'] = 'Duplicate Material Found!';
        $response['message'] = "Duplicate materials: " . implode(", ", array_keys($duplicate_materials));
        echo json_encode($response);
        exit; // Stop further processing
    }

    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $material_name = $conn->real_escape_string($material_names[$i]);
        $enter_stock = $conn->real_escape_string($enter_stocks[$i]);

        $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        $res_material = mysqli_query($conn, $sql_material);
        $material = mysqli_fetch_array($res_material);

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($material_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: " . '<strong>' . $i + 1 . '</strong>';
        } else {

            // Insert the record into the database
            $query = "UPDATE `material` SET 
            `enter_stock` = " . $material['enter_stock'] + $enter_stock . ",
            `date_updated_at` = ' " . $date_updated_at . " '
            WHERE `ma_id` = " . $material['ma_id'] . " ";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'Product added successfully!';
                $response['message'] = "You can now check the physical inventory table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}




if (isset($_POST['valid_physical_inventory'])) {
    $ma_ids = $_POST['ma_id']; // Get the array of category names
    $material_names = $_POST['material_name']; // Get the array of category names
    $enter_stocks = $_POST['enter_stock']; // Get the array of category names
    $comments = $_POST['comment']; // Get the array of category names
    $remarks = $_POST['remark']; // Get the array of category names

    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $ma_id = $conn->real_escape_string($ma_ids[$i]);
        $material_name = $conn->real_escape_string($material_names[$i]);
        $enter_stock = $conn->real_escape_string($enter_stocks[$i]);
        $comment = $conn->real_escape_string($comments[$i]);
        $remark = $conn->real_escape_string($remarks[$i]);

        $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        $res_material = mysqli_query($conn, $sql_material);
        $material = mysqli_fetch_array($res_material);

        if ($enter_stock == 'AVAILABLE' || $enter_stock == 'UNAVAILABLE') {
            $remark = $enter_stock;
            $enter_stock = $material['enter_stock'];
            $stock = $material['stock'];
        } else {
            $initial_stock = $enter_stock - $material['enter_stock'];
            $stock = $material['stock'] + $initial_stock;
        }

        date_default_timezone_set('Asia/Manila');
        $date_updated_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($enter_stock) && $material_name = ''  || empty($comment)) {

            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: <strong>" . $material_name . "</strong>";
        } else {

            // Insert the record into the database
            $query_update_inventory = "UPDATE `material` SET 
            `stock` = " .  $stock   . ",
            `enter_stock` = " . $enter_stock . ",
            `remarks` = '" . $remark . "',
            `comment` = '" . $comment . "',
            `date_updated_at` = ' " . $date_updated_at . " '
            WHERE `ma_id` = " . $material['ma_id'] . " ";

            $query_run_inventory = mysqli_query($conn, $query_update_inventory);

            if ($query_run_inventory) {
                $response['success'] = "100";
                $response['title'] = 'Product added successfully!';
                $response['message'] = "You can now check the physical inventory table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}



if (isset($_POST['valid_sale'])) {
    $product_names = $_POST['product_name']; // Get the array of product names
    $enter_stocks = $_POST['enter_stock']; // Get the array of enter stocks
    $selling_prices = $_POST['selling_price']; // Get the array of enter stocks
    $total_amounts = $_POST['total_amount']; // Get the array of enter stocks

    $currentYear = date("Y");
    $randomLetter = chr(rand(65, 90));
    $randomNumber = rand(100, 999);
    $combinedVariable = $currentYear . $randomLetter . $randomNumber;

    // Process each item to calculate total enter stock first
    $total_enter_stock = 0;
    for ($i = 0; $i < count($product_names); $i++) {
        $enter_stock = $conn->real_escape_string($enter_stocks[$i]);
        $total_enter_stock += $enter_stock; // Sum up the enter stock values
    }

    // Process each item again to update stock
    for ($i = 0; $i < count($product_names); $i++) {
        $product_name = $conn->real_escape_string($product_names[$i]);
        $stock = $conn->real_escape_string($enter_stocks[$i]);
        $selling_price = $conn->real_escape_string($selling_prices[$i]);
        $total_amount = $conn->real_escape_string($total_amounts[$i]);

        $sql_product = "SELECT * FROM product WHERE product_name = '" . $product_name . "' ";
        $res_product = mysqli_query($conn, $sql_product);
        $product = mysqli_fetch_array($res_product);

        $sql_mat = "SELECT ma.ma_id, ma.type, ma.stock, ma.enter_stock, ma.unit, me.pr_id, me.me_id, me.date_created_at, me.date_updated_at  
                    FROM material ma 
                    LEFT JOIN menu me ON ma.ma_id = me.ma_id 
                    WHERE pr_id IS NOT NULL AND pr_id = " . $product['pr_id'] . " AND ma.type = 2 
                    ORDER BY ma_id DESC";
        $res_mat = mysqli_query($conn, $sql_mat);

        // Initialize an array to hold new stock values
        $material_new_stocks = [];

        // Fetch material records and calculate new stock
        while ($mat = mysqli_fetch_array($res_mat)) {
            // Calculate new stock for each material using the total enter_stock
            $new_stock = $mat['enter_stock'] - $total_enter_stock;
            $material_new_stocks[$mat['ma_id']] = $new_stock; // Store the new stock value
        }

        // Check if any new stock value is zero or negative
        $any_zero_or_negative = false;
        foreach ($material_new_stocks as $ma_id => $new_stock) {
            if ($new_stock < 0) {
                $any_zero_or_negative = true;
                break; // Exit the loop if we find any zero or negative value
            }
        }

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if ($any_zero_or_negative) {
            $response['success'] = "400";
            $response['title'] = 'Unavailable to add product!';
            $response['message'] = "Stock is insufficient for product: " . '<strong>' . $product_name . '</strong>. You may decrease your order.';
        } else if (empty($product_name) || empty($enter_stock)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: " . '<strong>' . $product_names . '</strong>';
        } else {

            // Insert the record into the database
            $query_update_sale = "INSERT INTO sale (sales_code, pr_id, sell_price, quantity, total,   date_created_at) 
 VALUES ('$combinedVariable', '" . $product['pr_id'] . "', '$selling_price', '$stock', '$total_amount', '$date_created_at')";


            $query_run_sale = mysqli_query($conn, $query_update_sale);

            if ($query_run_sale) {
                $response['success'] = "100";
                $response['title'] = 'Product added successfully!';
                $response['message'] = "You can now check the sale table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}





// Add  item to the supplier
if (isset($_POST['valid_enter_item'])) {
    $material_names = $_POST['material_name']; // Get the array of category names



    // Process each item
    for ($i = 0; $i < count($material_names); $i++) {
        $material_name = $conn->real_escape_string($material_names[$i]);

        $sql_material = "SELECT * FROM `material` WHERE `material_name` = '" . $material_name . "' ";
        $res_material = mysqli_query($conn, $sql_material);
        $material = mysqli_fetch_array($res_material);


        $sql_inventory = " SELECT sup.su_id, sup.user_id, mat.ma_id as ma_id, mat.material_name FROM supplier sup LEFT JOIN 
        material mat ON sup.ma_id = mat.ma_id  WHERE  mat.ma_id = ' " . $material['ma_id'] . " ' AND sup.user_id = " . $_SESSION["user_id_supplier"] . " ";

        $res_inventory = mysqli_query($conn, $sql_inventory);
        $inventory = mysqli_fetch_array($res_inventory);

        date_default_timezone_set('Asia/Manila');
        $date_created_at = date("Y-m-d H:i:s");

        // Example validation: Check if required fields are empty
        if (empty($material_name)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "Fields are Required for #: <strong>" . $i++ . " </strong>";
        } else if (mysqli_num_rows($res_inventory) > 0 || !isset($res_inventory)) {
            $response['success'] = "400";
            $response['title'] = 'Please try again!';
            $response['message'] = "The $material_name is already exist.";
        } else {

            // Insert the record into the database
            $query = "INSERT INTO `supplier` (`ma_id`, `user_id`,  `date_created_at`) 
            VALUES (' " . $material['ma_id'] . " ', ' " . $_SESSION["user_id_supplier"] . " ', '$date_created_at')";

            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $response['success'] = "100";
                $response['title'] = 'Product added successfully!';
                $response['message'] = "You can now check the item table.";
            } else {
                $response['success'] = "500";
                $response['title'] = 'SOMETHING WENT WRONG!';
                $response['message'] = "Error inserting records.";
            }
        }
    }
    echo json_encode($response);
}

