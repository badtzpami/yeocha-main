<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .button_1 {
            /* Button #1 from SimpleCSSButtons.com */
            color: #fff;
            /* Text Color */
            background-color: #0C0A4A;
            /* Background Color */
            width: 200px;
            /* Button Width */
            transition: 0.5s;
            /* Hover Transition Time */
            border: .2vmax solid rgb(47, 36, 148);
            /* Border Width & Color */
            padding: 10px 30px;
            /* Padding */
            text-decoration: none;
            /* Text Decoration */
            border-radius: 101vmax;
            /* Border Roundness */
            cursor: pointer;
            /* Cursor */
        }

        .button_1:hover {
            color: #FFFFFF;
            /* Text Color */
            background-color: #398AB9;
            /* Background Color */
        }

        /* General Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            /* Ensures borders don't double */
            font-family: 'Arial', sans-serif;
            background-color: #fff;
            /* White background for the table */
        }


        .table thead th {
            width: 10%;
            padding: 10px;
            font-size: 14px;
            font-weight: 800;
            background: #0C0A4A;
            color: #fff;
            text-align: center;
            padding: 0 30px;
            border-bottom: 2px solid #ebedf2;
        }

        .table tbody td {
            width: 16%;
            font-size: 14px;
            font-weight: 800;
            background: #f4f4f4;
            color: #000;
            border-bottom: 2px solid #ebedf2;
        }

        /* Table Header and Body Styling - Ensure equal styling for th and td */

        /* Table Header Styling */
        thead {
            background-color: #f4f4f4;
            /* Light gray background for header */
        }




        /* Checkbox Styling */
        .all_checkbox input[type="checkbox"] {
            cursor: pointer;
            /* Make the checkbox clickable */
            margin-right: 10px;
            /* Space between checkbox and label */
        }

        /* Hover Effect for Table Headers */
        thead th:hover {
            background-color: #e2e2e2;
            /* Slight darken effect on hover */
            cursor: pointer;
            /* Pointer cursor to indicate interactivity */
            transition: background-color 0.3s ease;
            /* Smooth transition for hover */
        }

        /* Responsive Design - Stack header elements vertically on small screens */
        @media (max-width: 768px) {

            th,
            td {
                padding: 10px 15px;
                /* Reduce padding on smaller screens */
                font-size: 12px;
                /* Slightly smaller font size on smaller screens */
            }

            th,
            td {
                text-align: center;
                /* Center-align text on small screens for consistency */
            }

            .all_checkbox input[type="checkbox"] {
                margin: 0;
                /* Remove margin on smaller screens */
            }
        }

        input[type="checkbox"] {
            display: flex;
            cursor: pointer;
            align-items: top;
            margin: 10px;
            width: 20px;
            height: 20px;
        }

        .menu_delete {
            display: inline-block;
            width: 100px;
            padding: 12px 20px;
            margin: 0 25px;
            font-size: 13px;
            color: #fff;
            background-color: #e74c3c;
            /* Red background */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .total_amount,
        .input-qty {
            display: inline-block;
            width: 200px;
            font-size: 12px;
            color: #000;
            background-color: #e74c3c;
            /* Red background */
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body>

    <div class="bg-white" style="width: 100%; height: auto;">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <div class="p-3 text-uppercase all_checkbox">
                                <input type="checkbox" onclick="select_one()" id="select_one"></input>
                            </div>
                        </th>
                        <th>
                            <div class="p-3 px-3 text-uppercase">Product</div>
                        </th>
                        <th>
                            <div class="py-3 px-3 text-uppercase">Quantity</div>
                        </th>
                        <th>
                            <div class="py-3 text-uppercase">Price</div>
                        </th>
                        <th>
                            <div class="py-3 px-3 text-uppercase">Total</div>
                        </th>
                        <th>
                            <div class="py-3 text-uppercase">Remove</div>
                        </th>
                    </tr>
                </thead>
            </table>

        </div>

        <form method="post" action="../user_data/cart_checkout.php" id="form">
            <?php
            include '../config/connect.php';

            // Get user details (for the store)
            $sql_user = "SELECT ca.ct_id, us.user_id, us.role, us.store FROM users us LEFT JOIN cart ca ON us.user_id = ca.user_id WHERE us.role = 'Supplier' GROUP BY us.user_id ";
            $res_user = mysqli_query($conn, $sql_user);

            if (mysqli_num_rows($res_user) > 0) {
                while ($users = mysqli_fetch_array($res_user)) {
                    if (!empty($users['ct_id'])) {
            ?>
                        <div class="row" style="border-bottom: solid 25px #eee;">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <!-- Display user store -->
                                            <tr>
                                                <td class="select_one_all">
                                                    <input type="checkbox" onclick="select_all<?php echo $users['user_id'] ?>()" id="delete<?php echo $users['user_id'] ?>" style="margin: 0 20px;" />
                                                    <?php echo $users["store"] ?>
                                                </td>
                                            </tr>

                                            <?php
                                            // Iterate through cart items
                                            $sql_material = "SELECT ca.ct_id, ca.sell_price, ca.quantity, sm.sm_id, sm.material_name, sm.type, sm.stock, sm.selling_price, sm.image, us.user_id, us.role, us.store 
                                    FROM cart ca LEFT JOIN supplier_material sm ON ca.sm_id = sm.sm_id LEFT JOIN users us ON us.user_id = sm.user_id 
                                    WHERE us.user_id = '" . $users["user_id"] . "' ORDER BY us.user_id DESC";
                                            $res_material = mysqli_query($conn, $sql_material);

                                            if (mysqli_num_rows($res_material) > 0) {
                                                while ($materials = mysqli_fetch_array($res_material)) {
                                            ?>
                                                    <tr id="box<?php echo $materials['user_id'] ?>" style="border-bottom: solid 2px #eee;">
                                                        <td class="border-0 align-middle" >
                                                            <input type="checkbox" class="check" id="<?php echo $materials['ct_id'] ?>" name="checkbox<?php echo $materials['ct_id'] ?>[]" value="<?= $materials['material_name']; ?>" />
                                                        </td>
                                                        <td width="25%">
                                                            <center><img src="../assets/images/material_images/<?php echo $materials['image']; ?>" alt="" width="70" class="img-fluid rounded shadow-sm"></center>
                                                            <center><?= $materials['material_name']; ?></center>
                                                        </td>
                                                        <td class="product_data border-0 align-middle">
                                                            <div class="input-group">
                                                                <!-- Decrement button -->
                                                                <button class="input-group-text bg-white decrement-btn">-</button>


                                                                <!-- Quantity input field -->
                                                                <input type="text" name="prod_qty<?php echo $materials['ct_id'] ?>[]" class="form-control text-center input-qty bg-white" style="width:70px ; font-size:1rem; padding: 0;" value="<?php echo $materials['quantity'] ?>">

                                                                <!-- Increment button -->
                                                                <button class="input-group-text bg-white increment-btn">+</button>
                                                                <input type="hidden" class="form-control text-center input-stock bg-white" style="width:220px; font-size:1.5rem;" value="<?= $materials['stock'] ?>" disabled>

                                                            </div>
                                                        </td>
                                                        <td width="25%">
                                                            <center>P<?php echo $materials['sell_price']; ?></center>
                                                        </td>
                                                        <td width="25%">
                                                            <center>P<input type="text" class="form-control text-center total_amount bg-white" value="<?php echo $new = $materials['sell_price'] * $materials['quantity']; ?>" disabled style="width:120px; font-size:1.2rem; padding: 0 ;"></center>
                                                        </td>
                                                        <td class="border-0 align-middle">
                                                            <a class="btn btn-sm m-b-10 menu_delete newlink_delete" data-role="update" id="<?php echo $materials['ct_id']; ?>">DELETE</a>
                                                        </td>
                                                        <input type="hidden" name="prodid<?php echo $materials['ct_id'] ?>[]" value="<?= $materials['sm_id']; ?>">
                                                        <input type="hidden" name="prodname<?php echo $materials['ct_id'] ?>[]" value="<?= $materials['material_name']; ?>">
                                                        <input type="hidden" name="prod_price<?php echo $materials['ct_id'] ?>[]" value="<?= $materials['sell_price']; ?>">
                                                        <input type="hidden" name="stock<?php echo $materials['ct_id'] ?>[]" style="width:220px; font-size:1.5rem;" value="<?= $materials['stock'] ?>" disabled>

                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                <?php
                    }
                }
            } else { ?>
                <div style="align-items:center; display:flex; margin-top:7%; justify-content: center;">
                    <div class="row">
                        <img src="images/background/checkout.svg" alt="" style="width:500px; height: 500px;">
                    </div><br>
                    <div class="row">
                        Your shopping cart is empty..
                        <a href="menu.php" class="button_1">Go Shopping now</a>
                    </div>
                </div>
            <?php } ?>
            <div class="button-container">
                <div class="select_all2">
                    <input type="checkbox" id="select_two">
                    <label for="select_two">(<span id="checkedCount">0</span>)</label>
                </div>
                <div class="all_added_price">
                    <p>Total: $<input type="text" name="price" id="price" disabled /></p>
                </div>
                <div class="delete_all">
                    <a href="javascript:void(0)" class="link_delete" onclick="delete_all()">Delete</a>
                </div>
                <!-- Move the submit button inside the form -->
                <div class="reset-button">
                    <input type="submit" name="submit" id="save-btn" class="physical_inventory_button" value="Check Out">
                </div>
            </div>

        </form>

    </div>

</body>

</html>


<script>
    $(document).ready(function() {
        // Function to count all checked checkboxes inside the specific <td class="border-0 align-middle">
        function countChecked() {
            // Count checkboxes inside <td> elements within <tr> inside a specific table (e.g., .myTable)
            var checkedCount = $("tr td input[type='checkbox'].check:checked").length;
            $("#checkedCount").text(checkedCount); // Update the text of the element with ID "checkedCount"
        }

        // Select all checkboxes inside the specific <td> when the 'select all' checkbox inside the same section is clicked
        $("#select_one").click(function() {
            var isChecked = $(this).prop("checked");
            $("tr td input[type='checkbox']").prop("checked", isChecked); // Check/uncheck only the checkboxes inside the <td>
            countChecked(); // Call countChecked function to update the count of checked items inside that <td>
            calculateSum(); // Optionally call your sum calculation
        });
        $("#select_two").click(function() {
            var isChecked = $(this).prop("checked");
            $("td input[type='checkbox']").prop("checked", isChecked); // Check/uncheck only the checkboxes inside the <td>
            countChecked(); // Call countChecked function to update the count of checked items inside that <td>
            calculateSum(); // Optionally call your sum calculation
        });

        // Handle individual checkbox clicks inside the specific <td>
        $("td input[type='checkbox']").change(function() {
            countChecked(); // Call countChecked whenever a checkbox is clicked inside the <td>
            calculateSum(); // Optionally call your sum calculation
        });

    });
</script>



<script>
    // This function calculates the total sum of the cart

    function calculateSum() {
        var sumTotal = 0;

        // Iterate over each row in the tbody
        $('tbody tr').each(function() {
            var $tr = $(this);

            // Get the columns for the current row
            var $columns = $tr.find('td');

            // Get price from the 4th column (which contains the price text "P100.00")
            var priceText = $columns.eq(3).text().trim();
            if (priceText.includes('P')) {
                var $Cost = parseFloat(priceText.split('P')[1].trim()); // Extract the numeric price

                // Get the quantity from the input field (quantity input field with class .input-qty)
                var $quantity = $tr.find('input[type="text"]').val();
                var quantity = parseFloat($quantity); // Parse the quantity to a number

                // Calculate the total for this row
                var rowTotal = quantity * $Cost;

                // Set the total amount for this row in the .total_amount field
                $tr.find('.total_amount').val(rowTotal.toFixed(2)); // Update the total amount field with the calculated value

                // Add this row's total to the overall sum
                sumTotal += rowTotal;
            }
        });

        // Update the total sum on the page (assuming there's an element with ID 'price' to show the total)
        $("#price").val(sumTotal.toFixed(2)); // Update the total amount in the input field with ID 'price'
    }


    // Select all checkboxes when #select_two is clicked
    $("#select_two").click(function() {
        var isChecked = $(this).prop("checked");
        $("input[type='checkbox']").prop("checked", isChecked);
        calculateSum(); // Call the calculateSum function
    });
</script>

<script>
    // Handle "select all" checkbox behavior (first select all checkbox)
    $("#select_one").click(function() {
        var isChecked = $(this).prop("checked");
        $("input[type='checkbox']").prop("checked", isChecked);
        calculateSum();
    });

    // Handle quantity increment and decrement buttons
    // Handle quantity increment button click
    $('.increment-btn').click(function(e) {
        e.preventDefault();
        console.log("Increment button clicked!"); // Debugging line

        // Get the quantity input field within the same product_data container
        var qtyInput = $(this).closest('.input-group').find('.input-qty');

        // Get the stock value (ensure it's a valid number)
        var stock = parseInt($(this).closest('.input-group').find('.input-stock').val(), 10) || 0;

        // Get the current quantity value (ensure it's a valid number)
        var value = parseInt(qtyInput.val(), 10) || 0;

        // Check if quantity is less than stock before incrementing
        if (value < stock) {
            value++; // Increment the value
            qtyInput.val(value); // Update the quantity input
        } else {
            // Optionally, you can show a message or do something else if stock is exceeded
            showMessageBox('Invalid Quantity!', 'Cannot exceed stock limit.', 'warning');

        }

        // Recalculate the total sum (if needed)
        calculateSum();
    });

    // Handle quantity decrement button click
    $('.decrement-btn').click(function(e) {
        e.preventDefault();
        console.log("Decrement button clicked!"); // Debugging line

        // Get the quantity input field within the same product_data container
        var qtyInput = $(this).closest('.input-group').find('.input-qty');

        // Get the current quantity value (ensure it's a valid number)
        var value = parseInt(qtyInput.val(), 10) || 0;

        // Prevent the quantity from going below 1
        if (value > 1) {
            value--; // Decrement the value
            qtyInput.val(value); // Update the quantity input
        }

        // Recalculate the total sum (if needed)
        calculateSum();
    });
</script>


<script>
    function select_one() {
        if (jQuery('#select_one').prop("checked")) {
            jQuery('input[type=checkbox]').each(function() {
                jQuery('#' + this.id).prop('checked', true);
            });
        } else {
            jQuery('input[type=checkbox]').each(function() {
                jQuery('#' + this.id).prop('checked', false);
            });
        }
    }





    // Delete 
    $(document).ready(function() {
        $('.menu_delete').click(function() {
            var del_id = $(this).attr('id');
            var $ele = $(this).parent().parent();
            Swal.fire({
                title: 'Are you Sure?',
                text: "You won't be able to recover this file!",
                // showDenyButton: true,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#bb2d3b',
                confirmButtonText: 'Yes, Delete it!',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '../user_process/cart_delete.php',
                        data: {
                            del_id: del_id
                        },
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            console.log(response);
                            if (res.success == 100) {
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/admin/user_cart.php';
                                }, 6000);
                            } else {
                                showMessageBox(res.title, res.message, 'warning');
                            }
                        },
                        error: function(error) {
                            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
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





    function delete_all() {
        Swal.fire({
            title: 'Are you Sure?',
            text: "You won't be able to recover this file!",
            // showDenyButton: true,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#bb2d3b',
            confirmButtonText: 'Yes, Delete it!',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                jQuery.ajax({
                    url: '../user_process/cart_delete_all.php',
                    type: 'post',
                    data: jQuery('#form').serialize(),
                    success: function(result) {
                        var res = jQuery.parseJSON(result);

                        jQuery('input[type=checkbox]').each(function() {
                            if (jQuery('#' + this.id).prop("checked")) {
                                jQuery('#box' + this.id).remove();
                                showMessageBox(res.title, res.message, 'success');
                                setTimeout(function() {
                                    location.href = '/admin/user_cart.php';
                                }, 6000);
                            } else {
                                showMessageBox(res.title, res.message, 'success');
                            }
                        })
                    }
                });
            }
        });
    }
</script>



<script>
    <?php

    // Get user details (for the store)
    $sql_user = "SELECT ca.ct_id, us.user_id, us.role, us.store FROM `users` us LEFT JOIN `cart` ca ON us.user_id = ca.user_id WHERE us.role = 'Supplier' GROUP BY us.user_id ";
    $res_user = mysqli_query($conn, $sql_user);




    if (mysqli_num_rows($res_user) > 0) {
        while ($users = mysqli_fetch_array($res_user)) {  ?>

            function select_all<?php echo $users['user_id']; ?>() {

                <?php if (!empty($users['ct_id'])) {

                    $sql_material = "SELECT ca.ct_id, ca.sell_price, ca.quantity, sm.sm_id, sm.material_name, sm.type, sm.stock, sm.selling_price, sm.image, us.user_id, us.role, us.store 
          FROM `cart` ca LEFT JOIN `supplier_material` sm ON ca.sm_id = sm.sm_id LEFT JOIN `users` us ON us.user_id = sm.user_id 
          WHERE us.user_id = '" . $users["user_id"] . "' ORDER BY us.user_id DESC";
                    $res_material = mysqli_query($conn, $sql_material);

                    if (mysqli_num_rows($res_material) > 0) {
                        while ($materials = mysqli_fetch_array($res_material)) { ?>
                            var items<?php echo $materials['ct_id']; ?> = document.getElementsByName('checkbox<?php echo $materials['ct_id']; ?>[]');
                            if (document.getElementById('delete<?php echo $materials['user_id']; ?>').checked) {
                                items<?php echo $materials['ct_id']; ?>.forEach(function(item) {
                                    item.checked = true;
                                });
                            } else {
                                items<?php echo $materials['ct_id']; ?>.forEach(function(item) {
                                    item.checked = false;
                                });
                            }
                <?php }
                    }
                } ?>

            }

    <?php }
    } ?>
</script>