<?php
include '../config/connect.php';

session_start();

// User's session

$id = $_SESSION["user_id_supplier"];
$user_role = 'Supplier';

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
        padding: 0;
        /* margin-right: 35px; */
        margin: 0;
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
        height: 50px !important;
        padding: 12px 20px !important;
        margin: 0 25px;
        font-size: 18px !important;
        color: #fff !important;
        background-color: #e74c3c !important;
        /* Red background */
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    a.newlink_delete {
        display: inline-block;
        width: 100px !important;
        height: 50px !important;
        padding: 12px 20px !important;
        margin: 0 25px;
        font-size: 14px !important;
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

















    .card-container {
        margin: 5px;
        display: flex;
        justify-content: center;
        height: 100%;

    }

    .card-custom {
        width: 100%;
        height: 400px;

        max-width: 1200px;
        border: 1px solid #000;
        border-radius: 36px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    .store-name {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .status {
        font-weight: bold;
        color: #27ae60;
        font-size: 1.1rem;
    }

    .image-box {
        width: 200px;
        height: 200px;
        background-color: #f0f0f0;
        margin-right: 15px;
        border-radius: 15px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .material-name {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .type-quantity {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
    }

    .sell-price {
        display: flex;
        justify-content: right;
        margin-top: 5px;
        font-weight: bold;
        font-size: 1rem;
    }

    .total-items {
        display: flex;
        justify-content: right;
        font-size: 1rem;
        font-weight: bold;
        margin-top: 10px;
    }

    .buy-again-btn {
        background-color: #eee;
        color: #28a745;
        font-weight: bold;
        border-radius: 5px;
        font-size: 1rem;
        padding: 10px 30px;
        border: 2px solid #28a745;
    }

    .buy-again-btn:hover {
        background-color: #28a745;

        color: #fff;
        font-weight: bold;
    }

    .row-custom {
        align-items: center;
    }

    /* Adjust for small screens */
    @media (max-width: 576px) {
        .row-custom {
            flex-direction: column;
            text-align: center;
        }

        .image-box {
            margin-bottom: 10px;
        }

        .buy-again-btn {
            width: 100%;
        }
    }










    /* Custom Styling */
    .card {
        border-radius: 10px;
        margin-bottom: 50px;
    }

    .shipping-info {
        font-size: 14px;
    }

    .shipping-info span {
        font-size: 20px;
        color: #888;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .ml-2 {
        margin-left: 10px;
    }

    .card-body {
        padding: 20px;
    }

    /* Gray Partition */
    hr {
        border: 1px solid #e0e0e0;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* Transparent Input for Order Code */
    .order-code {
        border: none;
        background-color: transparent;
        outline: none;
        width: 150px;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    /* FontAwesome Icons */
    .bi {
        font-size: 24px;
    }

    /* Copy Button */
    button[onclick="copyOrderCode()"] {
        margin-left: 10px;
    }



    .activity .activity-item .activite-label::before {
        content: "";
        position: absolute;
        right: -11px;
        width: 5px !important;
        height: 15px !important;
        top: 0;
        bottom: 0;
        background-color: #eceefe;
    }








    /* Custom Styling */
    .card {
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .shipping-info {
        font-size: 14px;
    }

    .shipping-info span {
        font-size: 20px;
        color: #888;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .ml-2 {
        margin-left: 10px;
    }

    .card-body {
        padding: 20px;
    }

    /* Gray Partition */
    hr {
        border: 1px solid #e0e0e0;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    /* Transparent Input for Order Code */
    .order-code {
        border: none;
        background-color: transparent;
        outline: none;
        width: 150px;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    /* FontAwesome Icons */
    .bi {
        font-size: 24px;
    }

    /* Copy Button */
    button[onclick="copyOrderCode()"] {
        margin-left: 10px;
    }
</style>
<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>

<?php include "../include/sidebar_supplier.php"; ?>


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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">All Orders</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../supplier/user_sale.php">Home</a></li>
                                <li class="breadcrumb-item">My Orders</li>
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

                <a href="../supplier/user_orders.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>
                <button type="button" id="checkOutButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>All Materials
                </button>

                <button type="button" id="toPackButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>To Pack
                </button>

                <button type="button" id="toShipButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>To Ship
                </button>

                <button type="button" id="toReceiveButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Drop Off
                </button>

                <button type="button" id="toCompletedButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Completed
                </button>

                <button type="button" id="toCancelledButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Cancelled
                </button>

            </div>
        </div>
    </section>

    <section class="section" id="checkOutContent">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <h5 class="card-title">All Check Out</h5>

                    <form id="CancelItem" action="" method="post"> <!-- Button or Card that will trigger the URL change -->

                        <!-- Content that will change dynamically -->
                        <?php include_once '../user_data/all_checkout.php'; ?>

                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>

    <section class="section" id="toPackContent" style="display: none;">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <h5 class="card-title">All To Pack</h5>
                    <form id="addItemProduct" method="post"> <!-- Button or Card that will trigger the URL change -->

                        <!-- Content that will change dynamically -->
                        <?php include_once '../user_data/all_topack.php'; ?>

                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>

    <section class="section" id="toShipContent" style="display: none;">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <h5 class="card-title">All To Ship</h5>
                    <form id="addItemProduct" method="post">
                        <?php include_once '../user_data/all_toship.php'; ?>
                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>


    <section class="section" id="toReceiveContent" style="display: none;">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <h5 class="card-title">All To Receive</h5>
                    <form id="addItemProduct" method="post">
                        <?php include_once '../user_data/all_toreceived.php'; ?>
                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>


    <section class="section" id="completedContent" style="display: none;">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <!-- add user -->

                    <h5 class="card-title">All Complete</h5>
                    <form id="addItemProduct" method="post">
                        <?php include_once '../user_data/all_completed.php'; ?>
                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>




    <section class="section" id="cancelledContent" style="display: none;">
        <div class="row">
            <col-lg-12>
                <div class="table-responsive">
                    <!-- add user -->

                    <h5 class="card-title">All Cancelled</h5>
                    <form id="BuyAgainItem" method="post">
                        <?php include_once '../user_data/all_cancelled.php'; ?>
                    </form>
                </div>
            </col-lg-12>
        </div>
    </section>






</main><!-- End #main -->



<?php include "../include/user_footer.php"; ?>


<?php include "../include/user_bottom.php"; ?>


<script>
    $(document).ready(function() {
        $('.update_order').click(function(e) {
            e.preventDefault(); // Prevent default behavior

            var or_id = $(this).attr('id');
            var $ele = $(this).parent().parent();
            Swal.fire({
                title: 'Are you Sure?',
                text: "You want to save?",
                // showDenyButton: true,
                showCancelButton: true,
                icon: 'warning',

                confirmButtonText: 'Save',

            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    // Create FormData for the status update
                    var formData = new FormData();
                    formData.append("update_order", true); // Add status update parameter
                    formData.append("or_id", or_id); // Assuming you pass the user ID

                    $.ajax({
                        type: "POST",
                        url: "../user_process/order_process.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log('Server response:', response);
                            var res = jQuery.parseJSON(response);

                            if (res.success == 100) {
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/supplier/user_orders.php';
                                }, 6000);
                            } else if (res.success == 200) {
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/supplier/user_cart.php';
                                }, 6000);
                            } else {
                                showMessageBox(res.title, res.message, 'warning');
                            }
                        },
                        error: function(error) {
                            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                            console.log('error', error);
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info').then(function() {
                        location.reload();
                    });
                }
            })
        });
    });
</script>