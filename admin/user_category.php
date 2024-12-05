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





    /* ///////////// */



    
    h2 {
            margin-top: 20px;
        }

        .materials {
            display: none;
            margin-top: 10px;
        }

        .chevron-icon {
            justify-content: right;
            right: 0;
            /* Space between chevron and text */
            transition: transform 0.3s;
            /* Smooth transition for rotation */
        }

        .chevron-title {
            justify-content: left;
            margin-left: 10px;
            left: 0;
            /* Space between chevron and text */
            transition: transform 0.3s;
            /* Smooth transition for rotation */
        }

        .card-products {
            width: 100%;

            display: flex;
            justify-content: space-between;
            /* Distributes space between title and icon */
            align-items: center;
            /* Centers items vertically */
            /* Ensures the button takes full width */
        }

        div.collapse {
            width: 100%;
            height: 55px;
            padding: 10px;
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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Category Table</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">User Category Account</li>
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

                <a href="../admin/user_category.php">
                    <button type="button" class="btn">
                        <i class="bi bi-refresh btn-icon-prepend"></i>Refresh
                    </button>
                </a>
                <button type="button" id="viewCategoryButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>View
                </button>
                <button type="button" id="categoryButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Category
                </button>
                <!-- <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button> -->
                
                <button type="button" class="btn print">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->

                <button type="button" id="addCategoryButton" class="btn add">
                    Add Category
                </button>

            </div>
        </div>
    </section>



    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="viewCategoryContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">View Products</h5>
                        <div class="table-responsive">

                            <?php include_once '../user_data/view_products.php'; ?>

                          
                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="categoryContent">
                    <div class="card-body">
                        <h5 class="card-title">Category Data</h5>
                        <div class="table-responsive">
                            <form id="updateUserCategory" method="post">

                                <?php include_once '../user_data/category_data.php'; ?>
                                <div class="w-100 d-flex justify-content-end">
                                    <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card stretch-card" id="addCategoryContent" style="display: none;">
                    <div class="card-body">
                        <input type="button" id="add-category" class="btn add_account" value="+">

                        <div class="table-responsive">
                            <!-- add user -->

                            <h5 class="card-title">Add Category Data</h5>
                            <form id="addProductCategory" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Category Name <span style="color:red">*</span></th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="input-container-category">



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
            
        .counter {
            width: 100px !important;
            font-size: 12px;
        }
    `;

        document.head.appendChild(style);

        const addCategory = document.getElementById('add-category');
        const inputContainer = document.getElementById('input-container-category');
        let counter = 0;

        addCategory.addEventListener('click', function() {
            counter++;
            const row = document.createElement('tr');

            const numberCell = document.createElement('td');
            numberCell.textContent = counter;
            numberCell.classList = 'counter';
            row.appendChild(numberCell);

            const category_name = createInputField('category_name[]', 'Category Name');
            const removeBtn = createRemoveButton(row);

            row.appendChild(createTableCell(category_name));
            row.appendChild(createTableCell(removeBtn));

            inputContainer.appendChild(row);
            updateRowNumbers();
        });

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

        function createRemoveButton(row) {
            const btn = document.createElement('button');
            btn.textContent = 'Remove';
            btn.classList.add('remove-btn');
            btn.addEventListener('click', function() {
                inputContainer.removeChild(row);
                updateRowNumbers();
            });
            return btn;
        }




        // Function to update row numbers and check for records
        function updateProductRowNumbers() {
            const rows = inputContainerProduct.getElementsByTagName('tr');

            // Update row numbers
            for (let i = 0; i < rows.length; i++) {
                rows[i].firstChild.textContent = i + 1; // Update the first cell with the correct number
            }

        }


        // AJAX form submission (for categories)
        $(document).ready(function() {
            $(document).on('submit', '#addProductCategory', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append("valid_category", true);

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
                                location.href = '/admin/user_category.php';
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



        // Update Category
        $(document).ready(function() {
            // Handle form submission for #updateUserCategory
            $(document).on('submit', '#updateUserCategory', function(e) {
                e.preventDefault();

                // Create a new FormData object
                var formData = new FormData(this);
                formData.append("update_category", true);

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
                                location.href = '/admin/user_category.php';
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
            $('.delete_category').click(function(e) {
                e.preventDefault(); // Prevent default behavior

                var del_id = $(this).attr('id');
                var $ele = $(this).parent().parent();
                Swal.fire({
                    title: 'Are you Sure?',
                    text: "You want to delete the user status?",
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
                        formData.append("delete_category", true); // Add status update parameter
                        formData.append("ca_id", del_id); // Assuming you pass the user ID

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
                                        location.href = '/admin/user_category.php';
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