<!-- Table with stripped rows -->
<table class="table table-hover" id="table_menu">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name <span style="color:red">*</span></th>
            <th>Material Name <span style="color:red">*</span></th>
            <th>Type <span style="color:red">*</span></th>
            <th>Stock <span style="color:red">*</span></th>
            <th>Units <span style="color:red">*</span></th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php
        $material_list_query = "SELECT ma.ma_id, ma.type, ma.stock, ma.unit, me.pr_id, me.me_id, me.date_created_at, me.date_updated_at  FROM `material` ma LEFT JOIN `menu` me ON ma.ma_id = me.ma_id WHERE pr_id IS NOT NULL ORDER BY `ma_id` DESC";
        $material_list_result = mysqli_query($conn, $material_list_query);
        $counter = 1; // Initialize counter 


        if (mysqli_num_rows($material_list_result) > 0) {
            while ($material = mysqli_fetch_array($material_list_result)) { ?>

                <tr>
                    <input type="hidden" name="counter[]" class="form-control" readonly value="<?php echo $counter ?>">
                    <input type="hidden" name="me_id[]" class="form-control" readonly value="<?php echo $material["me_id"] ?>">

                    <td style="width: 200px;">
                        <h6 class="counter">
                            <?php echo $counter++; ?>
                        </h6>
                    </td>


                    <td>
                        <select name="product_name[]" id="product_name">
                            <option value="Choose Product" disabled <?php echo empty($material["pr_id"]) ? 'selected' : ''; ?>>Choose Product</option>

                            <?php
                            $product_query = "SELECT * FROM `product` ORDER BY `pr_id` DESC";
                            $product_result = mysqli_query($conn, $product_query);


                            if (mysqli_num_rows($product_result) > 0) {
                                while ($prod = mysqli_fetch_array($product_result)) { ?>
                                    <option value="<?php echo $prod["pr_id"]  ? $prod["pr_id"] : ''; ?>" <?php echo ($prod["pr_id"] === $material["pr_id"]) ? 'selected' : ''; ?>><?php echo $prod["product_name"]  ? $prod["product_name"] : ''; ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                    </td>
                    <td>
                        <select name="material_name[]" id="material_name">
                            <option value="Choose Material" disabled <?php echo empty($material["ma_id"]) ? 'selected' : ''; ?>>Choose Product</option>

                            <?php
                            $material_query = "SELECT * FROM `material` ORDER BY `ma_id` DESC";
                            $material_result = mysqli_query($conn, $material_query);


                            if (mysqli_num_rows($material_result) > 0) {
                                while ($mat = mysqli_fetch_array($material_result)) { ?>
                                    <option value="<?php echo $mat["ma_id"]  ? $mat["ma_id"] : ''; ?>" <?php echo ($material["ma_id"] === $mat["ma_id"]) ? 'selected' : ''; ?>><?php echo $mat["material_name"]  ? $mat["material_name"] : ''; ?></option>
                            <?php
                                }
                            } ?>
                        </select>
                    </td>
                    <td>
                    <h6>
                        <?php  if($material["type"] == 1 ){ echo 'RAW';} else { echo 'DISPOSABLE'; } ?>
                    </h6>
                    </td>
                    <td>
                        <input type="text" name="stock[]" class="form-control" value="<?php  echo $material["stock"]; ?>">
                    </td>
                    <td style="width: 50px;">
                        <h6>
                        <?php  if($material["unit"] == 1){ echo 'ML';} else if($material["unit"] == 2){ echo 'G'; } else { echo 'PCS'; } ?>
                        </h6>
                    </td>
                    <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($material["date_created_at"])) ? date("Y-m-d", strtotime($material["date_created_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>

                    <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($material["date_updated_at"])) ? date("Y-m-d", strtotime($material["date_updated_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>
                    <input type="hidden" name="date_created_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($material["date_created_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">
                    <input type="hidden" name="date_updated_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($material["date_updated_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">

                    <td scope="col" style="width: 200px;">
                        <div class="d-flex">
                            <button class="btn btn-dark btn-sm delete_menu button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $material['me_id']; ?>" data-role="change_password" id="<?php echo $material['me_id']; ?>"><i class='bi bi-trash'></i></button>
                        </div>
                    </td>
                </tr>
        <?php
            }
        }
        ?>

    </tbody>
</table>
<!-- End Table with stripped rows -->