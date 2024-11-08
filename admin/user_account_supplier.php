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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Supplier Table</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">User Supplier Account</li>
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

                <button type="button" id="activeButton" class="btn active-button">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Active
                </button>
                <button type="button" id="archiveButton" class="btn">
                    <i class="bi bi-refresh btn-icon-prepend"></i>Archive
                </button>

                <button type="button" class="btn print" onclick="printUserTable()">
                    <i class="mdi mdi-print btn-icon-prepend"></i>Print
                </button>

                <!-- Hidden iframe that loads user_print.php -->
                <!-- <iframe id="userPrintIframe" src="../getdata/product_data_query.php" style="display:none;"></iframe> -->

                <button type="button" id="actionButton" class="btn add">
                    Add Users
                </button>
            </div>
        </div>
    </section>



    <section class="section">
        <div class="row">
            <col-lg-12>

                <div class="card stretch-card" id="activeContent">
                    <div class="card-body">
                        <h5 class="card-title">Active Data</h5>
                        <div class="table-responsive">
                            <form id="updateUserActiveAccount" method="post">

                                <?php include_once '../user_data/user_active_data_supplier.php'; ?>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card stretch-card" id="archiveContent" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Archive Data</h5>
                        <div class="table-responsive">
                            <form id="updateUserArchiveAccount" method="post">

                                <?php include_once '../user_data/user_archive_data_supplier.php'; ?>

                                <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card stretch-card" id="addRowContent" style="display: none;">
                    <div class="card-body">
                        <input type="button" id="add-btn" class="btn add_account" value="+">

                        <div class="table-responsive">
                            <!-- add user -->

                            <h5 class="card-title">Add Data</h5>
                            <form id="addUserAccount" method="post">

                                <table class="table table-hover" id="table_add">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User ID <span style="color:red">*</span></th>
                                            <th>Store Name<span style="color:red">*</span></th>
                                            <th>Position <span style="color:red">*</span></th>
                                            <th>First Name <span style="color:red">*</span></th>
                                            <th>Last Name <span style="color:red">*</span></th>
                                            <th>Email <span style="color:red">*</span></th>
                                            <th>Phone <span style="color:red">*</span></th>
                                            <th>Address <span style="color:red">*</span></th>
                                            <th>Start Date <span style="color:red">*</span></th>
                                            <th>Birthday <span style="color:red">*</span></th>
                                            <th>Age <span style="color:red">*</span></th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody id="input-container">



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



    <!-- Change Password Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="
    
    background-color: rgba(0,0,0,0.7);
    color: #fff;
    text-align: center;
    /* padding: 0 30px; */
    border-bottom: 2px solid #ebedf2;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header text-light" style="vertical-align: bottom;
    padding: 10px;
    font-weight: 800;
    background: #535e70;
    font-size: 14px;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">Update User Password</h5>
                    <button type="button" class="close mr-1" style="position: absolute; justify-content:right; rop:0; right:25px; padding-top: 22px;color:#fff; background: transparent; border:none;" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <form id="userPassword">
                    <div class="modal-body ml-5 mr-5 mt-4">

                        <div class="mb-1">
                            <h6 style="position:absolute; justify-content: left; color:#000; margin: 20px 0;">Admin Password</h6>
                            <div class="row">
                                <div class="col-md-6 mt-5">
                                    <input type="text" name="admin_password" placeholder="Enter Current Admin Password" class="form-control" />
                                </div>
                            </div>
                            <h6 style="position:absolute; justify-content: left; color:#000; margin: 20px 0;">User Password</h6>
                            <input type="hidden" name="u_id" id="u_id">

                            <input type="hidden" name="p_user_id" value="<?= $sessionId ?>">

                            <div class="row">
                                <div class="col-md-6 mt-5">
                                    <input type="text" name="user_password" id="user_password" placeholder="Enter New User Password" class="form-control" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main><!-- End #main -->



