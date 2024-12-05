<!-- 1st Card -->
<?php
$order_id = $_GET['order'];

$sql_order = "SELECT * FROM `order` WHERE or_id = '" . $order_id . "'";
$res_order = mysqli_query($conn, $sql_order);
$fetch_order = mysqli_fetch_array($res_order);

if ($fetch_order) {

    $sql_user = "SELECT * FROM `users` WHERE `user_id` = '" . $fetch_order['user_id'] . "' LIMIT 1";
    $res_user = mysqli_query($conn, $sql_user);
    $user = mysqli_fetch_array($res_user);
?>

    <div class="card-container">
        <!-- Card -->
        <div class="card card-custom" style="border-radius: 10px;">
            <div class="card-body">
                <!-- Header: Your Order Status -->
                <h5 class="card-title text-success">Your Order is (<?= $fetch_order['status']; ?>)</h5>

                <!-- Shipping Information -->
                <a href="user_logistic_view.php?order=<?= $fetch_order['or_id'] ?>" style="text-decoration:none;">
                    <p class="shipping-info">
                        <strong style="font-size: 14px; margin: 80px 0; padding: 80px 0;">Shipping Information</strong>
                        <span style="float: right; margin: 0px; padding:0;">&gt;</span>

                        <h6 class="card-title text-success" style="font-size:13px; position:absolute; bottom: 198px !important; padding:0;"><?= $fetch_order['order_code']; ?></h6>
                    </p>
                </a>


                <!-- Delivery Status -->
                <div class="d-flex align-items-center  mb-2">
                    <i class="bi bi-truck" style="font-size: 24px;"></i>
                    <p class="ml-2">Parcel has been (<?= $fetch_order['status']; ?>)</p>
                </div>

                <!-- Gray partition -->
                <hr>

                <!-- Delivery Information -->
                <p class="mt-3 mb-3"><strong style="font-size: 14px;">Delivery Information</strong></p>
                <div class="d-flex align-items-center">
                    <i class="bi bi-geo-alt" style="font-size: 24px;"></i>
                    <p class="ml-2">Burgos Street, Barangay 5, Calamba City, Laguna</p>
                </div>
            </div>
        </div>
    </div>


    <div class="card-container">
        <!-- Card -->
        <div class="card card-custom">
            <!-- Row 1: Store Name and Status -->
            <div class="row mb-3">
                <div class="col-8">
                    <div class="store-name"><i class="bi bi-shop" style="color: #28a745; font-size: 16px; margin: 0 15px;"></i><?= $user['store']; ?></div>
                </div>
            </div>


            <!-- 2nd Card -->
            <?php
            $material_list_query = "SELECT
    o.or_id,
    o.order_code,
    o.quantity,
    o.sell_price AS order_sell_price,
    o.total,
    o.cash,
    o.change,
    o.day_arrival,
    o.time_arrival,
    o.status AS order_status,
    o.date_created_at AS order_date_created_at,
    
    sm.sm_id,
    sm.material_name,
    sm.type AS material_type,
    sm.stock AS material_stock,
    sm.enter_stock AS material_enter_stock,
    sm.selling_price AS material_selling_price,
    sm.unit AS material_unit,
    sm.remarks AS material_remarks,
    sm.comment AS material_comment,
    sm.image AS material_image,
    sm.user_id AS material_user_id,
    sm.date_created_at AS material_date_created_at,
    sm.date_updated_at AS material_date_updated_at,
    
    u.user_id AS user_id,
    u.username,
    u.firstname,
    u.lastname,
    u.email,
    u.phone,
    u.address,
    u.age,
    u.birthday,
    u.start_date,
    u.role,
    u.store,
    u.image AS user_image,
    u.signature AS user_signature,
    u.status AS user_status,
    u.date_created_at AS user_date_created_at,
    u.date_updated_at AS user_date_updated_at

FROM
    `order` o
LEFT JOIN
    `supplier_material` sm ON o.sm_id = sm.sm_id
LEFT JOIN
    `users` u ON o.user_id = u.user_id

 WHERE o.order_code = '" . $fetch_order['order_code'] . "' AND u.store != ''  ORDER BY order_date_created_at DESC";
            $material_list_result = mysqli_query($conn, $material_list_query);

            if (mysqli_num_rows($material_list_result) > 0) {
                while ($material = mysqli_fetch_array($material_list_result)) { ?>



                    <!-- Row 2: Material Info with Image -->
                    <div class="row row-custom mb-1">
                        <div class="col-4">
                            <div class="image-box">
                                <!-- Replace with an actual image if necessary -->
                                <?php if (is_array($material)) { ?>
                                    <?php if (empty($material['image'])) { ?>
                                        <img src="../assets/images/default_images/tea_house.jpeg" width=100 height=100 title="yeaocha_main">
                                    <?php } else { ?>
                                        <img src="../assets/images/material_images/<?php echo $image; ?>" width=100 height=100 title="<?php echo $image; ?>">
                                <?php }
                                } ?>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="material-name"><?= $material['material_name']; ?></div>
                            <div class="type-quantity">
                                <span><?php if ($material['material_type'] == 1) {
                                            echo 'RAW';
                                        } else {
                                            echo 'DISPOSABLE';
                                        } ?></span>
                                <span>x<?= $material['quantity']; ?></span>
                            </div>

                            <div class="sell-price">₱ <?= $material['order_sell_price']; ?></div>
                            <?php
                            $sql_all = "SELECT COUNT(order_code) as count_code FROM `order` WHERE order_code = '" . $material['order_code'] . "' ";
                            $res_all = mysqli_query($conn, $sql_all);
                            $all = mysqli_fetch_array($res_all);
                            ?>
                            <div class="total-items">Total: <?= $all['count_code']; ?> items: ₱ <?= $material['total']; ?></div>
                        </div>
                    </div>

                    <!-- Row 3: Buy Again Button -->
                    <div class="row mb-3">
                        <div class="col-12 text-end">


                            <!-- Gray partition -->
                            <hr>
                            <?php $alltotal = 0;
                            $alltotal = $alltotal + $material['total']; ?>
                        </div>
                    </div>

                <?php
                }  ?>
                <p style="text-align: right;"><b>Merchendise Subtotal: <?php echo $alltotal; ?></b></p>
                <p style="text-align: right;"><b>Shipping Fee: <?php echo 30; ?></b></p>
                <hr>

                <p style="text-align: right;"><b>Order Total: <?php echo $alltotal + 30; ?></b></p>
            <?php
            } else {
            }
            ?>

        </div>
    </div>

    <div class="card-container">
        <!-- Card -->
        <div class="card card-custom" style="border-radius: 10px;">
            <div class="card-body">
                <!-- Order ID and Copy Button -->

                <div class="d-flex justify-content-between mb-4">
                    <p style="right: 0; justify-content: right; margin:0; text-align: right;"><b>Order ID</b></p>
                    <div style="right:0;  margin:0; justify-content: right; text-align: right;"><input type="text" class="order-code" value="<?= $fetch_order['order_code']; ?>" readonly><button class="btn btn-outline-primary" onclick="copyOrderCode()" style=" width:10x; padding: 5px 50px; color: #28a745; font-size: 12px;">Copy</button></div>
                </div>

                <!-- Paid By -->
                <div class="d-flex justify-content-between">

                    <p>Need by <?= $user['firstname'] . " " . $user['lastname']; ?></p>
                    <p>Cash on Delivery</p>
                </div>

                <!-- Gray partition -->
                <hr>

                <!-- Time Information -->

                <p>Order Time: <?= $fetch_order['date_created_at']; ?></p>
                <p>Payment Time: (<?= $fetch_order['day_arrival']; ?>) 8:00 AM - 6:00 PM</p>
                <?php
                if ($fetch_order['status'] == '') { ?>
                    <p>Ship Time: 2024-11-18 11:00 AM</p>
                    <p>Completed Time: 2024-11-18 12:00 PM</p>
                <?php
                }
                ?>

            </div>

            <div class="row mb-2">
                <div class="col-12 mt-5 text-end">
                    <!-- <button class="buy-again-btn">Buy Again    </button> -->
                </div>
            </div>
        </div>
    </div>

<?php
}
?>