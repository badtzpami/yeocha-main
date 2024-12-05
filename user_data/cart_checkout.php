    <?php
    include '../config/connect.php';
    error_reporting(0);

    session_start();

    // User's session

    $id = $_SESSION["user_id_admin"];
    $user_role = 'Admin';

    $sessionId = $id;

    $valid_user = "SELECT * FROM `users` WHERE `user_id` = '" . $sessionId . "' && `role` != '" . $user_role . "'";
    $check_user = mysqli_query($conn, $valid_user);

    if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
        header("Location: ../index.php");
        session_destroy();
    } else
        $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = $sessionId"));

    ?>


    <?php include "../include/user_meta.php"; ?>

    <style>
        .button-container {
            /* margin-bottom: 20px; */
        }

        .btn {
            /* padding: 0 2px; */
            /* margin-right: 35px; */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add_user {
            color: #fff !important;
        }

        button.add {
            background-color: #9edbcc !important;
            color: #fff !important;
        }

        button.print {
            background-color: #f8efbb !important;
            color: #000 !important;
        }

        .btn.print:hover {
            background-color: #536481;
            color: #fff;
        }

        .btn:not(.active-button):hover {
            background-color: #536481;
            color: #fff;
        }

        .btn.active-button:hover {
            background-color: #536481;
            color: #fff;
        }

        .btn.active-button {
            background-color: #6c8cc4;
            color: white;
        }

        .btn:not(.active-button) {
            background-color: #fff;
            color: #007bff;
            border: 2px solid rgba(85, 107, 47, 0.7);
        }

        .add_account {
            position: absolute;
            display: flex;
            justify-content: right;
            align-items: center;
            text-align: center;
            top: 20px;
            right: 30px;
            color: #fff !important;
            width: 50px;
            font-size: 18px !important;
            background: #81ac93 !important;
        }


        .message-box {
            position: fixed;
            /* Fixes it relative to the viewport */
            top: 20px;
            /* Distance from the top */
            right: 20px;
            /* Distance from the right */
            z-index: 1000;
            /* Ensures it is in front of other elements */
            background-color: white;
            /* Background color */
            border: 1px solid #ccc;
            /* Border styling */
            border-radius: 5px;
            /* Rounded corners */
            padding: 15px;
            /* Inner spacing */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        .close-btn {
            display: flex;
            align-items: right;
            border: 0;
            top: 0;
            right: 1px;
            margin: 10px;
        }




        /* ///////////////////////////////////// */


        /* .upload {
            width: 125px;
            height: 125px;
            position: relative;
            margin: auto;
        }

        .form .upload img { */
        /* border-radius: 50% !important; */
        /* border: 3px solid #DCDCDC; */
        /* height: 90px;
            width: 90px;
        }

        .form .upload .round1 {
            position: absolute;
            bottom: 10px;
            right: 65px;
            background: transparent !important;
            width: 42px;
            height: 42px;
            line-height: 43px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
        }

        .form .upload .round {
            position: absolute;
            bottom: 0;
            right: 0; */
        /* background: #4a6cf7; */
        /* width: 160px;
            height: 160px;
            line-height: 43px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
            left: 2px;
        }

        .form .upload .round input[type="file"] {
            position: absolute;
            transform: scale(2);
            opacity: 0;
            height: 68px;
            width: 78px;
            height: 76px;
            line-height: 43px;
            text-align: center;
            border-radius: 50%;
            overflow: hidden;
            left: 42px;
            top: 42px;
            z-index: 1000;
        }


        .form input[type=file]::-webkit-file-upload-button {
            cursor: pointer;
        } */

        .container-materials {
            display: flex;
            flex-direction: column;
        }

        .row-materials {
            margin: 20px;
        }

        .product-table {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .material-cards {
            display: flex;
            flex-wrap: wrap;
            /* Allows wrapping to the next line */
            justify-content: space-between;
            /* Distributes space between cards */
            justify-content: left;
        }

        .card-row {
            flex: 0 0 18%;
            /* Each card takes about 18% of the width */
            /* margin-bottom: 20px; */
            /* Spacing between rows */
            box-sizing: border-box;
            /* Ensures padding and border are included in width/height */
            text-align: center;
            /* Center the text in the card */

            margin: 10px;

            background: white;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);

            padding: 10px;
        }

        @media (max-width: 1024px) {
            .card-row {
                flex: 0 0 22%;
                /* 4 cards per row on medium screens */
            }
        }

        @media (max-width: 768px) {
            .card-row {
                flex: 0 0 30%;
                /* 3 cards per row on smaller screens */
            }
        }

        @media (max-width: 480px) {
            .card-row {
                flex: 0 0 45%;
                /* 2 cards per row on very small screens */
            }
        }


        .card-row img {
            max-width: 145px;
            height: 145px;
        }

        .material-name {
            margin-top: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .card-row.active {
            border: 2px solid #007bff;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.5);
        }

        .remove-btn,
        .remove-btn-inventory {
            background-color: #ff4c4c;
            /* Red background */
            color: white;
            /* White text */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            padding: 5px 10px;
            /* Padding for better appearance */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background-color 0.3s;
            /* Smooth background color transition */
        }

        .remove-btn:hover,
        .remove-btn-inventory:hover {
            background-color: #e63939;
            /* Darker red on hover */
        }


        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Aligns buttons to the right */
            margin: 50px;
            /* Space around buttons */
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            /* Aligns buttons to the right */
        }

        .reset-button {
            display: flex;
            justify-content: flex-end;
            /* Aligns items to the right */
            /* margin-bottom: 10px; */
            /* Optional spacing between buttons */
        }

        .physical_inventory_button {
            margin-left: 10px;
            /* Optional spacing between the two buttons */
        }

        .physical_inventory_button,
        .reset-button button {
            width: 200px;
            /* Set width for buttons */
            height: 50px;
            /* Set height for buttons */
            background-color: #fff;
            /* Button background color */
            border: 1px solid #ccc;
            /* Button border */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background-color 0.3s;
            /* Smooth background color change */
        }

        /* .reset-button {
            position: absolute;
            margin-right: 65px;
            margin-bottom: 25px;
            top: 0;
        } */

        .physical_inventory_button:hover,
        .reset-button button:hover {
            background-color: #f0f0f0;
            /* Change background on hover */
        }


        /* ///////////// */

        .container-inventory {
            display: flex;
            flex-wrap: wrap;
            /* Allows wrapping to the next line */
            justify-content: space-between;
            /* Distributes space between cards */
            justify-content: left;
        }

        .row-inventory {
            margin-bottom: 20px;
        }


        .inventory-cards {
            display: flex;
            flex-wrap: wrap;
            /* Allows wrapping to the next line */
            justify-content: space-between;
            /* Distributes space between cards */
            justify-content: left;
        }

        .card-row {
            flex: 0 0 18%;
            /* Each card takes about 18% of the width */
            /* margin-bottom: 20px; */
            /* Spacing between rows */
            box-sizing: border-box;
            /* Ensures padding and border are included in width/height */
            text-align: center;
            /* Center the text in the card */

            margin: 10px;

            background: white;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);

            padding: 10px;
        }

        .card-row img {
            max-width: 100%;
            height: 150px;
        }

        .inventory-name {
            margin-top: 10px;
            font-weight: bold;
        }

        .card-row.active {
            border: 2px solid #007bff;
            box-shadow: 0 4px 20px rgba(0, 123, 255, 0.5);
        }




        /* Select All Checkbox Section */
        .select_all2,
        .all_added_price {
            display: flex;
            align-items: top;
            font-size: 16px;
            margin: 10px 30px;
        }

        .select_all2 input[type="checkbox"] {
            margin: 10px;
            width: 20px;
            display: flex;
            align-items: top;
            height: 20px;
            /* Spacing between checkbox and label */
            cursor: pointer;
            /* Change cursor to pointer on hover */
        }

        .select_two {
            display: flex;
            margin-top: 30px;
            align-items: center;
        }

        /* Price Section */
        .all_added_price p {
            font-size: 18px;
            font-weight: 600;
            color: #444;
            display: flex;
            align-items: center;
        }

        .all_added_price input[type="text"] {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            width: 120px;
            text-align: right;
        }

        /* Delete All Button */
        .delete_all a.link_delete {
            display: inline-block;
            width: 100px;
            padding: 12px 20px;
            margin: 0 25px;
            font-size: 16px;
            color: #fff;
            background-color: #e74c3c;
            /* Red background */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        a.link_delete {
            display: inline-block;
            width: 100px !important;
            height: 40px !important;
            padding: 12px 20px !important;
            margin: 0 25px;
            font-size: 12px !important;
            color: #fff !important;
            background-color: #e74c3c !important;
            /* Red background */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .delete_all a.link_delete:hover {
            background-color: #c0392b;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            /* Lift effect on hover */
        }

        .delete_all a.link_delete:active {
            background-color: #d94a39;
            /* Darker red when clicked */
            transform: translateY(2px);
            /* Pressed effect */
        }

        /* Reset Button */
        .reset-button button {
            padding: 10px 30px;
            font-size: 16px;
            color: #fff;
            background-color: #3498db;
            /* Blue background */
            border: none;
            border-radius: 5px;
            width: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .reset-button button:hover {
            background-color: #2980b9;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            /* Lift effect on hover */
        }

        .reset-button button:active {
            background-color: #1f6f98;
            transform: translateY(2px);
            /* Pressed effect */
        }

        /* Submit Button */
        .physical_inventory_button {
            padding: 12px 40px;
            font-size: 18px;
            color: #fff;
            background-color: #2ecc71;
            /* Green background */
            border: none;
            border-radius: 5px;
            width: 200px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .physical_inventory_button:hover {
            background-color: #27ae60;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            /* Lift effect on hover */
        }

        .physical_inventory_button:active {
            background-color: #1e854c;
            transform: translateY(2px);
            /* Pressed effect */
        }

        /* Responsive Styling */
        @media (max-width: 768px) {

            .select_all2,
            .all_added_price p,
            .delete_all,
            .reset-button,
            .physical_inventory_button {
                width: 100%;
                /* Make buttons and inputs full width on smaller screens */
            }

            .all_added_price input[type="text"] {
                width: auto;
                /* Adjust input field width */
            }

            .delete_all a.link_delete,
            .reset-button button,
            .physical_inventory_button {
                margin-bottom: 10px;
                /* Add spacing between buttons */
            }
        }

        /* Container for all input fields to ensure they are aligned and have consistent width */
        .input-container {
            width: 100%;
            /* Or specify any fixed width, e.g., 500px */
            max-width: 600px;
            /* Set a maximum width for large screens */
            margin: 2px auto;
            /* Centers the container */
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            /* Space between each input field */
        }

        /* Apply consistent styles to all input fields */
        .input-default {
            font-size: 1rem;
            font-weight: normal;
            padding: 10px;
            width: 100%;
            /* Full width of the container */
            border: none;
            outline: none;
            border-bottom: 2px solid #000;
            text-align: center;
            box-sizing: border-box;
            /* Ensures padding is included in the width */
        }

        /* Focus effect on the input fields */
        .input-default:focus {
            border-bottom: 2px solid #007BFF;
            /* Blue color for focus */
            outline: none;
        }

        /* Make the h6 tags more consistent */
        h6 {
            font-size: 1.1rem;
            font-weight: normal;
            margin-bottom: 5px;
        }

        /* Optional: Add a max width for the h6 text */
        h6 {
            max-width: 100%;
        }

        .receipt-info {
            text-align: right;
            /* Aligns the text to the right */
            font-size: 1rem;
            /* Set a default font size */
            font-weight: normal;
            /* Adjust font weight */
            color: #333;
            /* Dark gray color for text */
            margin-top: 20px;
            /* Adds some space on top of the container */
            padding-right: 20px;
            /* Padding to the right for spacing */
        }

        /* Optional: Make the "Today" text bold or stand out */
        .receipt-info span {
            font-weight: bold;
            color: #007BFF;
            /* Set color for "Today" text to blue */
        }
    </style>
    <?php include "../include/user_top.php"; ?>
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <link href="../assets/css/checkout.css" rel="stylesheet">
    <?php include "../include/user_header.php"; ?>

    <?php include "../include/sidebar_admin.php"; ?>


    <!-- Message Box -->
    <div class="message-box" id="messageBox" style="display: none; z-index: 2000;">
        <div class="close-btn" id="closeBtn">
            <button type="button" class="close mr-1" style="border:0; background: none;  font-size: 24px;" aria-label="Close">
                <span aria-hidden="true" style="border:0; font-size: 24px;">&times;</span>
            </button>
        </div>
        <i id="logo_msg"></i>
        <p id="new_msg"></p>
        <div class="loading-bar-container">
            <div class="loading-bar" id="loadingBar"></div>
        </div>
    </div>

    <main id="main" class="main">

        <div class="page-header">
            <div class="page-header flex-wrap mt-3">
                <div class="row">
                    <div class="col-9">
                        <div class="d-flex">
                            <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Add To Cart</h4>
                        </div>
                    </div>
                    <div class="col-3">

                        <div class="d-flex">
                            <nav>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../admin/user_sale.php">Home</a></li>
                                    <li class="breadcrumb-item">My Cart</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div><!-- End header -->

        <section class="section">
            <div class="page-header flex-wrap">
                <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
                </h3>

                <div class="d-flex">

                    <a href="../admin/user_order.php">
                        <button type="button" class="btn">
                            <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                        </button>
                    </a>

                    <button type="button" id="PhysicalInventoryButton" class="btn active-button">
                        <i class="bi bi-refresh btn-icon-prepend"></i>All Item
                    </button>

                    <button type="button" class="btn print" onclick="printUserTable()">
                        <i class="mdi mdi-print btn-icon-prepend"></i>Print
                    </button>

                    <!-- Hidden iframe that loads user_print.php -->
                    <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->

                    <button type="button" id="addPhysicalInventoryButton" class="btn add">
                        Add Orders
                    </button>

                </div>
            </div>
        </section>



        <section class="section">
            <div class="row">
                <col-lg-12>


                    <div class="card stretch-card" id="allPhysicalInventoryRawContent">
                        <div class="card-body">


                            <form id="addOrder">

                                <div style="width: 100%; background: #eee; ">
                                    <?php
                                    $sql_cd = "SELECT * FROM `order`";
                                    $res_cd = mysqli_query($conn, $sql_cd);
                                    $randString = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 8);

                                    if (mysqli_num_rows($res_cd) > 0) {
                                        while ($ftch = mysqli_fetch_array($res_cd)) {
                                            $randString;
                                            if ($ftch['order_code'] != $randString || $ftch['order_code'] != '') {
                                                $newcode = $randString;
                                            } else {
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="checkout bg-white" style="width: 100%; height: auto; ">
                                        <h1 class="heading">
                                            <ion-icon></ion-icon> ORDER CODE: </br><input type="text" name="mycode" style="color:#2ecc71; border: none; outline:none; width: 200px;" value="<?php echo $randString;; ?>" readonly>
                                        </h1>

                                        <div class="item-flex">

                                            <section class="checkout">

                                                <h2 class="section-heading">Payment Details</h2>

                                                <div class="payment-form">

                                                    <div class="payment-method">

                                                        <button class="method selected">
                                                            <ion-icon></ion-icon>

                                                            <span>Cash</span>
                                                            <ion-icon class="checkmark fill"></ion-icon>
                                                        </button>

                                                    </div>
                                                    <?php
                                                    $id = $_SESSION['user_id_admin'];

                                                    $user = "SELECT * FROM `users` WHERE user_id = $id";
                                                    $res_user = mysqli_query($conn, $user);
                                                    $user = mysqli_fetch_array($res_user);

                                                    $u_id = $user['user_id'];
                                                    $firstname = $user['firstname'];
                                                    $lastname = $user['lastname'];
                                                    $email = $user['email'];
                                                    $phone = $user['phone'];


                                                    ?>

                                                    <div class="cardholder-name">
                                                        <label for="cardholder-name" class="label-default">Customer Name</label>
                                                        <input type="text" value="<?php echo $user['firstname'] . " " . $user['lastname']; ?>" id="cardholder-name" class="input-default" readonly>
                                                    </div>

                                                    <div class="cardholder-name">
                                                        <label for="cardholder-name" class="label-default">Address Location</label>
                                                        <input type="text" value="<?php echo $user['address']; ?>" id="cardholder-name" class="input-default" readonly>
                                                    </div>
                                                    <h2 class="section-heading">Contact Details</h2>

                                                    <div class="cardholder-name">
                                                        <label for="cardholder-name" class="label-default">Email</label>
                                                        <input type="text" value="<?php echo $user['email']; ?>" id="cardholder-name" class="input-default" readonly>
                                                    </div>
                                                    <div class="cardholder-name">
                                                        <label for="cardholder-name" class="label-default">Contact Number</label>
                                                        <div class="col-sm-3"></div>

                                                        <input type="text" value="<?php echo $user['phone']; ?>" id="cardholder-name" class="input-default" readonly>
                                                    </div>


                                                </div>

                                                <button id="mybutton" class="btn btn-primary">
                                                    <b>Place Order</b></span>
                                                </button>



                                            </section>

                                            <section class="cart">

                                                <div class="cart-item-box">

                                                    <h2 class="section-heading">Order Summary</h2>
                                                    <!-- // Get user details (for the store) -->

                                                    <?php
                                                    $total_sum = 0;  // Initialize the total sum

                                                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                                        foreach ($_POST as $key => $value) {
                                                            if (strpos($key, 'checkbox') === 0) {
                                                                $checkbox_id = substr($key, 8);  // Get the checkbox ID (e.g., '1' from 'checkbox1')

                                                                // Get product details from POST data
                                                                $prodid = $_POST['prodid' . $checkbox_id][0];   // Product ID
                                                                $sm_id = $_POST["prodid"];
                                                                $prodname = $_POST['prodname' . $checkbox_id][0];  // Product Name
                                                                $prod_price = $_POST['prod_price' . $checkbox_id][0]; // Product Price
                                                                $prod_qty = $_POST['prod_qty' . $checkbox_id][0]; // Product Quantity
                                                                $stock = $_POST['stock' . $checkbox_id][0]; // Product Quantity
                                                                $prod_sum = $prod_qty * $prod_price;  // Calculate product total price

                                                                $total_sum += $prod_sum;  // Add product sum to total sum

                                                                // Product Image (default or specific image)
                                                                $prod_image = isset($materials['image']) && !empty($materials['image']) ? $materials['image'] : 'default_image.jpg'; ?>

                                                                <?php
                                                                // Display product information
                                                                echo '<div class="product-card">';
                                                                echo '    <div class="card">';
                                                                echo '        <div class="img-box" style="padding: 10px;">';
                                                                echo '            <div class="row">';
                                                                echo '                <div class="col-sm-4">';
                                                                if (isset($materials['ct_id']['image']) && !empty($materials['ct_id']['image'])) {
                                                                    echo '                    <img src="../assets/images/material_images/' . $materials['ct_id']['image'] . '" class="m-2" width="200" height="200" title="' . $materials['ct_id']['image'] . '" style="border-radius: 50% !important; border: 3px solid #DCDCDC; height: 90px; width: 90px;">';
                                                                } else {
                                                                    echo '                    <img src="../assets/images/default_images/tea_house.jpeg" class="m-2" width="200" height="200" title="default_image" style="border-radius: 50% !important; border: 3px solid #DCDCDC; height: 90px; width: 90px;">';
                                                                }
                                                                echo '                </div>';
                                                                echo '                <div class="col-sm-8">';
                                                                echo '                    ' . $prodname . "<br> X " . $prod_qty . " P" . $prod_price;
                                                                echo '                </div>';
                                                                echo '            </div>';
                                                                echo '            <div class="row" style="text-align: right;">';
                                                                echo '                <div class="col-sm-8"></div>';
                                                                echo '                <div class="col-sm-4 mb-2"><b class="m-3">P ' . $prod_sum . '</b></div>';
                                                                echo '            </div>';
                                                                echo '        </div>';
                                                                echo '    </div>';
                                                                echo '</div>';
                                                                $alltotal = $alltotal + ($prod_qty * $prod_price);



                                                                // Simple query using mysqli_real_escape_string to sanitize input (for non-integer values)
                                                                $sql_order = "SELECT * FROM `supplier_material` WHERE sm_id = $prodid";

                                                                // Execute the query
                                                                $res_order = mysqli_query($conn, $sql_order);

                                                                $order = mysqli_fetch_array($res_order);

                                                                $currentDate = new DateTime();

                                                                // Add 4 days to the current date
                                                                $currentDate->modify('+4 days');
                                                                
                                                                // Format the date as "d M" (day and month)
                                                                $formattedDate = $currentDate->format('d M');
                                                                

                                                                date_default_timezone_set('Asia/Manila');
                                                                $hour = date("h");
                                                                $minute = date("i");
                                                                if ($minute == '00' || $minute == 0) {
                                                                    $new_minute = '00';
                                                                    $new_hour = $hour + 1;
                                                                } else {
                                                                    $minute1 = 60 - $minute;
                                                                    $new_minute = 60 - $minute1;
                                                                    $new_hour = $hour + 1;
                                                                }
                                                                ?>


                                                                <input type="hidden" name="material_name[]" value="<?php echo $order['material_name']; ?>">

                                                                <input type="hidden" name="order_code[]" value="<?php echo $randString; ?>">
                                                                <input type="hidden" name="user_id[]" value="<?php echo $order['user_id']; ?>">

                                                                <input type="hidden" name="sm_id[]" value="<?php echo $order['sm_id']; ?>">
                                                                <input type="hidden" name="quantity[]" value="<?php echo $prod_qty; ?>">
                                                                <input type="hidden" name="sell_price[]" value="<?php echo $prod_price; ?>">

                                                                <input type="hidden" name="total[]" value="<?php echo $total_sum; ?>">
                                                                <input type="hidden" name="cash[]" id="first_cash">
                                                                <input type="hidden" name="change[]" id="first_change">
                                                                <input type="hidden" name="alltotal[]" value="<?php echo $alltotal; ?>">

                                                                <input type="hidden" name="time_arrival[]" value="<?php echo '8:00 AM - 8:00 PM'; ?>">
                                                                <input type="hidden" name="day_arrival[]" value="<?php echo $formattedDate; ?>">
                                                                <input type="hidden" name="status[]" value="Check Out">


                                                            <?php      } ?>



                                                    <?php   }
                                                    }
                                                    ?>


                                                </div>


                                                <div class="input-container">
                                                    <h6>
                                                        Order Total:
                                                        <input type="text" id="order_total" value="<?php echo $total_sum; ?>" class="input-default" readonly>
                                                    </h6>

                                                    <h6>
                                                        Cash:
                                                        <input type="text" onkeyup="updateValues()" id="cash" oninput="validateCashAndChange()" placeholder="Enter Cash Amount" class="input-default">
                                                    </h6>

                                                    <h6>
                                                        Change:
                                                        <input type="text" id="change" class="input-default" placeholder="< Read Only >" readonly>
                                                    </h6>
                                                </div>




                                                <script type="text/javascript">
                                                    // Function to calculate the change when the user types in the cash amount
                                                    function cash1(cashAmount) {
                                                        var totalAmount = parseFloat(document.getElementById('order_total').value);
                                                        var cashEntered = parseFloat(cashAmount);
                                                        var changeAmount = 0;

                                                        // If the cash entered is more than the total amount
                                                        if (!isNaN(cashEntered) && !isNaN(totalAmount)) {
                                                            changeAmount = cashEntered - totalAmount;
                                                        } else {
                                                            changeAmount = 0; // Default change to 0 if invalid input
                                                        }

                                                        // Display the change
                                                        document.getElementById('change').value = changeAmount.toFixed(2); // Show two decimals
                                                    }
                                                </script>

                                                <div class="receipt-info">
                                                    <?php
                                                  
                                                    // Output the result
                                                    echo "Receive by " . $hour . ":" . $minute . " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                                    echo "Today: " . $formattedDate;
                                                    ?>
                                                </div>


                                            </section>

                                        </div>

                                    </div>
                                </div>


                            </form>

                        </div>


                    </div>


                </col-lg-12>
            </div>
        </section>




        <section class="section">
            <div class="row">
                <col-lg-12>

                    <div class="card stretch-card" id="addPhysicalInventoryContent" style="display: none;">
                        <div class="card-body">

                            <div class="table-responsive">
                                <!-- add user -->

                                <h5 class="card-title">Add Material</h5>
                                <form id="addItemProduct" method="post">

                                    <table class="table table-hover" id="table_add">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Material Name</th>
                                                <th>Quantity</th>
                                                <th>Selling Price</th>
                                                <th>Total</th>
                                                <th>Store</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody id="selected-products">


                                        </tbody>

                                    </table>
                                    <div class="button-container">

                                        <div class="reset-button">
                                            <button id="reset-button">Reset Selection</button>
                                        </div>
                                        <button type="submit" id="save-btn" class="physical_inventory_button">
                                            Submit
                                        </button>
                                    </div>

                                </form>


                            </div>

                        </div>
                    </div>

                </col-lg-12>
            </div>
        </section>




        <section class="section">
            <div class="row">
                <col-lg-12>



                    <div class="card stretch-card" id="selectPhysicalInventoryContent" style="display: none;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center m-5">
                                <div class="category-buttons">

                                    <button class="btn btn-sm btn-info category-filter" data-category="all">All</button>


                                    <?php
                                    $supplier_list_query = "SELECT * FROM `users` WHERE `role` = 'Supplier' ORDER BY `user_id` DESC";
                                    $supplier_list_result = mysqli_query($conn, $supplier_list_query);

                                    if (mysqli_num_rows($supplier_list_result) > 0) {
                                        while ($supplier = mysqli_fetch_array($supplier_list_result)) { ?>
                                            <button class="btn btn-sm btn-info category-filter" data-category="<?= str_replace(' ', '', strtolower($supplier['store'])) ?>"><?= ucfirst($supplier['store']) ?></button>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="search-box">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search Product">
                                </div>
                            </div>
                            <div class="table-responsive">

                                <div class="row-materials">
                                    <div class="material-cards">

                                        <?php
                                        $first_material_list_query = "SELECT sm.sm_id, sm.material_name, sm.type, sm.stock,  sm.enter_stock, sm.selling_price,  sm.unit, sm.image, us.user_id, us.store FROM `supplier_material` sm LEFT JOIN `users` us  ON sm.user_id = us.user_id WHERE us.store != '' ORDER BY us.user_id DESC LIMIT 1 ";
                                        $first_material_list_result = mysqli_query($conn, $first_material_list_query);
                                        $first_material = mysqli_fetch_array($first_material_list_result);
                                        ?>



                                        <div class="card-row card-items <?= str_replace(' ', '', strtolower($first_material['store'])) ?>" data-name="<?php echo $first_material['material_name']; ?>" data-selling-price="<?php echo $first_material['selling_price']; ?>" data-store="<?php echo $first_material['store']; ?>">
                                            <?php if (is_array($first_material)) { ?>
                                                <?php if (empty($first_material['image'])) { ?>
                                                    <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $first_material['material_name']; ?>" id="Material<?php echo $first_material['sm_id']; ?>">
                                                <?php } else { ?>
                                                    <img src="../assets/images/material_images/<?php echo $first_material['image']; ?>" alt="Material<?php echo $first_material['sm_id']; ?>" id="Material<?php echo $first_material['sm_id']; ?>">
                                            <?php }
                                            } else {
                                            } ?>
                                            <div class="material-name"><?php echo $first_material['material_name']; ?></div>
                                            <input type="text" readonly id="selling-price" class="form-control" value="<?php echo $first_material['selling_price']; ?>" style="text-align: center;">
                                            <input type="hidden" readonly id="store" class="form-control" value="<?php echo $first_material['store']; ?>" style="text-align: center;">
                                            <div class="material-name"><?php echo $first_material['store'] ? $first_material['store'] : '0'; ?></div>
                                        </div>
                                        <?php
                                        $material_list_query = "SELECT sm.sm_id, sm.material_name, sm.type, sm.stock,  sm.enter_stock,  sm.selling_price,  sm.unit, sm.image, us.user_id, us.store FROM `supplier_material` sm LEFT JOIN `users` us  ON sm.user_id = us.user_id WHERE  sm.sm_id != ' " . $first_material['sm_id'] . " ' AND us.store != ''  ORDER BY us.user_id DESC";
                                        $material_list_result = mysqli_query($conn, $material_list_query);

                                        if (mysqli_num_rows($material_list_result) > 0) {
                                            while ($material = mysqli_fetch_array($material_list_result)) {  ?>

                                                <div class="card-row card-items <?= str_replace(' ', '', strtolower($material['store'])) ?>" data-name="<?php echo $material['material_name']; ?>" data-selling-price="<?php echo $material['selling_price']; ?>" data-store="<?php echo $material['store']; ?>">
                                                    <?php if (is_array($material)) { ?>
                                                        <?php if (empty($material['image'])) { ?>
                                                            <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $first_material['material_name']; ?>" id="Material<?php echo $first_material['sm_id']; ?>">
                                                        <?php } else { ?>
                                                            <img src="../assets/images/material_images/<?php echo $material['image']; ?>" alt="Material<?php echo $first_material['sm_id']; ?>" id="Material<?php echo $first_material['sm_id']; ?>">
                                                    <?php }
                                                    } ?>
                                                    <div class="material-name"><?php echo $material['material_name']; ?></div>
                                                    <input type="text" readonly id="selling-price" class="form-control" value="<?php echo $material['selling_price']; ?>" style="text-align: center;">
                                                    <input type="hidden" readonly id="store" class="form-control" value="<?php echo $material['store']; ?>" style="text-align: center;">
                                                    <div class="material-name"><?php echo $material['store'] ? $material['store'] : '0'; ?></div>
                                                </div>
                                        <?php
                                            }
                                        } else {
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </col-lg-12>
            </div>
        </section>


    </main><!-- End #main -->


    <?php include "../include/user_footer.php"; ?>

    <?php include "../include/user_bottom.php"; ?>


    <script>
        function validateCashAndChange() {
            // Get the value entered in the #cash, #change, and #alltotal inputs (DOM elements)
            const cashInput = document.getElementById('cash');
            const changeInput = document.getElementById('change');
            const alltotalInput = document.getElementById('order_total');

            // Parse the cash, change, and total values as numbers
            var cash = parseFloat(cashInput.value) || 0;
            var change = parseFloat(changeInput.value) || 0;
            var total = parseFloat(alltotalInput.value) || 0;

            // Apply red border if inputs are empty or invalid
            // Check if both cash and change inputs are empty or if cash is less than total
            if ((cash === 0 || isNaN(cash)) && (change === 0 || isNaN(change))) {
                // Apply red border to both fields if either is empty
                cashInput.style.border = '2px solid red';
                changeInput.style.border = '2px solid red';

                // Show the error message box
                showMessageBox('Please try again!', 'Input fields are required', 'warning');
            } else if (cash < total) {
                // If cash is less than total, highlight both fields in red
                cashInput.style.border = '2px solid red';
                changeInput.style.border = '2px solid red';

                // Show the error message box
                showMessageBox('Something went wrong!', 'Try Higher Amount Cash', 'warning');
            } else {
                // Reset the border color to default if inputs are valid
                cashInput.style.border = ''; // Reset to default border
                changeInput.style.border = ''; // Reset to default border

                // Optionally, hide the message box when input is valid
                hideMessageBox(); // Assuming you have a function to hide the message box
            }
        }

        // Function to hide the message box (if applicable)
        function hideMessageBox() {
            const messageBox = document.getElementById('messageBox'); // Assuming 'messageBox' is the ID of your message box
            if (messageBox) {
                messageBox.style.display = 'none'; // Hide the message box
            }
        }

        // Automatically validate on page load or when the input changes
        document.addEventListener('DOMContentLoaded', function() {
            validateCashAndChange(); // Validate when the page loads

            // Optional: Add event listeners to validate when input changes
            document.getElementById('cash').addEventListener('input', validateCashAndChange);
            document.getElementById('change').addEventListener('input', validateCashAndChange);
            document.getElementById('order_total').addEventListener('input', validateCashAndChange);
        });





        // Add Modal
        $(document).on('submit', '#addOrder', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("valid_order", true);
            {

                $.ajax({
                    type: "POST",
                    url: "../user_process/order_process.php", //action
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        var res = jQuery.parseJSON(response);
                        console.log(response);
                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/admin/user_cart.php';
                            }, 6000);
                        } else if (res.success == 400) {
                            showMessageBox(res.title, res.message, 'warning');
                        } else if (res.success == 500) {
                            showMessageBox(res.title, res.message, 'warning');
                        } else {
                            showMessageBox(res.title, res.message, 'warning');
                        }
                    },
                    error: function(error) {
                        showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                    }

                })
            }
        });
    </script>

    <script type="text/javascript">
        function updateValues() {
            // Get the value entered in the #cash input
            var cashValue = parseFloat(document.getElementById("cash").value) || 0;

            // Set the value of the first_cash input to the value of the #cash input
            // If you want to update only a specific "first_cash", you can update it as well
            var firstCashInputs = document.getElementsByName("cash[]");
            for (var i = 0; i < firstCashInputs.length; i++) {
                firstCashInputs[i].value = cashValue;
            }

            // Calculate the change (for example, change = cash - order_total)
            var orderTotal = parseFloat(document.getElementById("order_total").value) || 0;
            var change = cashValue - orderTotal;

            // Format the change to 2 decimal places
            var formattedChange = change.toFixed(2);

            // Set the value of the #change input to the calculated change value
            document.getElementById("change").value = formattedChange;

            // Set the value of the first_change input to the calculated change value
            // Iterate over all elements with the name "first_change" and update each one
            var firstChangeInputs = document.getElementsByName("change[]");
            for (var i = 0; i < firstChangeInputs.length; i++) {
                firstChangeInputs[i].value = formattedChange; // Update each first_change input
            }
        }


        // Function to calculate the change when the user types in the cash amount
        function cash1(cashAmount) {
            var totalAmount = parseFloat(document.getElementById('order_total').value);
            var cashEntered = parseFloat(cashAmount);
            var changeAmount = 0;

            // If the cash entered is more than the total amount
            if (!isNaN(cashEntered) && !isNaN(totalAmount)) {
                changeAmount = cashEntered - totalAmount;
            } else {
                changeAmount = 0; // Default change to 0 if invalid input
            }

            // Display the change
            document.getElementById('change').value = changeAmount.toFixed(2); // Show two decimals
        }
    </script>