<?php include "../include/user_footer.php"; ?>
<?php include "../include/user_bottom.php"; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const style = document.createElement('style');
        style.textContent = `
            .input-field {
                width: 150px;
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

        // Append the style element to the head
        document.head.appendChild(style);

        const addBtn = document.getElementById('add-btn');
        const inputContainer = document.getElementById('input-container');
        let counter = 0;

        addBtn.addEventListener('click', function() {
            counter++;

            // Create a new table row
            const row = document.createElement('tr');

            // Create and append a number cell
            const numberCell = document.createElement('td');
            numberCell.textContent = counter; // Set the cell's text to the current count
            row.appendChild(numberCell); // Append the number cell to the row

            // Create and append input fields inside <td> elements
            const username = createInputField('username[]', 'User ID');
            const store = createInputField('store[]', 'Store Name');

            const firstname = createInputField('firstname[]', 'First Name');
            const lastname = createInputField('lastname[]', 'Last Name');
            const email = createInputField('email[]', 'Email');
            const phoneCell = createPhoneCell(); // Create a cell for phone inputs
            const address = createInputField('address[]', 'Address');
            const start_date = createStartDateCell(); // Create a cell for phone inputs
            const birthday = createBirthdayCell(); // Create a cell for phone inputs

            // const birthday = createInputField('birthday[]', 'Birthday');
            const age = createInputField('age[]', 'age');

            // Create the role select dropdown
            const roleSelect = document.createElement('select');
            roleSelect.name = 'role[]'; // Set name with []
            roleSelect.classList.add('input-field');
            const roles = ['Choose Role', 'Supplier'];
            roles.forEach(role => {
                const option = document.createElement('option');
                option.value = role;
                option.textContent = role.charAt(0).toUpperCase() + role.slice(1); // Capitalize first letter
                roleSelect.appendChild(option);
            });

            // Create the remove button
            const removeBtn = document.createElement('button');
            removeBtn.textContent = 'Remove';
            removeBtn.classList.add('remove-btn');
            removeBtn.addEventListener('click', function() {
                inputContainer.removeChild(row);
                updateRowNumbers(); // Update row numbers after removal
            });

            // Append inputs and select to the row in separate <td> elements
            row.appendChild(createTableCell(username));
            row.appendChild(createTableCell(store));

            row.appendChild(createTableCell(roleSelect));

            row.appendChild(createTableCell(firstname));
            row.appendChild(createTableCell(lastname));
            row.appendChild(createTableCell(email));
            row.appendChild(phoneCell); // Append phone cell
            row.appendChild(createTableCell(address));
            row.appendChild(start_date);
            row.appendChild(birthday);
            row.appendChild(createTableCell(age));
            row.appendChild(createTableCell(removeBtn));

            // Append the row to the input container
            inputContainer.appendChild(row);
        });

        // Helper function to create input fields
        function createInputField(name, placeholder) {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = name; // Now includes []
            input.placeholder = placeholder;
            input.classList.add('input-field');
            return input;
        }

        // Helper function to create phone cell
        function createPhoneCell() {
            const div = document.createElement('div');
            div.style.display = 'flex'; // Use flexbox to arrange inputs side by side

            const phone1 = createInputField('phone1[]', '+639');
            const phone2 = createInputField('phone2[]', '123456789');
            phone1.value = '+639'; // Set name with []
            phone1.readOnly = 'true'; // Set name with []

            div.appendChild(phone1);
            div.appendChild(phone2);
            const td = document.createElement('td');
            td.appendChild(div);
            return td;
        }

        // Helper function to create phone cell
        function createBirthdayCell() {
            const div = document.createElement('div');
            div.style.display = 'flex'; // Use flexbox to arrange inputs side by side

            const birthday = createInputField('birthday[]', 'dd-mm-yyyy');
            birthday.type = 'date'; // Set name with []
            div.appendChild(birthday);
            const td = document.createElement('td');
            td.appendChild(div);
            return td;
        }

        // Helper function to create phone cell
        function createStartDateCell() {
            const div = document.createElement('div');
            div.style.display = 'flex'; // Use flexbox to arrange inputs side by side

            const start_date = createInputField('start_date[]', 'dd-mm-yyyy');
            start_date.type = 'date'; // Set name with []
            div.appendChild(start_date);
            const td = document.createElement('td');
            td.appendChild(div);
            return td;
        }

        // Helper function to create <td> elements
        function createTableCell(element) {
            const td = document.createElement('td');
            td.appendChild(element);
            return td;
        }

        // Function to update row numbers and check for records
        function updateRowNumbers() {
            const rows = inputContainer.getElementsByTagName('tr');
            const cols = inputContainer.getElementsByTagName('th');

            // Update row numbers if there are rows present
            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header
                rows[i].firstChild.textContent = i; // Update the first cell with the correct number
            }

            // Check if there are any data rows
            if (rows.length <= 1) { // Only the header row present
                row.appendChild('No records found.');
            } else {
                row.appendChild('dsmn');
            }
        }

    });



    $(document).ready(function() {
        $(document).on('submit', '#addUserAccount', function(e) {
            e.preventDefault();

            // Create a new FormData object
            var formData = new FormData(this); // Pass the form element directly
            formData.append("valid_account", true);

            $.ajax({
                type: "POST",
                url: "../user_process/user_account_process.php",
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from transforming the data into a query string
                success: function(response) {
                    console.log('Server response:', response); // Log the response
                    var res = jQuery.parseJSON(response);

                    if (res.success == 100) {
                        showMessageBox(res.title, res.message, 'success');
                        setTimeout(function() {
                            location.href = '/yeocha_main/admin/user_account_supplier.php';
                        }, 6000);
                    } else if (res.success == 400) {
                        showMessageBox(res.title, res.message, 'warning');

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
        // Handle form submission for #updateUserArchiveAccount
        $(document).on('submit', '#updateUserArchiveAccount', function(e) {
            e.preventDefault();

            // Create a new FormData object
            var formData = new FormData(this);
            formData.append("update_account", true);

            $.ajax({
                type: "POST",
                url: "../user_process/user_account_process.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Server response:', response);
                    var res = jQuery.parseJSON(response);

                    if (res.success == 100) {
                        showMessageBox(res.title, res.message, 'success');
                        setTimeout(function() {
                            location.href = '/yeocha_main/admin/user_account_supplier.php';
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

        $(document).ready(function() {
            // Handle form submission for #updateUserArchiveAccount
            $(document).on('submit', '#updateUserActiveAccount', function(e) {
                e.preventDefault();

                // Create a new FormData object
                var formData = new FormData(this);
                formData.append("update_account", true);

                $.ajax({
                    type: "POST",
                    url: "../user_process/user_account_process.php",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log('Server response:', response);
                        var res = jQuery.parseJSON(response);

                        if (res.success == 100) {
                            showMessageBox(res.title, res.message, 'success');
                            setTimeout(function() {
                                location.href = '/yeocha_main/admin/user_account_supplier.php';
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


        // Set Status to INACTIVE for .account_archive
        $('.account_archive').click(function(e) {
            e.preventDefault(); // Prevent default behavior
            var upd_arch = $(this).attr('id');
            var $ele = $(this).parent().parent();

            Swal.fire({
                title: 'Are you Sure?',
                text: "You want to activate the user status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CD853F',
                confirmButtonText: 'Yes, Update Status',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create FormData for the status update
                    var formData = new FormData();
                    formData.append("update_status", true); // Add status update parameter
                    formData.append("user_id", upd_arch); // Assuming you pass the user ID

                    $.ajax({
                        type: "POST",
                        url: "../user_process/user_account_process.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log('Server response:', response);
                            var res = jQuery.parseJSON(response);

                            if (res.success == 100) {
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/yeocha_main/admin/user_account_supplier.php';
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
            });
        });

        $(document).on('submit', '#userPassword', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);
            formData.append("update_password", true); // Indicates a password update

            $.ajax({
                type: "POST",
                url: "../user_process/user_account_process.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Server response:', response);
                    if (!response) {
                        showMessageBox("Error", "Received an empty response from the server.", "error");
                        return;
                    }

                    try {
                        var res = jQuery.parseJSON(response);
                        // Your existing handling logic...
                    } catch (e) {
                        showMessageBox("Error", "Invalid response format from the server.", "error");
                        console.log('Parsing error:', e);
                    }
                    if (res.success == 100) {
                        showMessageBox(res.title, res.message, 'success');
                        setTimeout(function() {
                            location.href = '/yeocha_main/admin/user_account_supplier.php';
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





        $(document).on('click', '.change_pass', function(event) {
            event.preventDefault(); // Prevent the default action of the button

            var edit_user_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "../user_data/user_pass_data.php?edit_user_id=" + edit_user_id,
                success: function(response) {
                    var res = jQuery.parseJSON(response);
                    if (res.status == 200) {
                        $('#u_id').val(res.data.user_id);
                        $('#user_username').val(res.data.username);
                        // Uncomment the following line if you want to handle password hashing
                        // var hashedPassword = sha256(res.data.password);
                        // $('#user_password').val(res.data.password);
                    }
                    // $('#memo').html(data);
                }
            });
        });

    });
</script>