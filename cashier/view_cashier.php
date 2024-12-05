<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session

$id = $_SESSION["user_id_cashier"];
$user_role = 'Cashier';

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
        border-radius: 55px;
        box-shadow: none;
    }

    /* Table Styling */
    .table {
        width: 100% !important;
        margin-bottom: 1rem;
        color: #212529;
        display: block !important;

        border-left: 1px solid #fff !important;
        border-right: 1px solid #fff !important;
        padding: 0 !important;

    }

    #selected-inventory {
        max-height: 450px !important;
    }


    td {
        border: 2px solid #e28635 !important;
        /* Full border around each cell */
        padding: 10px;
        text-align: center;
        background: #fff;
        /* White background */
    }

    /* Stock Column Specific Styling */
    .table tbody td.td_stock {
        width: 500px;
        font-size: 14px;
        font-weight: 800;
        background: none !important;
        color: #000;
        padding: 10px;
        border: none !important;
    }

    /* Input Fields */
    .table td input {
        padding: 0 5px !important;
        margin: 10px 5px !important;
        font-size: 14px !important;
        width: 60px !important;
        border: none !important;
        font-size: 16px;
        display: inline-block;
        text-align: center;
    }

    /* Table Headers and Rows */
    th,
    td {
        border: none !important;
        padding: 8px;
        margin-bottom: 10px;
        /* Add spacing between rows */
        text-align: left;
    }

    table tr {

        margin-bottom: 10px !important;
        margin: 10px !important;
        background-color: #fff !important;
        /* Optional: Add a background for better visibility */
    }



    /* Inventory Name */
    .inventory_name {
        background: #fff !important;
        font-weight: bold;
    }

    /* Style the Stock Cell */
    .td_stock {
        text-align: center;
        vertical-align: middle;
    }

    /* Stock Buttons and Input Container */
    .td_stock div {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 300px;
        margin: 0 auto;
        padding: 5px;
    }

    /* Increment/Decrement Buttons */
    .td_stock .subtract,
    .td_stock .add {
        background-color: #007bff;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    /* Style for the buttons */
    button.subtract,
    button.add {
        width: 40px;
        height: 40px;
        background-color: #f3d9b2;
        border: 1px solid #e28635;
        border-radius: 50%;
        color: #e28635;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button.subtract:hover,
    button.add:hover {
        background-color: #e28635;
        color: #fff;
        transform: scale(1.1);
    }

    button.subtract:active,
    button.add:active {
        transform: scale(0.95);
    }

    /* Style for the input field */
    input.enter_stock_inventory {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        background-color: #fff;
        border: 1px solid #e28635;
        border-radius: 5px;
        width: 100px !important;
        padding: 5px;
        box-sizing: border-box;
    }

    /* Layout: Place buttons and input in a row */
    input.enter_stock_inventory,
    button.subtract,
    button.add {
        display: inline-block;
        vertical-align: middle;
        margin: 0 5px;
    }

    .subtract:hover,
    .add:hover {
        background-color: #0056b3;
    }

    /* Stock Input Field */
    .enter_stock_inventory {
        width: 80px;
        text-align: center;
        border: none;
        font-size: 16px;
        background: none;
        outline: none;
        margin: 0 10px;
        color: #333;
    }

    .td_stock .enter_stock_inventory:focus {
        border-radius: 4px;
        background: #ffffff;
    }

    .selling-price,
    .total_amount {
        background: #ffffff;


    }





    table td {
        background: #fff;
        border: 2px solid #000;
    }

    table td:first-child {
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
    }



    .enter_stock_inventory {
        text-align: center;
        display: inline-block;
        width: 80%;
    }

    button.add,
    button.subtract {
        width: 30px;
        height: 30px;
        margin: 0 5px;
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
        flex: 0 0 7%;
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

    body {
        margin: 0;
        /* Reset default margin */
        padding: 0;
        /* Reset default padding */
    }

    .button-container {
        display: flex;
        justify-content: flex-end;
        /* Aligns buttons to the right */
        position: absolute;
        /* Absolute positioning */
        bottom: 0;
        /* Aligns to the bottom of the parent container */
        left: 0;
        /* Optional, aligns container to the left edge */
        width: 100%;
        /* Ensures container spans the width of the parent */
        height: 70px;
        /* Specifies container height */
        margin: 0;
        /* Reset default margin */
        padding: 0 20px 70px 0;
        /* Reset default padding */
        cursor: pointer;
        /* Optional: makes it look clickable */
    }


    .category-button-container,
    .invemtory-button-container {
        display: flex;
        justify-content: left;
        /* Aligns buttons to the right */
        bottom: 0;
        margin: 50px;
        align-items: baseline;
        /* Space around buttons */
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
        background-color: #f3d9b2;
        /* Button background color */
        border: 1px solid #f3d9b2;
        border-radius: 35px;
        /* Button border */
        cursor: pointer;
        /* Pointer cursor on hover */
        transition: background-color 0.3s;
        /* Smooth background color change */
    }

    .category_button,
    .reset-button button {
        width: 200px;
        /* Set width for buttons */
        height: 50px;
        /* Set height for buttons */
        background-color: #f3d9b2;
        /* Button background color */
        border: 1px solid #f3d9b2;
        border-radius: 35px;
        /* Button border */
        cursor: pointer;
        /* Pointer cursor on hover */
        transition: background-color 0.3s;
        /* Smooth background color change */
    }

    .inventory_button {
        width: 200px;
        /* Set width for buttons */
        height: 50px;
        /* Set height for buttons */
        background-color: #f3d9b2;
        /* Button background color */
        border: 1px solid #f3d9b2;
        /* Button border */
        border-radius: 35px;
        /* Rounded button */
        cursor: pointer;
        /* Pointer cursor on hover */
        transition: background-color 0.3s;
        /* Smooth background color change */
        margin-left: 0;
        /* Align to the left */
        display: block;
        /* Ensure it's treated as a block for positioning */
    }

    .inventory-button-container {
        text-align: left;
        /* Align contents to the left */
        margin-top: 10px;
        /* Space at the top */
        margin-bottom: 30px;
        /* Space at the bottom */
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



    .inventory-cards {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap;
        /* Allows wrapping to the next line */
        justify-content: space-between;
        /* Distributes space between cards */
        justify-content: left;
        max-height: 450px !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        overflow-y: auto !important;

    }

    .category-cards {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap;
        /* Allows wrapping to the next line */
        justify-content: space-between;
        /* Distributes space between cards */
        justify-content: left;
        max-height: 500px !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        margin: 10px;
        overflow-y: auto !important;

    }

    /* Apply to the target element */
    .inventory-cards {
        max-height: 445px !important;
    }

    /* Customize scrollbar for Webkit browsers */
    .inventory-cards::-webkit-scrollbar {
        width: 5px;
        /* Width of the vertical scrollbar */
        height: 8px;
        /* Height of the horizontal scrollbar */
    }

    .inventory-cards::-webkit-scrollbar-track {
        background: #f3d9b2;
        /* Background of the track */
    }

    .inventory-cards::-webkit-scrollbar-thumb {
        background: #e28635;
        /* Color of the scrollbar thumb */
        border-radius: 55px;
        /* Rounded corners for the scrollbar thumb */
    }

    .inventory-cards::-webkit-scrollbar-thumb:hover {
        width: 5px;
        background: #CFD4D0;
        /* Change color when hovered */
    }

    /* For browsers supporting scrollbar properties */
    .inventory-cards {
        scrollbar-width: thin;
        /* Sets the scrollbar to a thin width */
        scrollbar-color: #e28635 #f3d9b2;
        /* Thumb color and track color */
    }

    .category-cards {
        scrollbar-width: thin;
        /* Sets the scrollbar to a thin width */
        scrollbar-color: #e28635 #f3d9b2;
        margin: 29px 15px;
        /* Thumb color and track color */
    }

    .card-row-inventory {
        position: relative;
        flex: 0 0 18%;
        /* Each card takes about 18% of the width */
        /* margin-bottom: 20px; */
        /* Spacing between rows */
        box-sizing: border-box;
        /* Ensures padding and border are included in width/height */
        text-align: center;
        /* Center the text in the card */
        max-width: 100%;

        margin: 10px;

        background: white;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);

        padding: 10px;
    }

    .card-row-category {
        position: relative;
        flex: 0 0 10%;
        /* Each card takes about 18%
        
        box-sizing: border-box;
        /* Ensures padding and border are included in width/height */
        text-align: center;
        /* Center the text in the card */
        max-width: 200px;

        margin: 10px;

        background: white;
        border-radius: 5px;
        cursor: pointer;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);

        padding: 50px;
    }

    .card-row-inventory img {
        max-width: 100%;
        height: 50px;
        margin-bottom: 50px;
    }


    .inventory-name {
        position: absolute;
        font-size: 12px;
        top: 66px;
        height: 100px;
        width: 100px;
    }

    .category-name {
        position: absolute;
        font-size: 12px;
        height: 100px;
        text-align: center;
        top: 40px;
        left: 0;
        width: 100px;
    }

    #selling-price {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        font-size: 12px;
        width: 100px;
    }

    .card-row-inventory.active {
        border: 2px solid #D6B79D;
        box-shadow: 0 4px 10px #D6B79D;
    }

    .card-row-category.active {
        border: 2px solid #D6B79D;
        box-shadow: 0 4px 10px #D6B79D;
    }

    .page-title {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        font-family: 'Times New Roman', Times, serif !important;
        text-align: center !important;
        color: #000 !important;
        margin-top: 50px !important;
    }




    /* Style for the 'mytotal' input */
    .mytotal {
        width: 150px;
        /* Width of the input field */
        padding: 8px 15px;
        /* Add padding for better spacing */
        border: 2px solid #e28635;
        /* Border color, similar to your theme */
        border-radius: 8px;
        /* Rounded corners */
        font-size: 16px;
        /* Font size */
        text-align: center;
        /* Center text inside the input */
        background-color: #fff;
        /* Background color */
        color: #333;
        /* Text color */
        font-weight: bold;
        /* Bold text for emphasis */
        outline: none;
        /* Remove outline on focus */
        transition: all 0.3s ease;
        /* Smooth transition for focus/hover */
    }

    /* Focused state for the .mytotal' input */
    .mytotal:focus {
        border-color: #ff914d;
        /* Change border color on focus */
        background-color: #f9f9f9;
        /* Light background on focus */
        box-shadow: 0 0 8px rgba(226, 134, 53, 0.5);
        /* Subtle shadow effect */
    }

    /* Optional: When the value is very large, ensure the text is properly aligned */
    .mytotal::-webkit-outer-spin-button,
    .mytotal::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* For mobile responsiveness: Adjust the input size */
    @media (max-width: 600px) {
        .mytotal {
            width: 100%;
            /* Make input take full width on small screens */
            padding: 10px;
            /* Increase padding for better touch interaction */
            font-size: 14px;
            /* Reduce font size for smaller screens */
        }
    }

    .table {
        display: block;
        width: 100% !important;
        margin-bottom: 1rem;
        color: #212529;
        display: block !important;
        border-left: 1px solid #87c2f0;
        border-right: 1px solid #87c2f0;
        padding: 25px;
        max-height: 300px !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        overflow-y: auto !important;
    }

    /* Customize scrollbar for Webkit browsers */
    .table::-webkit-scrollbar {
        width: 5px;
        /* Width of the vertical scrollbar */
        height: 8px;
        /* Height of the horizontal scrollbar */
    }

    .table::-webkit-scrollbar-track {
        background: #f3d9b2;
        /* Background of the track */
    }

    .table::-webkit-scrollbar-thumb {
        background: #e28635;
        /* Color of the scrollbar thumb */
        border-radius: 55px;
        /* Rounded corners for the scrollbar thumb */
    }

    .table::-webkit-scrollbar-thumb:hover {
        width: 5px;
        background: #CFD4D0;
        /* Change color when hovered */
    }

    /* For browsers supporting scrollbar properties */
    .table {
        scrollbar-width: thin;
        /* Sets the scrollbar to a thin width */
        scrollbar-color: #e28635 #f3d9b2;
        /* Thumb color and track color */
    }
</style>
<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>

<?php include "../include/sidebar_cashier.php"; ?>


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
        <div class="page-header flex-wrap mt-5">
            <h4 class="page-title" style="
    display: flex; 
    justify-content: center; 
    align-items: center; 
    font-family: 'Times New Roman', Times, serif; 
    text-align: center; 
    color: #000; font-size: 26px;
">
                <!-- <strong>POINT OF SALE</strong> -->
            </h4>

        </div>
    </div><!-- End header -->

    <section class="section">
        <div class="page-header flex-wrap">
            <h3 class="mb-0"> <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block"></span>
            </h3>

            <div class="d-flex">

                <!-- <a href="../cashier/user_inventory.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a> -->

                <!-- <button type="button" id="posButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i> Add Sale
                </button>

                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Export
                </button>


                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button> -->

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->

            </div>
        </div>
    </section>




    <section class="section">
        <div class="row">


            <div class="col-6" style="display: flex; justify-content: center;align-items: center; margin: 0 auto;">
                <div class="card stretch-card" id="allSaleContent" style="height: 685px; display: block; border: 2px solid #eab676;">
                    <div class="card-body">
                        <div class="table-responsive">

                            <form id="addSale" method="post">


                                <h5 style="color:#000; margin:5px;">Order Code</h5>


                                <table class="table table-hover" id="table_add">
                                    <tbody id="selected-inventory">

                                        <?php
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                            $total_sum = 0; // Initialize total sum

                                            if (isset($_POST['newcode'])) {
                                                echo '<h1 style="display: flex;  justify-content: top;  align-items: center;  
                                                font-family: \'Times New Roman\', Times, serif;  text-align: center;  
                                                color: #074A16; font-size: 16px; margin:15px;">' . htmlspecialchars($_POST['newcode']) . '</h1>';
                                            } else {
                                                echo '<h1 style="color: red; font-size: 16px; margin:15px;">New code not provided</h1>';
                                            }
                                        ?><input type="hidden" name="newcode[]" class="input" value="<?= htmlspecialchars($_POST['newcode']) ?>">


                                            <!-- add user -->
                                            <div style="display: flex; justify-content: center;align-items: center; margin: 0 auto; background: #fff; border: 2px solid #e28635; border-radius: 15px; margin: 12px 0;">
                                                <!-- Image Section -->
                                                <div style="width: 150px; flex: 0 0 auto; padding: 5px; border-right: 2px solid #e28635; border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                                                    <center><strong>IMAGE</strong></center>
                                                </div>

                                                <!-- Inventory Name -->
                                                <div class=" inventory_name" style="flex: 1; padding: 10px; text-align: center; font-size: 15px;">
                                                    <center><strong>ORDER NAME</strong></center>

                                                </div>

                                                <div style="flex: 1; padding: 10px; text-align: center;">
                                                    <center><strong>QTY</strong></center>
                                                </div>

                                                <!-- Inventory Name -->


                                                <div style="flex: 1; padding: 10px; text-align: center;">
                                                    <center><strong>PRICE</strong></center>
                                                </div>

                                            </div>

                                            <?php

                                            // Loop through the submitted products
                                            foreach ($_POST['product_name'] as $index => $prodname) {
                                                $prodid = $_POST['prodid'][$index] ?? ''; // Product ID
                                                $prod_price = $_POST['selling_price'][$index] ?? 0; // Product Price
                                                $prod_qty = $_POST['enter_stock'][$index] ?? 0; // Product Quantity
                                                $prod_sum = $prod_price * $prod_qty; // Calculate product total price
                                                $total_sum = $total_sum + $prod_sum; // Add product sum to total sum

                                                // Default image logic
                                                $prod_image = isset($_POST['image'][$index]) && !empty($_POST['image'][$index])
                                                    ? $_POST['image'][$index]
                                                    : 'tea_house.jpeg'; ?>


                                                <div style="display: flex; justify-content: center;align-items: center; margin: 0 auto; background: #fff; border: 2px solid #e28635; border-radius: 15px; margin: 12px 0;">
                                                    <!-- Image Section -->
                                                    <div style="width: 150px; flex: 0 0 auto; padding: 5px; border-right: 2px solid #e28635; border-top-left-radius: 15px; border-bottom-left-radius: 15px;">
                                                        <center> <img src="../assets/images/default_images/<?php echo !empty($prod_image) ? htmlspecialchars($prod_image) : 'tea_house.jpeg' ?>"
                                                                width="70"
                                                                height="70"
                                                                title="<?php echo htmlspecialchars($prodname) ?>"
                                                                style="border-radius: 50%; display: block;"></center>
                                                    </div>

                                                    <!-- Inventory Name -->
                                                    <div class=" inventory_name" style="width: 150px; flex: 0 0 auto; padding: 5px; padding: 10px; text-align: center; font-size: 15px;">
                                                        <center><?= htmlspecialchars($prodname) ?></center>

                                                    </div>
                                                    <!-- Hidden input field for product name -->
                                                    <input type="hidden" name="product_name[]" class="input inventory_name" value="<?= htmlspecialchars($prodname) ?>">

                                                    <div class=" inventory_name" style="width: 150px; flex: 0 0 auto; padding: 5px;  padding: 10px; text-align: center; font-size: 15px;">
                                                        <center><?= htmlspecialchars($prod_qty) ?></center><input type="hidden" name="enter_stock[]" class="form-control enter_stock_inventory" value="<?= htmlspecialchars($prod_qty) ?>" style="display:flex; justify-content: center; width: 100px !important; text-align: center; margin: 0 auto;border: none; background: none;">
                                                    </div>

                                                    <!-- Inventory Name -->


                                                    <div style="flex: 0 0 auto; padding: 5px;  padding: 10px; text-align: center;">
                                                        <center><input type="hidden" name="selling_price[]" class="form-control selling-price" value="<?= htmlspecialchars($prod_price) ?>" style="width: 100px !important; border: none; background: none;"></center>
                                                    </div>
                                                    <div style="flex: 0 0 auto; padding: 5px;  padding: 10px; text-align: center;">
                                                        <center><input type="text" name="total_amount[]" class="form-control total_amount" value="<?= htmlspecialchars($prod_sum) ?>" readonly style="width: 100px !important; border: none; background: none;"></center>

                                                    </div>
                                                </div>


                                    </tbody>

                                </table>

                            <?php
                                            }
                                            ?>
                                            <div class="total-sum" style="position:absolute; display: flex; justify-content: right; align-items: right; margin: 0 auto;bottom: 139px;  padding: 0 30px 70px 0;  ">
                                                <h4 class="mysum" >AMOUNT: P <input type="text" name="mytotal[]" id="mytotal" value="<?php echo  $total_sum ?>" readonly style="justify-content: right; align-items: right; border: 3px solid #eab676 !important; border-radius: 55px; width: 100px !important; border: none; background: none;"></h4>
                                            </div>

                          
                                            <div class="total-sum" style="position:absolute; display: flex; justify-content: right; align-items: right; margin: 0 auto;bottom: 97px;  padding: 0 30px 70px 0;  ">
                                                <h4 class="mydiscount" >DISCOUNT: P <input type="text" name="mydiscount[]" id="mydiscount" value=""  style="justify-content: right; align-items: right; border: 3px solid #eab676 !important; border-radius: 55px; width: 100px !important; border: none; background: none;"></h4>
                                            </div>

                          
                                            <div class="total-sum" style="position:absolute; display: flex; justify-content: right; align-items: right; margin: 0 auto;bottom: 57px;  padding: 0 30px 70px 0;  ">
                                                <h4 class="mytendered" >TENDERED: P <input type="text" name="mytendered[]" id="mytendered" value=""  style="justify-content: right; align-items: right; border: 3px solid #eab676 !important; border-radius: 55px; width: 100px !important; border: none; background: none;"></h4>
                                            </div>

                          
                                            <div class="total-sum" style=" position:absolute; display: flex; justify-content: right; align-items: right; margin: 0 auto;bottom: 17px;  padding: 0 30px 70px 0;  ">
                                                <h4 class="myoverall" >TOTAL: P <input type="text" name="myoverall[]" id="myoverall" value="<?php echo htmlspecialchars($total_sum) ?>" readonly style="justify-content: right; align-items: right; border: 3px solid #eab676 !important; border-radius: 55px; width: 100px !important; border: none; background: none;"></h4>
                                            </div>

                        <?php
                                        } else {
                                            echo '<p>No items submitted.</p>';
                                        }
                        ?>


                        <div class="button-container">
                            <button type="submit" id="save-btn" class="physical_inventory_button">
                                Place Order
                            </button>
                        </div>
                            </form>
                        </div>
                        <a href="../cashier/user_cashier.php" style="text-decoration:none; position:absolute; bottom: 17px; padding: 5px;">
                            <div class="reset-button">
                                <button id="reset-button-inventory">Back</button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>




    </section>







