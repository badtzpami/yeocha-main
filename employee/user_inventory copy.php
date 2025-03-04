<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session

$id = $_SESSION["user_id_employee"];
$user_role = 'Employee';

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

        margin-bottom: 10px;

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
</style>
<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>

<?php include "../include/sidebar_employee.php"; ?>


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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Product Table</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">User Product</li>
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

                <a href="../employee/user_inventory.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>

                <button type="button" id="PhysicalInventoryButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Physical Inventory
                </button>

                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->


                <button type="button" id="addPhysicalInventoryButton" class="btn add">
                    Add Items
                </button>
            </div>
        </div>
    </section>



    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="viewPhysicalInventoryContent">
                    <div class="card-body">
                        <h5 class="card-title">View Inventory</h5>
                        <div class="table-responsive">
                            <!-- <form id="updateUserActiveAccount" method="post"> -->

                            <?php include_once '../user_data/user_inventory.php'; ?>

                            <!-- <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form> -->
                        </div>
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

                            <h5 class="card-title">Add Physical Inventory Data</h5>
                            <form id="addUserProduct" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Material Name</th>
                                            <th>Stock <span style="color:red">*</span></th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="selected-products">



                                    </tbody>


                                </table>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>

                            <div class="row">
                                <div class="reset-button">
                                    <button id="reset-button">Reset Selection</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




    </section>
    <div class="card stretch-card" id="selectPhysicalInventoryContent" style="display: none;">
        <div class="card-body">

            <div class="table-responsive">
                <!-- add user -->

                <form id="addUserProduct" method="post">
                    <div class="row-materials">
                        <div class="material-cards">
                            <?php

                            $first_material_list_query = "SELECT * FROM `material` ORDER BY `ma_id` DESC LIMIT 1";
                            $first_material_list_result = mysqli_query($conn, $first_material_list_query);
                            $first_material = mysqli_fetch_array($first_material_list_result);

                            ?>
                            <div class="card-row" data-name="<?php echo $first_material['material_name']; ?>">
                                <?php if (is_array($first_material)) { ?>
                                    <?php if (empty($first_material['image'])) { ?>
                                        <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $first_material['material_name']; ?>" id="Material<?php echo $first_material['ma_id']; ?>">
                                    <?php } else { ?>
                                        <img src="../assets/images/material_images/<?php echo $first_material['image']; ?>" alt="Material<?php echo $first_material['ma_id']; ?>" id="Material<?php echo $first_material['ma_id']; ?>">
                                <?php }
                                } ?>
                                <div class="material-name"><?php echo $first_material['material_name']; ?></div>
                            </div>
                            <?php
                            $material_list_query = "SELECT * FROM `material` WHERE `ma_id` != ' " . $first_material['ma_id'] . " ' ORDER BY `ma_id` DESC";
                            $material_list_result = mysqli_query($conn, $material_list_query);

                            if (mysqli_num_rows($material_list_result) > 0) {
                                while ($material = mysqli_fetch_array($material_list_result)) { ?>
                                    <div class="card-row" data-name="<?php echo $material['material_name']; ?>">
                                        <?php if (is_array($material)) { ?>
                                            <?php if (empty($material['image'])) { ?>
                                                <img src="../assets/images/default_images/tea_house.jpeg" alt="<?php echo $first_material['material_name']; ?>" id="Material<?php echo $first_material['ma_id']; ?>">
                                            <?php } else { ?>
                                                <img src="../assets/images/material_images/<?php echo $material['image']; ?>" alt="Material<?php echo $first_material['ma_id']; ?>" id="Material<?php echo $first_material['ma_id']; ?>">
                                        <?php }
                                        } ?>
                                        <div class="material-name"><?php echo $material['material_name']; ?></div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </form>

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
    const selectedProducts = document.getElementById('selected-products');
    const materialCount = {};
    const totalMaterials = ['Material<?php echo $first_material['ma_id']; ?>'
        <?php
        $material_list_query1 = "SELECT * FROM `material` WHERE `ma_id` != ' " . $first_material['ma_id'] . " ' ORDER BY `ma_id` DESC";
        $material_list_result1 = mysqli_query($conn, $material_list_query1);

        if (mysqli_num_rows($material_list_result1) > 0) {
            while ($material1 = mysqli_fetch_array($material_list_result1)) { ?>, 'Material<?php echo $material1['material_name']; ?>'
        <?php
            }
        }
        ?>

    ];

    document.querySelectorAll('.card-row').forEach(card => {
        card.addEventListener('click', function() {
            const materialName = this.getAttribute('data-name');
            const rowCount = selectedProducts.children.length + 1;

            // Increment the count for this material
            materialCount[materialName] = (materialCount[materialName] || 0) + 1;

            // Only add 'active' class if it's not already active
            if (!this.classList.contains('active')) {
                this.classList.add('active');
            }

            const existingRow = Array.from(selectedProducts.children).find(row =>
                row.querySelector('.material_name').innerText === materialName
            );

            if (existingRow) {
                // If it exists, update the stock quantity
                const stockInput = existingRow.querySelector('.enter_stock');
                stockInput.value = materialCount[materialName];
            } else {
                // If it doesn't exist, create a new row
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td class="h6">${rowCount}</td>
                <td class="input material_name" contenteditable="true">${materialName}</td>
                <input type="hidden" name="material_name[]" value="${materialName}">
                <td><input type="text" name="enter_stock[]" value="${materialCount[materialName]}" class="input enter_stock"></td>
                <td><button class="remove-btn">Remove</button></td>
            `;
                selectedProducts.appendChild(newRow);

                const removeButton = newRow.querySelector('.remove-btn');
                removeButton.addEventListener('click', function() {
                    selectedProducts.removeChild(newRow);
                    updateRowNumbers();
                    materialCount[materialName]--;
                    if (materialCount[materialName] >= 0) {
                        delete materialCount[materialName];
                        const cardToRemove = Array.from(document.querySelectorAll('.card-row')).find(c => c.getAttribute('data-name') === materialName);
                        cardToRemove.classList.remove('active');
                    }
                });
            }

            if (Object.keys(materialCount).length === totalMaterials.length) {
                document.querySelectorAll('.card-row').forEach(c => c.classList.add('active'));
            }
        });
    });

    document.getElementById('reset-button').addEventListener('click', function() {
        selectedProducts.innerHTML = '';
        for (const material in materialCount) {
            delete materialCount[material];
        }
        document.querySelectorAll('.card-row').forEach(card => {
            card.classList.remove('active');
        });
    });

    function updateRowNumbers() {
        Array.from(selectedProducts.children).forEach((row, index) => {
            row.querySelector('.h6').innerText = index + 1;
        });
    }
</script>