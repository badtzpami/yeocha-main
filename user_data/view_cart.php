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

        .table {
            width: auto;
            /* Adjusted: Not 100% width */
            margin-bottom: 1rem;
            color: #212529;
            display: block !important;
            max-height: 100% !important;
            border-left: 0px solid #87c2f0 !important;
            border-right: 0px solid #87c2f0 !important;
            padding: 25px;
        }

        .table td {
            /* padding: 10px 35px; */
            /* margin: 0 20px; */
            vertical-align: top;
            font-size: 14px;
            width: 0;
            border-bottom: 1px solid #8ebbdd;
        }

        th {
            /* width: 100%; */
            background: #0C0A4A;
            background: -webkit-linear-gradient(bottom left, #0C0A4A, #592F95);
            background: -moz-linear-gradient(bottom left, #0C0A4A, #592F95);
            background: linear-gradient(to top right, #0C0A4A, #592F95);
            color: #fff;
            font-size: 1.2em;
            height: 50px;
        }

        .table thead th {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            font-weight: 800;
            background: #0C0A4A;
            background: -webkit-linear-gradient(bottom left, #0C0A4A, #592F95);
            background: -moz-linear-gradient(bottom left, #0C0A4A, #592F95);
            background: linear-gradient(to top right, #0C0A4A, #592F95);
            color: #fff;
            text-align: center;
            padding: 0 30px;
            border-bottom: 2px solid #ebedf2;
        }

        .table tbody td {
            width: 100%;
            font-size: 14px;
            font-weight: 800;

            color: #000;
            text-align: center;
            padding: 0 30px;
            border-bottom: 2px solid #ebedf2;
        }

        .table tbody tr {
            width: 100%;
            padding: 0;
            font-size: 14px;
            font-weight: 800;

            color: #000;
            text-align: center;
            border-bottom: 2px solid #ebedf2;
        }

        th,
        td {
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
    </style>

</head>

<body>
    <form method="post" action="cart_checkout.php" id="form" style="margin-bottom: 100vh;">
        <div class="bg-white" style="width: 100%; height: auto;">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <div class="p-3 text-uppercase"> <input type="checkbox" onclick="select_one()" id="select_one"></input></div>
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


            <?php



            // Get user details (for the store)
            $sql_user = "SELECT ca.ct_id, us.user_id, us.role, us.store FROM `users` us LEFT JOIN `cart` ca ON us.user_id = ca.user_id WHERE us.role = 'Supplier' ";
            $res_user = mysqli_query($conn, $sql_user);




            if (mysqli_num_rows($res_user) > 0) {
                while ($users = mysqli_fetch_array($res_user)) {  ?>
                    <?php if (!empty($users['ct_id'])) { ?>

                        <div class="row" style=" border-bottom: solid 25px #eee;">
                            <div class="col-lg-12">
                                <!-- Shopping cart table -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <!-- Display user store (from users table) -->
                                            <tr>
                                                <td>
                                                    <input type="checkbox" onclick="select_all<?php echo $users['user_id'] ?>()" id="delete<?php echo $users['ct_id'] ?>" style="margin: 0 20px;" />
                                                    <?php echo $users["store"] ?>
                                                </td>
                                            </tr>

                                            <?php
                                            // Iterate through cart items

                                            $sql_material = "SELECT ca.ct_id, ca.sell_price, ca.quantity, sm.sm_id, sm.material_name, sm.type, sm.stock, sm.selling_price, sm.image, us.user_id, us.role, us.store 
                                            FROM `cart` ca LEFT JOIN `supplier_material` sm ON ca.sm_id = sm.sm_id LEFT JOIN `users` us ON us.user_id = sm.user_id 
                                            WHERE us.user_id = '" . $users["user_id"] . "' ORDER BY us.user_id DESC";
                                            $res_material = mysqli_query($conn, $sql_material);

                                            if (mysqli_num_rows($res_material) > 0) {
                                                while ($materials = mysqli_fetch_array($res_material)) {  ?>

                                                    <tr id="box<?php echo $materials['ct_id'] ?>" style=" border-bottom: solid 2px #eee;">
                                                        <td class="border-0 align-middle">
                                                            <input type="checkbox" id="<?php echo $materials['ct_id'] ?>" name="checkbox<?php echo $materials['user_id'] ?>[]" value="<?= $materials['material_name']; ?>" class="text-center input-qty bg-white" />
                                                            <!-- <input type="hidden" name="prodid<?php echo $materials['ct_id']; ?>[]" value="<?= $materials['ct_id']; ?>"> -->
                                                        </td>


                                                        <td width="25%">
                                                            <center><img src="../assets/images/material_images/<?php echo $materials['image']; ?>" alt="" width="70" class="img-fluid rounded shadow-sm"></center>
                                                            <center><?= $materials['material_name']; ?></center>
                                                        </td>


                                                        <td class="product_data border-0 align-middle">
                                                            <div class="input-group">
                                                                <button class="input-group-text bg-white decrement-btn">
                                                                    <center>-</center>
                                                                </button>
                                                                <input type="text" name="prod_qty<?php echo $materials['ct_id'] ?>[]" class="form-control text-center input-qty bg-white" style="width:70px; font-size:1rem; padding: 0 ;" value="<?= $materials['quantity'] ?>">
                                                                <button class="input-group-text bg-white increment-btn">
                                                                    <center>+</center>
                                                                </button>
                                                            </div>
                                                            <input type="hidden" class="form-control text-center input-stock bg-white" style="width:50px; font-size:9px;" value="<?= $materials['stock'] ?>" disabled>
                                                        </td>
                                                        <td width="25%">
                                                            <center>P<?php echo $materials['sell_price']; ?></center>
                                                            <input type="hidden" class="form-control text-center sell_price bg-white" style="width:50px; font-size:9px;" value="<?php echo $materials['sell_price']; ?>" disabled>
                                                        </td>
                                                        <td width="25%">
                                                            <center>
                                                                P<input type="text" class="form-control text-center total_amount bg-white" style="width:90px; font-size:9px;" value="0" disabled>
                                                            </center>
                                                        </td>
                                                        <td class="border-0 align-middle">
                                                            <a class="btn btn-sm m-b-10 menu_delete button2" data-role="update" id="<?php echo $materials['ct_id']; ?>">DELETE</a>
                                                        </td>


                                                    </tr>

                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- End -->
                            </div>
                        </div>
                        <script>
                            function select_all<?php echo $users['user_id']; ?>() {
                                var items<?php echo $users['ct_id']; ?> = document.getElementsByName('checkbox<?php echo $users['user_id']; ?>[]');
                                if (jQuery('#delete<?php echo $users['ct_id']; ?>').prop("checked")) {
                                    jQuery(items<?php echo $users['ct_id']; ?>).each(function() {
                                        jQuery('#' + this.id).prop('checked', true);
                                    });
                                } else {
                                    jQuery(items<?php echo $users['ct_id']; ?>).each(function() {
                                        jQuery('#' + this.id).prop('checked', false);
                                    });
                                }
                            }
                        </script>

                <?php
                    } else {
                    }
                }
            } else { ?>
                <div style="align-items:center; display:flex; margin-top:7%; justify-content: center;">
                    <div class="row">
                        <img src="images/background/checkout.svg" alt="" style="width:500px; height: 500px; align-items:center;">
                    </div><br>
                    <div class="row">
                        Your shopping cart is empty..
                        <a href="menu.php" class=" .button_1">Go Shopping now</a>
                    </div>

                </div>

            <?php
            }
            ?>

        </div>



        <section id="bottom">
            <div class="row">
                <div class="col-md-4">
                    <input type="checkbox" onclick="select_two()" id="select_two">
                    <label for="select_two">
                         (<span id="checkedCount">0</span>)
                    </label>
                </div>
                <div class="col-md-4">
                    <a href="javascript:void(0)" class="link_delete" onclick="delete_all()" style=" border: none; padding: 10px 30px;
                                border: 0 solid #E2E8F0;
                                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                                background-color: #E2E8F0;
                                box-sizing: border-box;
                                color: #000;">Delete</a>
                </div>
                <p>Total: $<input type="text" name="price" id="price" disabled /></p>

                <div class="col-sm-2">
                    <input type="submit" name="submit" id="button_1" class="btn button_1" style="border:none; " value="Check Out">
                </div>
            </div>


        </section>
    </form>
</body>

</html>


<script>
    $(document).ready(function() {
        // Function to count all checked checkboxes inside the specific <td class="border-0 align-middle">
        function countChecked() {
            // Count only the checkboxes inside the specific <td> and not all checkboxes on the page
            var checkedCount = $("td input[type='checkbox']:checked").length;
            $("#checkedCount").text(checkedCount);  // Update the text of the element with ID "checkedCount"
        }

        // Select all checkboxes inside the specific <td> when the 'select all' checkbox inside the same section is clicked
        $("#select_two").click(function() {
            var isChecked = $(this).prop("checked");
            $("td input[type='checkbox']").prop("checked", isChecked);  // Check/uncheck only the checkboxes inside the <td>
            countChecked();  // Call countChecked function to update the count of checked items inside that <td>
            calculateSum();  // Optionally call your sum calculation
        });

        // Handle individual checkbox clicks inside the specific <td>
        $("td input[type='checkbox']").change(function() {
            countChecked();  // Call countChecked whenever a checkbox is clicked inside the <td>
            calculateSum();  // Optionally call your sum calculation
        });

    });
</script>



<script>
    // This function calculates the total sum of the cart
    function calculateSum() {
        var sumTotal = 0;
        $('tbody tr').each(function() {
            var $tr = $(this);

            if ($tr.find('input[type="checkbox"]').prop("checked")) {
                var $columns = $tr.find('td');

                // Get price and quantity (Price is assumed to be in 4th column)
                var priceText = $columns.eq(3).text().trim();
                if (priceText.includes('P')) {
                    var $Cost = parseFloat(priceText.split('P')[1].trim());

                    // Get the quantity from the input field
                    var $quantity = $tr.find('input[type="text"]').val();
                    var $total = parseFloat($quantity) * $Cost;

                    // Set the total amount for this row
                    $tr.find('.total_amount').val($total.toFixed(2)); // Update the total_amount field with the calculated value

                    sumTotal += $total;
                }
            }
        });

        // Update the total sum on the page
        $("#price").val(sumTotal);
    }

    // Select all checkboxes when #select_two is clicked
    $("#select_two").click(function() {
        var isChecked = $(this).prop("checked");
        $("input[type='checkbox']").prop("checked", isChecked);
        calculateSum(); // Call the calculateSum function
    });
</script>

<script>
  
</script>

<script>
    // Handle "select all" checkbox behavior (first select all checkbox)
    $("#select_one").click(function() {
        var isChecked = $(this).prop("checked");
        $("input[type='checkbox']").prop("checked", isChecked);
        calculateSum();
    });

    // Handle quantity increment and decrement buttons
    $('.increment-btn').click(function(e) {
        e.preventDefault();
        var qtyInput = $(this).closest('.product_data').find('.input-qty');
        var stock = $(this).closest('.product_data').find('.input-stock').val();
        var value = parseInt(qtyInput.val(), 10) || 0;

        if (value < stock) {
            value++;
            qtyInput.val(value);
        }

        calculateSum(); // Recalculate price after increment
    });

    $('.decrement-btn').click(function(e) {
        e.preventDefault();
        var qtyInput = $(this).closest('.product_data').find('.input-qty');
        var value = parseInt(qtyInput.val(), 10) || 0;

        if (value > 1) {
            value--;
            qtyInput.val(value);
        }

        calculateSum(); // Recalculate price after decrement
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




</script>