</main><!-- End #main -->



<?php include "../include/user_footer.php"; ?>


<?php include "../include/user_bottom.php"; ?>



<script>
    // Function to update the total (myoverall)
    function updateTotal() {
        // Get values of mytotal, mydiscount, and mytendered
        const mytotal = parseFloat(document.getElementById('mytotal').value) || 0;
        const mydiscount = parseFloat(document.getElementById('mydiscount').value) || 0;
        const mytendered = parseFloat(document.getElementById('mytendered').value) || 0;

        // Calculate the total (myoverall)
        const total = mytotal - mydiscount;

        // Update the myoverall field with the calculated total
        document.getElementById('myoverall').value = total.toFixed(2); // Optional: limit to 2 decimal places

        // Check if mytendered is less than myoverall or if mydiscount is empty
        const myoverall = parseFloat(document.getElementById('myoverall').value);
        const mytenderedField = document.getElementById('mytendered');
        const mydiscountField = document.getElementById('mydiscount');

        if (mytendered < myoverall || mydiscountField.value === '') {
            // If mytendered is less than myoverall or mydiscount is empty, set the border color to red
            mytenderedField.style.border = "3px solid red";
            // mydiscountField.style.border = "3px solid red";
        } else {
            // Otherwise, reset the border color to the original color
            mytenderedField.style.border = "3px solid #eab676";
            mydiscountField.style.border = "3px solid #eab676";
        }
    }

    // Add event listeners to recalculate the total whenever values change
    document.getElementById('mytotal').addEventListener('input', updateTotal);
    document.getElementById('mydiscount').addEventListener('input', updateTotal);
    document.getElementById('mytendered').addEventListener('input', updateTotal);

    // Initial calculation
    updateTotal();
</script>

<script>
    // AJAX form submission (for categories)
    $(document).ready(function() {
        $(document).on('submit', '#addSale', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("valid_sale", true);

            $.ajax({
                type: "POST",
                url: "../user_process/user_product_process.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.success == 100) {
                        showMessageBox(res.title, res.message, 'success');
                        setTimeout(function() {
                            location.href = '/yeocha_main/cashier/user_cashier.php';
                        }, 6000);
                    } else {

                        // Validate and change borders
                        showMessageBox(res.title, res.message, 'warning');
                    }
                },
                error: function(error) {

                    showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                }
            });
        });

    });
</script>