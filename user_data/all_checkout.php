<?php
if (isset($_SESSION["user_id_admin"])) {
    $id = $_SESSION["user_id_admin"];
    $u_id = "";
} else if (isset($_SESSION["user_id_supplier"])) {
    $id = $_SESSION["user_id_supplier"];
    $u_id = "o.user_id = '$id' AND ";
} else {
}
$material_list_query = "SELECT
    o.or_id,
    o.order_code,
    o.user_id AS order_user_id,
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

 WHERE $u_id o.status = 'Check Out'  AND u.store != '' GROUP BY o.order_code ORDER BY order_date_created_at DESC";
$material_list_result = mysqli_query($conn, $material_list_query);

if (mysqli_num_rows($material_list_result) > 0) {
    while ($material = mysqli_fetch_array($material_list_result)) { ?>

        <a href="user_orders_view.php?order=<?= $material['or_id'] ?>" style="text-decoration:none;">
            <div class="card-container">
                <!-- Card -->
                <div class="card card-custom" style=" height: 355px !important;">
                    <!-- Row 1: Store Name and Status -->
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="store-name"><i class="bi bi-shop" style="color: #28a745; font-size: 16px; margin: 0 15px;"></i><?= $material['store']; ?></div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="status" style="color: #28a745; font-size: 16px; margin: 5px 8px;"><?= $material['order_code']; ?> - TO PACK</div>
                        </div>
                    </div>

                    <!-- Row 2: Material Info with Image -->
                    <div class="row row-custom mb-1">
                        <div class="col-4">
                            <div class="image-box">
                                <!-- Replace with an actual image if necessary -->
                                <?php if (is_array($material)) { ?>
                                    <?php if (empty($material['image'])) { ?>
                                        <img src="../assets/images/default_images/tea_house.jpeg" width=200 height=200 title="yeaocha_main">
                                    <?php } else { ?>
                                        <img src="../assets/images/material_images/<?php echo $image; ?>" width=200 height=200 title="<?php echo $image; ?>">
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
                            <div class="total-items">Day Arrive: <?= $material['day_arrival']; ?></div>
                            <div class="total-items">Time Arrive: <?= $material['time_arrival']; ?></div>

                        </div>
                    </div>

                    <!-- Row 3: Buy Again Button -->
                    <div class="row mb-3">
                        <div class="col-12 text-end">

                            <!-- <input type="hidden" name="or_id[]" value="<?php echo $material["or_id"] ?>">
                            <input type="hidden" name="material_name[]" value="<?php echo $material["material_name"] ?>">

                            <input type="hidden" name="order_code[]" value="<?php echo $material['order_code']; ?>">
                            <input type="hidden" name="user_id[]" value="<?php echo $material['user_id']; ?>">

                            <input type="hidden" name="sm_id[]" value="<?php echo $material['sm_id']; ?>">
                            <input type="hidden" name="quantity[]" value="<?php echo $material['quantity']; ?>">
                            <input type="hidden" name="sell_price[]" value="<?php echo $material['sm_id']; ?>">

                            <input type="hidden" name="total[]" value="<?php echo  $material['total']; ?>">
                            <input type="hidden" name="cash[]" id="first_cash" value="<?php echo  $material['cash']; ?>">
                            <input type="hidden" name="change[]" id="first_change" value="<?php echo  $material['change']; ?>">
                            <input type="hidden" name="alltotal[]" value="<?php echo  $material['sm_id']; ?>">

                            <input type="hidden" name="time_arrival[]" value="<?php echo  $material['time_arrival']; ?>">
                            <input type="hidden" name="day_arrival[]" value="<?php echo  $material['day_arrival']; ?>"> 
                            -->
                            <?php
                            if (isset($_SESSION["user_id_admin"])) { ?>
                                <button class="buy-again-btn update_order button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $material['or_id']; ?>" data-role="change_password" id="<?php echo $material['or_id']; ?>">Cancel</button>
                            <?php } else if (isset($_SESSION["user_id_supplier"])) { ?>
                                <button class="buy-again-btn update_order button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $material['or_id']; ?>" data-role="change_password" id="<?php echo $material['or_id']; ?>">Proceed to Pack</button>
                                <?php } else {
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </a>

<?php }
} else {
} ?>