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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Material Table</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">User Product Material</li>
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

                <a href="../admin/user_product_material.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>
                <button type="button" id="viewMaterialButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>View
                </button>

                <button type="button" id="MaterialAllButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>All Material
                </button>

                <button type="button" id="MaterialArchiveButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Archive
                </button>

                <button type="button" id="MaterialActiveButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>History
                </button>


                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->


                <button type="button" id="addRawMaterialButton" class="btn add">
                    Add Material
                </button>


                <!-- <button type="button" id="addDisposableMaterialButton" class="btn add">
                    Add example
                </button> -->
            </div>
        </div>
    </section>



    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="viewMaterialContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">View Materials</h5>
                        <div class="table-responsive">

                            <?php include_once '../user_data/view_products.php'; ?>

                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="activeMaterialContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Materials History</h5>
                        <div class="table-responsive">

                                <?php include_once '../user_data/history_data.php'; ?>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="card stretch-card" id="allMaterialContent">
                    <div class="card-body">
                        <h5 class="card-title">All Materials</h5>
                        <div class="table-responsive">
                            <form id="updateUserMaterial" method="post">

                                <?php include_once '../user_data/material_data.php'; ?>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="archiveMaterialContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Archive Materials</h5>
                        <div class="table-responsive">
                            <form id="updateUserArchive" method="post">

                                <?php include_once '../user_data/archive_data.php'; ?>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>






                <div class="card stretch-card" id="addRawContent" style="display: none;">
                    <div class="card-body">
                        <input type="button" id="add-rawMaterial" class="btn add_account" value="+">

                        <div class="table-responsive">
                            <!-- add user -->

                            <h5 class="card-title">Add Raw Data</h5>
                            <form id="addUserMaterial" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Material Name <span style="color:red">*</span></th>
                                            <th>Stock <span style="color:red">*</span></th>
                                            <th>Type <span style="color:red">*</span></th>
                                            <th>Units <span style="color:red">*</span></th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="input-container-raw-material">



                                    </tbody>


                                </table>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="addDisposableContent" style="display: none;">
                    <div class="card-body">
                        <input type="button" id="add-product" class="btn add_account" value="+">

                        <div class="table-responsive">
                            <!-- add user -->

                            <h5 class="card-title">Add Disposable</h5>
                            <form id="addUserProduct" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Name <span style="color:red">*</span></th>
                                            <th>Category <span style="color:red">*</span></th>
                                            <th>Selling Price <span style="color:red">*</span></th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="input-container-product">



                                    </tbody>


                                </table>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
        .input-field {
            width: 250px;
            padding: 5px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .remove-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #ff1a1a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            width: 250px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        select {
            width: 200px !important;
        }
    `;

        document.head.appendChild(style);


        function createInputField(name, placeholder) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = name;
            input.placeholder = placeholder;
            input.classList.add('input-field');
            return input;
        }

        function createTableCell(element) {
            const td = document.createElement('td');
            td.appendChild(element);
            return td;
        }


        // Product section (similar to category)
        const addRawMaterial = document.getElementById('add-rawMaterial');
        const inputContainerRawMaterial = document.getElementById('input-container-raw-material');
        let materialCounter = 0;

        addRawMaterial.addEventListener('click', function() {
            materialCounter++;
            const row = document.createElement('tr');

            const numberCell = document.createElement('td');
            numberCell.textContent = materialCounter;
            row.appendChild(numberCell);


            // const product_nameSelect = createProductSelect();
            const material_name = createInputField('material_name[]', 'Material Name');
            const type_nameSelect = createTypeSelect();
            const stock = createInputField('stock[]', 'Stock');
            const unit_nameSelect = createUnitSelect();

            const removeBtn = createRemoveProductButton(row);

            // row.appendChild(createTableCell(product_nameSelect));
            row.appendChild(createTableCell(material_name));
            row.appendChild(createTableCell(type_nameSelect));
            row.appendChild(createTableCell(stock));
            row.appendChild(createTableCell(unit_nameSelect));

            row.appendChild(createTableCell(removeBtn));

            inputContainerRawMaterial.appendChild(row);
            updateProductRowNumbers();
        });

        function createRemoveProductButton(row) {
            const btnProduct = document.createElement('button');
            btnProduct.textContent = 'Remove';
            btnProduct.classList.add('remove-btn');
            btnProduct.addEventListener('click', function() {
                inputContainerRawMaterial.removeChild(row);
                updateRowNumbers();
            });
            return btnProduct;
        }


        function createProductSelect() {
            const select = document.createElement('select');
            select.name = 'product_name[]';
            select.classList.add('input-field');

            // Initialize the options array
            const productOptions = [{
                    id: '',
                    name: 'Choose Product'
                } // Default option
                <?php
                $product_query = "SELECT * FROM `product` ORDER BY `pr_id` DESC";
                $product_list = mysqli_query($conn, $product_query);

                if (mysqli_num_rows($product_list) > 0) {
                    while ($row = mysqli_fetch_array($product_list)) {
                        // Echo the ca_id and product_name as a JSON object
                        echo ", { id: '" . $row['pr_id'] . "', name: '" . addslashes($row['product_name']) . "' }";
                    }
                }
                ?>
            ];

            // Populate the select options
            productOptions.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id; // Set ca_id as the value
                option.textContent = product.name.charAt(0).toUpperCase() + product.name.slice(1); // Set product_name as text
                select.appendChild(option);
            });

            return select;
        }

        function createUnitSelect() {
            const select = document.createElement('select');
            select.name = 'unit_name[]';
            select.classList.add('input-field');

            // Initialize the options array
            const unitMaterialOptions = [{
                    id: '',
                    name: 'Choose unit of material'
                }, {
                    id: '1',
                    name: 'ml'
                }, {
                    id: '2',
                    name: 'g'
                }, {
                    id: '3',
                    name: 'pcs'
                }

            ];
            // Populate the select options
            unitMaterialOptions.forEach(unitMaterial => {
                const option = document.createElement('option');
                option.value = unitMaterial.id; // Set ca_id as the value
                option.textContent = unitMaterial.name.charAt(0).toUpperCase() + unitMaterial.name.slice(1); // Set typeMaterial_name as text
                select.appendChild(option);
            });

            return select;
        }

        function createTypeSelect() {
            const select = document.createElement('select');
            select.name = 'type_name[]';
            select.classList.add('input-field');

            // Initialize the options array
            const typeMaterialOptions = [{
                    id: '',
                    name: 'Choose type of material'
                }, {
                    id: '1',
                    name: 'Raw'
                }, {
                    id: '2',
                    name: 'Disposable'
                }

            ];

            // Populate the select options
            typeMaterialOptions.forEach(typeMaterial => {
                const option = document.createElement('option');
                option.value = typeMaterial.id; // Set ca_id as the value
                option.textContent = typeMaterial.name.charAt(0).toUpperCase() + typeMaterial.name.slice(1); // Set typeMaterial_name as text
                select.appendChild(option);
            });

            return select;
        }


        // Function to update row numbers and check for records
        function updateProductRowNumbers() {
            const rows = inputContainerRawMaterial.getElementsByTagName('tr');

            // Update row numbers
            for (let i = 0; i < rows.length; i++) {
                rows[i].firstChild.textContent = i + 1; // Update the first cell with the correct number
            }

        }


        $(document).ready(function() {
            // AJAX form submission (for products)
            $(document).on('submit', '#addUserMaterial', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("valid_material", true);

                $.ajax({
                    type: "POST",
                    url: "../user_process/user_product_process.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Server response:', response);

                        var res = jQuery.parseJSON(response);
                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/yeocha_main/admin/user_product_material.php';
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



        $(document).ready(function() {
            // Handle form submission for #updateUserCategory
            $(document).on('submit', '#updateUserArchive', function(e) {
                e.preventDefault();

                // Create a new FormData object
                var formData = new FormData(this);
                formData.append("update_material", true);

                $.ajax({
                    type: "POST",
                    url: "../user_process/user_product_process.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Server response:', response);

                        var res = jQuery.parseJSON(response);

                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/yeocha_main/admin/user_product_material.php';
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
            });
        });

        $(document).ready(function() {
            // Handle form submission for #updateUserCategory
            $(document).on('submit', '#updateUserMaterial', function(e) {
                e.preventDefault();

                // Create a new FormData object
                var formData = new FormData(this);
                formData.append("update_material", true);

                $.ajax({
                    type: "POST",
                    url: "../user_process/user_product_process.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Server response:', response);

                        var res = jQuery.parseJSON(response);

                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/yeocha_main/admin/user_product_material.php';
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
            });
        });

        // Delete Category
        $(document).ready(function() {
            $('.delete_product').click(function(e) {
                e.preventDefault(); // Prevent default behavior

                var del_id = $(this).attr('id');
                var $ele = $(this).parent().parent();
                Swal.fire({
                    title: 'Are you Sure?',
                    text: "You want to delete the product?",
                    // showDenyButton: true,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#CD853F',
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // Create FormData for the status update
                        var formData = new FormData();
                        formData.append("delete_product", true); // Add status update parameter
                        formData.append("pr_id", del_id); // Assuming you pass the user ID

                        $.ajax({
                            type: 'POST',
                            url: '../user_process/user_product_process.php',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                console.log('Server response:', response);
                                var res = jQuery.parseJSON(response);

                                if (res.success == 100) {
                                    showMessageBox(res.title, res.message, 'success');
                                    setTimeout(function() {
                                        location.href = '/yeocha_main/admin/user_product.php';
                                    }, 6000);
                                } else {
                                    showMessageBox(res.title, res.message, 'warning');
                                }
                            },
                            error: function(error) {
                                showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                                console.log('error', error);
                            }
                        })
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info').then(function() {
                            location.reload();
                        });
                    }
                })
            });
        });
    });
</script>



<script type="text/javascript">
    <?php
    $material_list_query = "SELECT * FROM `material` ORDER BY `ma_id` DESC";
    $material_list_result = mysqli_query($conn, $material_list_query);

    if (mysqli_num_rows($material_list_result) > 0) {
        while ($material = mysqli_fetch_array($material_list_result)) { ?>

            $(document).ready(function() {

                $('#imagematerial<?php echo $material['ma_id']; ?>').on('change', function() {
                    $('#formmaterial<?php echo $material['ma_id']; ?>').submit();
                    console.log("Image material <?php echo $material['ma_id']; ?> changed", $('#imagematerial<?php echo $material['ma_id']; ?>').submit()); // Debugging line
                });

                $(document).on('submit', '#formmaterial<?php echo $material['ma_id']; ?>', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this); // Create a FormData object


                    $.ajax({
                        url: '../user_process/user_product_process.php',
                        type: 'POST',
                        data: formData,
                        contentType: false, // Important for file uploads
                        processData: false, // Important for file uploads
                        success: function(response) {
                            console.log('Response: ', response); // Log the response

                            var res = jQuery.parseJSON(response);

                            if (res.success == 100) {
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/yeocha_main/admin/user_product_material.php';
                                }, 8000);
                            } else {
                                showMessageBox(res.title, res.message, 'warning');
                                setTimeout(function() {
                                    location.href = '/yeocha_main/admin/user_product_material.php';
                                }, 8000);
                            }
                        },
                        error: function(error) {
                            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
                            console.log('error', error);
                        }
                    });
                });
            });
    <?php
        }
    }
    ?>
</script>