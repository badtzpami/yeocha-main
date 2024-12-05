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

                <a href="../admin/user_account.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>
                <button type="button" id="viewProdButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>View
                </button>

                <button type="button" id="ProductButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Item
                </button>

                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->


                <button type="button" id="addProductButton" class="btn add">
                    Add Items
                </button>
            </div>
        </div>
    </section>



    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="viewProductContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">View Products</h5>
                        <div class="table-responsive">
                            <!-- <form id="updateUserActiveAccount" method="post"> -->

                            <?php include_once '../user_data/view_products.php'; ?>

                            <!-- <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form> -->
                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="ProductContent">
                    <div class="card-body">
                        <h5 class="card-title">Products Data</h5>
                        <div class="table-responsive">

                            <?php include_once '../user_data/product_data.php'; ?>

                        </div>
                    </div>
                </div>

                <!-- <div class="card stretch-card" id="archiveProductContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Archive Data</h5>
                        <div class="table-responsive">
                            <form id="updateUserArchiveAccount" method="post">

                                <?php include_once '../user_data/product_archive_data.php'; ?>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div> -->





                <div class="card stretch-card" id="addProductContent" style="display: none;">
                    <div class="card-body">
                        <input type="button" id="add-product" class="btn add_account" value="+">

                        <div class="table-responsive">
                            <!-- add user -->

                            <h5 class="card-title">Add Product Data</h5>
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
                                <div class="w-100 d-flex justify-content-end"> 
                                    <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
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
            width: 300px !important;
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
        const addProduct = document.getElementById('add-product');
        const inputContainerProduct = document.getElementById('input-container-product');
        let productCounter = 0;

        addProduct.addEventListener('click', function() {
            productCounter++;
            const row = document.createElement('tr');

            const numberCell = document.createElement('td');
            numberCell.textContent = productCounter;
            row.appendChild(numberCell);

            const product_name = createInputField('product_name[]', 'Product Name');

            const category_nameSelect = createCategorySelect();
            const selling_price = createInputField('selling_price[]', 'Selling Price');
            const removeBtn = createRemoveProductButton(row);

            row.appendChild(createTableCell(product_name));
            row.appendChild(createTableCell(category_nameSelect));
            row.appendChild(createTableCell(selling_price));
            row.appendChild(createTableCell(removeBtn));

            inputContainerProduct.appendChild(row);
            updateProductRowNumbers();
        });

        function createRemoveProductButton(row) {
            const btnProduct = document.createElement('button');
            btnProduct.textContent = 'Remove';
            btnProduct.classList.add('remove-btn');
            btnProduct.addEventListener('click', function() {
                inputContainerProduct.removeChild(row);
                updateRowNumbers();
            });
            return btnProduct;
        }


        function createCategorySelect() {
            const select = document.createElement('select');
            select.name = 'category_name[]';
            select.classList.add('input-field');

            // Initialize the options array
            const categoryOptions = [{
                    id: '',
                    name: 'Choose Category'
                } // Default option
                <?php
                $category_query = "SELECT * FROM `category` ORDER BY `ca_id` DESC";
                $category_list = mysqli_query($conn, $category_query);

                if (mysqli_num_rows($category_list) > 0) {
                    while ($row = mysqli_fetch_array($category_list)) {
                        // Echo the ca_id and category_name as a JSON object
                        echo ", { id: '" . $row['ca_id'] . "', name: '" . addslashes($row['category_name']) . "' }";
                    }
                }
                ?>
            ];

            // Populate the select options
            categoryOptions.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id; // Set ca_id as the value
                option.textContent = category.name.charAt(0).toUpperCase() + category.name.slice(1); // Set category_name as text
                select.appendChild(option);
            });

            return select;
        }



        // Function to update row numbers and check for records
        function updateProductRowNumbers() {
            const rows = inputContainerProduct.getElementsByTagName('tr');

            // Update row numbers
            for (let i = 0; i < rows.length; i++) {
                rows[i].firstChild.textContent = i + 1; // Update the first cell with the correct number
            }

        }


        $(document).ready(function() {
            // AJAX form submission (for products)
            $(document).on('submit', '#addUserProduct', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("valid_product", true);

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
                                location.href = '/admin/user_product.php';
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
            $(document).on('submit', '#updateUserProduct', function(e) {
                e.preventDefault();

                // Create a new FormData object
                var formData = new FormData(this);
                formData.append("update_product", true);

                $.ajax({
                    type: "POST",
                    url: "../user_process/user_product_process.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response2) {
                        console.log('Server response2:', response2);
                        var res = jQuery.parseJSON(response2);

                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/admin/user_product.php';
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
                                        location.href = '/admin/user_product.php';
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
    $product_list_query = "SELECT * FROM `product` ORDER BY `pr_id` DESC";
    $product_list_result = mysqli_query($conn, $product_list_query);

    if (mysqli_num_rows($product_list_result) > 0) {
        while ($product = mysqli_fetch_array($product_list_result)) { ?>

            $(document).ready(function() {

                $('#imageproduct<?php echo $product['pr_id']; ?>').on('change', function() {
                    $('#formproduct<?php echo $product['pr_id']; ?>').submit();
                    console.log("Image product <?php echo $product['pr_id']; ?> changed", $('#imageproduct<?php echo $product['pr_id']; ?>').submit()); // Debugging line
                });

                $(document).on('submit', '#formproduct<?php echo $product['pr_id']; ?>', function(e) {
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
                                    location.href = '/admin/user_product.php';
                                }, 8000);
                            } else {
                                showMessageBox(res.title, res.message, 'warning');
                                setTimeout(function() {
                                    location.href = '/admin/user_product.php';
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