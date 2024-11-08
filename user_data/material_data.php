<!-- Table with stripped rows -->
<table class="table table-hover" id="table_category">
    <thead>
        <tr>
            <th>#</th>
            <th>Image <span style="color:red">*</span></th>
            <th>Material Name <span style="color:red">*</span></th>
            <th>Type <span style="color:red">*</span></th>
            <th>Stock <span style="color:red">*</span></th>
            <th>Units <span style="color:red">*</span></th>
            <th>REMARKS</th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php
        $material_list_query = "SELECT * FROM `material` WHERE stock > 30 OR remarks = 'AVAILABLE' ORDER BY `ma_id` DESC";
        $material_list_result = mysqli_query($conn, $material_list_query);
        $counter = 1; // Initialize counter 


        if (mysqli_num_rows($material_list_result) > 0) {
            while ($material = mysqli_fetch_array($material_list_result)) { ?>

                <tr>
                    <input type="hidden" name="ma_id[]" class="form-control" readonly value="<?php echo $material["ma_id"] ?>">

                    <td style="width: 200px;">
                        <h6 class="counter">
                            <?php echo $counter++; ?>
                        </h6>
                    </td>

                    <td>
                        <div class="profile-image" style="justify-content: center; margin-left: 25px;">
                            <form class="form" id="formmaterial<?php echo $material["ma_id"] ?>">
                                <div class="upload" style=" width: 125px;
                                        position: relative;
                                        margin: auto;">
                                    <?php
                                    $id = $material["ma_id"];
                                    $name = $material["ma_id"];
                                    $image = $material["image"];

                                    if (is_array($material)) { ?>
                                        <?php if (empty($material['image'])) { ?>
                                            <img src="../assets/images/default_images/tea_house.jpeg" width=200 height=200 title="yeaocha_main" style="  border-radius: 50% !important;
                                        border: 3px solid #DCDCDC;
                                        height: 90px;
                                        width: 90px;">
                                        <?php } else { ?>
                                            <img src="../assets/images/material_images/<?php echo $image; ?>" width=200 height=200 title="<?php echo $image; ?>" style="  border-radius: 50% !important;
                                        border: 3px solid #DCDCDC;
                                        height: 90px;
                                        width: 90px;">

                                    <?php }
                                    }
                                    ?>

                                    <div class="round" style=" position: absolute;
                                        transform: scale(2);
                                        /* background: #4a6cf7; */
                                        width: 58px;
                                        height: 56px;
                                        line-height: 43px;
                                        text-align: center;
                                        overflow: hidden;
                                        border-radius: 50%;
                                        overflow: hidden;
                                        left: 20px;
                                        top: 22px;">
                                        <input type="hidden" name="idmaterial" value="<?php echo $id; ?>">
                                        <input type="hidden" name="namematerial" value="<?php echo $name; ?>">
                                        <input type="file" name="imagematerial" id="imagematerial<?php echo $material["ma_id"]; ?>" accept=".jpg, .jpeg, .png" style=" position: absolute;
                                        transform: scale(2);
                                        /* background: #4a6cf7 !important; */
                                        width: 108px;
                                        height: 46px;
                                        line-height: 43px;
                                        text-align: center;
                                        overflow: hidden;
                                        border-radius: 50%;
                                        overflow: hidden;
                                        left: 0px;
                                        top: 22px;
                                        opacity: 0;">
                                    </div>

                                    <div class="round1" style="position: absolute;
                                        top: 50px;
                                        right: 30px;
                                        background: transparent !important;
                                        width: 42px;
                                        height: 42px;
                                        line-height: 43px;
                                        text-align: top;
                                        overflow: hidden;">
                                        <button type="button" class="btn" data-toggle="modal" data-target="#exampleMaterialModal<?php echo $material["ma_id"] ?>" style="top:0; background: transparent; border:0;width: 42px; height: 42px;"><i class="bi bi-arrows-angle-expand" style="color: #000; font-size: 20px; border:0; background: #fff;"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </td>

                    <td style="width: 200px;"><input type="text" name="material_name[]" class="form-control" value="<?php echo $material["material_name"] ?>"></td>
                    <td>
                        <select name="type_name[]" id="type_name">
                            <option value="" disabled <?php echo 0 ? 'selected' : ''; ?>>Choose Category</option>
                            <option value="1" <?php echo $material["type"] == 1 ? 'selected' : ''; ?>>RAW</option>
                            <option value="2" <?php echo $material["type"] == 2 ? 'selected' : ''; ?>>DISPOSABLE</option>

                        </select>
                    </td>
                    <td style="width: 200px;"><input type="text" name="stock[]" class="form-control" value="<?php echo $material["stock"] ? $material["stock"]: 0 ?>"></td>
                    <td>
                        <select name="unit_name[]" id="unit_name">
                            <option value="" disabled <?php echo 0 ? 'selected' : ''; ?>>Choose Category</option>
                            <option value="1" <?php echo $material["unit"] == 1 ? 'selected' : ''; ?>>ML</option>
                            <option value="2" <?php echo $material["unit"] == 2 ? 'selected' : ''; ?>>G</option>
                            <option value="3" <?php echo $material["unit"] == 3 ? 'selected' : ''; ?>>PCS</option>
                        </select>
                    </td>
                    
                    <td>
                        <h6 class="counter" style="width: 200px;">
                            <?php echo $material["remarks"]; ?>
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
                    <!-- <input type="hidden" name="date_created_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($material["date_created_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">
                    <input type="hidden" name="date_updated_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($material["date_updated_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>"> -->

                    <!-- <td scope="col" style="width: 200px;">
                        <div class="d-flex">
                            <button class="btn btn-dark btn-sm delete_material button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $material['ma_id']; ?>" data-role="change_password" id="<?php echo $material['ma_id']; ?>"><i class='bi bi-trash'></i></button>
                        </div>
                    </td> -->
                </tr>



                <!-- Modal -->
                <div class="modal fade pb-5" id="exampleMaterialModal<?php echo $material["ma_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleMaterialModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style=" font-size: 14px; font-weight: 800; background: #535e70; color: #fff; text-align: center; border-bottom: 2px solid #ebedf2;">
                                <h5 class="modal-title" id="exampleMaterialModalLabel" style="color: #fff;">View Material Image</h5>
                                <button type="button" class="close mr-1" style="position:absolute;padding-top: 22px; background: transparent; border:0; top:0; right:20px; font-size:24px; " data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true" style="color: #fff;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-5">
                                            <?php
                                            if (is_array($material)) { ?>
                                                <?php if (empty($material['image'])) { ?>
                                                    <img src="../assets/images/default_images/tea.jpeg" title="material" width=200 height=200 title="yeaocha_main" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 340px !important; height: 350px;">
                                                <?php } else { ?>
                                                    <img src="../assets/images/material_images/<?php echo $image; ?>" title="<?php echo $material["item_code"]; ?>" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 340px !important; height: 350px;">
                                            <?php }
                                            } ?>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <h3><strong>Material Name:</strong> <span><?= $material['material_name'] ?></span></h3>
                                        <h6><strong>Date Created:</strong> <span><?= $material["date_created_at"] ? $material["date_created_at"] : '0000-00-00' ?></span></h6>
                                        <h6><strong>Amount:</strong> <span><?= $material['stock']  ?> <?php if($material['unit'] == 1){ echo 'ML'; } else if($material['unit'] == 2){ echo 'G'; } else{ echo 'PCS'; }?></span></h6>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


        <?php
            }
        }
        ?>

    </tbody>
</table>
<!-- End Table with stripped rows -->