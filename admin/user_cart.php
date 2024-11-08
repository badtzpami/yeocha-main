<?php
include '../config/connect.php';

session_start();

// User's session

$id = $_SESSION["user_id_admin"];
$user_role = 'Admin';

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
</style>
<?php include "../include/user_top.php"; ?>

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

                <form id="updateInventoryRawProduct" method="post" onsubmit="handleFormSubmit(event)">

                    <div class="card stretch-card" id="allPhysicalInventoryRawContent">
                        <div class="card-body">

                            <?php include_once '../user_data/view_cart.php'; ?>


                        </div>

                        <div class="button-container">
                            <div class="reset-button">
                                <button id="reset-button-inventory">Unselect All</button>
                            </div>
                            <button type="submit" id="save-btn" class="physical_inventory_button">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>


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
    function handleFormSubmit(event) {
        // Prevent the form from submitting (which would refresh the page)
        event.preventDefault();

        // Optionally, you can perform AJAX here to send data to the server without reloading
        // For example, using Fetch or XMLHttpRequest to handle the form submission dynamically
        console.log("Form data would be submitted here");

        // If needed, you can then trigger an AJAX request here to submit the form data without refreshing
        const formData = new FormData(document.getElementById("updateInventoryRawProduct"));
        fetch('your-backend-url', {
            method: 'POST',
            body: formData
        }).then(response => {
            // Handle the response from the server (success or failure)
            return response.json();
        }).then(data => {
            // Process server response (e.g., show a success message)
            console.log("Form submitted successfully!", data);
        }).catch(error => {
            // Handle any errors that occur during the AJAX request
            console.error("Error submitting form:", error);
        });
    }


    // JavaScript for filtering products by category
    document.addEventListener('DOMContentLoaded', function() {
        const categoryButtons = document.querySelectorAll('.category-filter');

        categoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = button.getAttribute('data-category');

                // Hide all products
                const products = document.querySelectorAll('.card-items');
                products.forEach(product => {
                    product.style.display = 'none';
                });

                // Show products of selected category or show all if 'all' is selected
                if (category === 'all') {
                    products.forEach(product => {
                        product.style.display = 'block';
                    });
                } else {
                    const selectedProducts = document.querySelectorAll(`.card-items.${category}`);
                    selectedProducts.forEach(product => {
                        product.style.display = 'block';
                    });
                }
            });
        });

        // JavaScript for filtering products by search input
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchValue = searchInput.value.toLowerCase();
            const products = document.querySelectorAll('.card-items');

            products.forEach(product => {
                const productName = product.getAttribute('data-name');
                if (productName.includes(searchValue)) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
    const selectedMaterial = document.getElementById('selected-products');
    const materialCount = {};
    const totalMaterials = ['Material<?php echo $first_material['sm_id']; ?>'
        <?php
        $material_list_query1 = "SELECT * FROM `supplier_material` WHERE `sm_id` != ' " . $first_material['sm_id'] . " ' ORDER BY `sm_id` DESC";
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
            const rowCount = selectedMaterial.children.length + 1;

            // Fetch the selling price and store directly from data attributes
            const sellpriceInput = this.getAttribute('data-selling-price'); // Use data attribute for selling price
            const storeInput = this.getAttribute('data-store'); // Use data attribute for store

            // Increment the count for this material
            materialCount[materialName] = (materialCount[materialName] || 0) + 1;

            // Only add 'active' class if it's not already active
            if (!this.classList.contains('active')) {
                this.classList.add('active');
            }

            // Check if a row with the same material and store already exists
            const existingRow = Array.from(selectedMaterial.children).find(row => {
                const materialNameElement = row.querySelector('.material_name'); // Match material
                const storeNameElement = row.querySelector('.store_name'); // Match store
                return materialNameElement && materialNameElement.innerText === materialName &&
                    storeNameElement && storeNameElement.innerText === storeInput;
            });

            if (existingRow) {
                // If it exists, update the stock quantity and selling price
                const stockCell = existingRow.querySelector('.enter_stock');
                stockCell.value = materialCount[materialName];

                const sellpriceCell = existingRow.querySelector('.selling-price');
                sellpriceCell.value = sellpriceInput;

                // Recalculate total amount
                calculateTotal(existingRow);

            } else {
                // If it doesn't exist, create a new row
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                <td class="h6">
                    <h6 class="counter" style="width: 120px;">${rowCount}</h6>
                </td>
                <td class="input material_name">
                    <h6 class="ml-2">${materialName}</h6>
                </td>
                <input type="hidden" name="product_name[]" class="input material_name" value="${materialName}" style="width: 120px;">
                <td>
                    <input type="text" name="enter_stock[]" class="form-control enter_stock" value="${materialCount[materialName]}" style="width: 120px;">
                </td>
                <td>
                    <input type="text" readonly name="selling_price[]" class="form-control selling-price" value="${sellpriceInput}" style="width: 120px;">
                </td>
                <td>
                    <input type="text" name="total_amount[]" class="form-control total_amount" value="0" readonly style="width: 120px;">
                </td>
                
                <td class="input store_name">
                    <input type="hidden" name="store[]" class="form-control store_name" value="${storeInput}" readonly>
                    <h6 class="ml-2"  style="width: 140px;">${storeInput}</h6>
                </td>
                <td>
                    <button class="remove-btn">Remove</button>
                </td>
            `;
                selectedMaterial.appendChild(newRow);

                // Attach remove button event listener
                const removeButton = newRow.querySelector('.remove-btn');
                removeButton.addEventListener('click', function() {
                    validateInctiveBorders();

                    selectedMaterial.removeChild(newRow);
                    updateRowNumbers();
                    materialCount[materialName]--;
                    if (materialCount[materialName] >= 0) {
                        delete materialCount[materialName];
                        const cardToRemove = Array.from(document.querySelectorAll('.card-row')).find(c => c.getAttribute('data-name') === materialName);
                        cardToRemove.classList.remove('active');
                    }

                });

                // Initial total calculation
                calculateTotal(newRow);

                // Attach event listener for 'enter_stock' input field to auto-update total_amount
                const stockInputField = newRow.querySelector('.enter_stock');
                stockInputField.addEventListener('input', function() {
                    calculateTotal(newRow); // Recalculate total when stock input changes
                });
            }

            if (Object.keys(materialCount).length === totalMaterials.length) {
                document.querySelectorAll('.card-row').forEach(c => c.classList.add('active'));
            }
        });
    });

    // Calculate total function
    function calculateTotal(row) {
        const stockInput = row.querySelector('.enter_stock').value.replace(/,/g, '');
        const priceInput = row.querySelector('.selling-price').value.replace(/,/g, '');
        const totalAmountInput = row.querySelector('.total_amount');

        // Parse the values and calculate the total
        const totalAmount = (parseFloat(stockInput) || 0) * (parseFloat(priceInput) || 0);
        totalAmountInput.value = totalAmount.toFixed(2);
    }


    function updateRowNumbers() {
        Array.from(selectedMaterial.children).forEach((row, index) => {
            row.querySelector('.h6').innerText = index + 1;
        });
    }

    function validateActiveBorders() {
        const activeElements = document.querySelectorAll('.card-row.active');
        activeElements.forEach(el => {
            el.style.border = '2px solid red';
        });
    }

    function validateInctiveBorders() {
        const activeElements = document.querySelectorAll('.card-row.active');
        activeElements.forEach(el => {
            el.style.border = '';
        });
    }

    document.getElementById('reset-button').addEventListener('click', function() {
        selectedMaterial.innerHTML = '';
        for (const material in materialCount) {
            delete materialCount[material];
        }
        document.querySelectorAll('.card-row').forEach(card => {
            card.classList.remove('active');
        });
    });

    // Add active class to elements


    // AJAX form submission (for categories)
    $(document).ready(function() {
        $(document).on('submit', '#addItemProduct', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("valid_cart", true);

            $.ajax({
                type: "POST",
                url: "../user_process/user_delivery_process.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.success == 100) {
                        showMessageBox(res.title, res.message, 'success');
                        setTimeout(function() {
                            location.href = '/yeocha_main/admin/user_cart.php';
                        }, 6000);
                    } else {
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