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
    header("Location: ../user_signin/signin.php");
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

    .card-row-inventory {
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

    .card-row-inventory img {
        max-width: 100%;
        height: 150px;
    }

    .inventory-name {
        margin-top: 10px;
        font-weight: bold;
    }

    .card-row-inventory.active {
        border: 2px solid #007bff;
        box-shadow: 0 4px 20px rgba(0, 123, 255, 0.5);
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
        <div class="page-header flex-wrap mt-3">
            <div class="row">
                <div class="col-9">
                    <div class="d-flex">
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Point Of Sale</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../cashier/user_sale.php">Home</a></li>
                                <li class="breadcrumb-item">User POS</li>
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

                <a href="../cashier/user_inventory.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>

                <button type="button" id="posButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i> Add Sale
                </button>

                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Export
                </button>


                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->

            </div>
        </div>
    </section>




    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="allSaleContent">
                    <div class="card-body">

                        <div class="table-responsive product-table">
                            <!-- add user -->

                            <h5 class="card-title">Add Item</h5>
                            <form id="addSale" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Enter Stock</th>
                                            <th>Selling Price</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="selected-inventory">


                                    </tbody>

                                </table>
                                <div class="button-container">
                                    <div class="reset-button">
                                        <button id="reset-button-inventory">Reset Selection</button>
                                    </div>
                                    <button type="submit" id="save-btn" class="physical_inventory_button">
                                        Submit
                                    </button>
                                </div>
                        </div>
                    </div>



                    </form>


                </div>
                <div class="row">
                    <div class="right-inv">

                    </div>
                </div>
        </div>
        </div>


        <div class="card stretch-card" id="selectPhysicalInventoryDisposableContent">
            <div class="card-body">
                <h5 class="card-title">All Items</h5>

                <div class="table-responsive">
                    <!-- add user -->

                    <div class="row-inventory">
                        <div class="inventory-cards">

                            <?php

                            $second_material_list_query = "SELECT * FROM product ORDER BY pr_id DESC LIMIT 1";
                            $second_material_list_result = mysqli_query($conn, $second_material_list_query);
                            $second_material = mysqli_fetch_array($second_material_list_result);

                            ?>

                            <div class="card-row-inventory" data-name-inventory="<?php echo $second_material['product_name']; ?>" data-selling-price="<?php echo $second_material['selling_price']; ?>">
                                <?php if (is_array($second_material)) { ?>
                                    <?php if (empty($second_material['image'])) { ?>
                                        <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $second_material['product_name']; ?>" id="Inventory<?php echo $second_material['pr_id']; ?>">
                                    <?php } else { ?>
                                        <img src="../assets/images/material_images/<?php echo $second_material['image']; ?>" alt="Inventory<?php echo $second_material['pr_id']; ?>" id="Inventory<?php echo $second_material['pr_id']; ?>">
                                <?php }
                                } else {
                                }
                                ?>
                                <div class="inventory-name"><?php echo $second_material['product_name']; ?></div>
                                <input type="text" readonly id="selling-price" class="form-control" value="<?php echo $second_material['selling_price']; ?>" style="text-align: center;">


                            </div>
                            <?php
                            $material_list_query = "SELECT * FROM product WHERE pr_id != " . $second_material['pr_id'] . " ORDER BY pr_id DESC";
                            $material_list_result = mysqli_query($conn, $material_list_query);

                            if (mysqli_num_rows($material_list_result) > 0) {
                                while ($material = mysqli_fetch_array($material_list_result)) { ?>
                                    <div class="card-row-inventory" data-name-inventory="<?php echo $material['product_name']; ?>" data-selling-price="<?php echo $material['selling_price']; ?>">
                                        <?php if (is_array($material)) { ?>
                                            <?php if (empty($material['image'])) { ?>
                                                <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $second_material['product_name']; ?>" id="Inventory<?php echo $second_material['pr_id']; ?>">
                                            <?php } else { ?>
                                                <img src="../assets/images/product_images/<?php echo $material['image']; ?>" alt="Inventory<?php echo $second_material['pr_id']; ?>" id="Inventory<?php echo $second_material['pr_id']; ?>">
                                        <?php }
                                        } ?>
                                        <div class="inventory-name"><?php echo $material['product_name']; ?></div>
                                        <input type="text" readonly id="selling-price" class="form-control" value="<?php echo $material['selling_price']; ?>" style="text-align: center;">

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
    const selectedInventory = document.getElementById('selected-inventory');
    const inventoryCount = {};
    const totalInventory = [
        'Inventory<?php echo $second_material['material_name']; ?>'
        <?php
        $material_list_query2 = "SELECT * FROM `material` WHERE `ma_id` != ' " . $second_material['ma_id'] . " ' ORDER BY `ma_id` DESC";
        $material_list_result2 = mysqli_query($conn, $material_list_query2);

        if (mysqli_num_rows($material_list_result2) > 0) {
            while ($material2 = mysqli_fetch_array($material_list_result2)) { ?>, 'Inventory<?php echo $material2['material_name']; ?>'
        <?php
            }
        }
        ?>
    ];

    document.querySelectorAll('.card-row-inventory').forEach(card => {
        card.addEventListener('click', function() {
            const inventoryName = this.getAttribute('data-name-inventory');
            const rowCount = selectedInventory.children.length + 1;
            const stockInput = this.querySelector('input[name="enterstock"]');
            // Fetch the selling price and store directly from data attributes
            const sellpriceInput = this.getAttribute('data-selling-price'); // Use data attribute for selling price
 

            // Increment the count for this material
            inventoryCount[inventoryName] = (inventoryCount[inventoryName] || 0) + 1;

            // Only add 'active' class if it's not already active
            if (!this.classList.contains('active')) {
                this.classList.add('active');
            }

            const existingRow = Array.from(selectedInventory.children).find(row =>
                row.querySelector('.inventory_name').innerText === inventoryName
            );

            if (existingRow) {
                // If it exists, update the stock quantity
                const stockCell = existingRow.querySelector('.enter_stock_inventory');
                stockCell.value = inventoryCount[inventoryName];

                const sellpriceCell = existingRow.querySelector('.selling-price');
                sellpriceCell.value = sellpriceInput;

                // Recalculate total amount
                calculateTotal(existingRow);

            } else {
                // If it doesn't exist, create a new row
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td class="h6">
                    <h6 class="counter ml-2" style="width: 200px;">${rowCount}</h6>
                </td>
                <td class="input inventory_name">
                    <h6 class="ml-2">${inventoryName}</h6>
                </td>
                <input type="hidden" name="product_name[]" class="input inventory_name" value="${inventoryName}">
                <td>
                        <input type="text" name="enter_stock[]" class="form-control enter_stock_inventory" value="${inventoryCount[inventoryName]}">
                </td>
                <td>
                        <input type="text" name="selling_price[]" class="form-control selling-price" value="${sellpriceInput}">
                </td>
                <td>
                        <input type="text" name="total_amount[]" class="form-control total_amount" value="0" readonly>
                </td>
                <td>
                    <button class="remove-btn-inventory">Remove</button>
                </td>
            `;
                selectedInventory.appendChild(newRow);


                // Attach remove button event listener

                const removeButton = newRow.querySelector('.remove-btn-inventory');
                removeButton.addEventListener('click', function() {
                    validateInctiveBorders();

                    selectedInventory.removeChild(newRow);
                    updateRowNumbers();
                    inventoryCount[inventoryName]--;
                    if (inventoryCount[inventoryName] >= 0) {
                        delete inventoryCount[inventoryName];
                        const cardToRemove = Array.from(document.querySelectorAll('.card-row-inventory')).find(c => c.getAttribute('data-name-inventory') === inventoryName);
                        cardToRemove.classList.remove('active');
                    }

                });





                // Initial total calculation
                calculateTotal(newRow);
            }

            if (Object.keys(inventoryCount).length === totalInventory.length) {
                document.querySelectorAll('.card-row-inventory').forEach(c => c.classList.add('active'));
            }
        });
    });

    // Other functions remain unchanged

    function formatNumber(input) {
        // Remove non-numeric characters except for the decimal point
        let value = input.value.replace(/[^0-9.]/g, '');

        // Convert to float and format to 2 decimal places
        const numberValue = parseFloat(value) || 0;
        input.value = numberValue.toLocaleString('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2,
        });


    }

    function calculateTotal(row) {
        const stockInput = row.querySelector('.enter_stock_inventory').value.replace(/,/g, '');
        const priceInput = row.querySelector('.selling-price').value.replace(/,/g, '');
        const totalAmountInput = row.querySelector('.total_amount');

        // Parse the values and calculate the total
        const totalAmount = (parseFloat(stockInput) || 0) * (parseFloat(priceInput) || 0);
        totalAmountInput.value = totalAmount.toFixed(2);
    }

    function updateRowNumbers() {
        Array.from(selectedInventory.children).forEach((row, index) => {
            row.querySelector('.h6').innerText = index + 1;
        });
    }

    function validateActiveBorders() {
        const activeElements = document.querySelectorAll('.card-row-inventory.active');
        activeElements.forEach(el => {
            el.style.border = '2px solid red';
        });
    }

    function validateInctiveBorders() {
        const activeElements = document.querySelectorAll('.card-row-inventory.active');
        activeElements.forEach(el => {
            el.style.border = '';
        });
    }

    document.getElementById('reset-button-inventory').addEventListener('click', function() {
        selectedInventory.innerHTML = '';
        for (const inventory in inventoryCount) {
            delete inventoryCount[inventory];
        }
        document.querySelectorAll('.card-row-inventory').forEach(card => {
            card.classList.remove('active');
        });
    });


    // Add active class to elements


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
                            location.href = '/yeocha_main/cashier/user_pos.php';
                        }, 6000);
                    } else {

                        // Validate and change borders
                        validateActiveBorders();
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