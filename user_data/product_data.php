<form id="updateUserProduct" action="" method="post">


    <!-- Table with stripped rows -->
    <table class="table table-hover" id="table_category">
        <thead>
            <tr>
                <th>#</th>
                <th>Image <span style="color:red">*</span></th>
                <th>Item Name <span style="color:red">*</span></th>
                <th>Category <span style="color:red">*</span></th>
                <th>Selling Price <span style="color:red">*</span></th>
                <th>Date Created</th>
                <th>Date Updated</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="input-container-archive">

            <?php
            $product_list_query = "SELECT * FROM `product` ORDER BY `pr_id` DESC";
            $product_list_result = mysqli_query($conn, $product_list_query);
            $counter = 1; // Initialize counter 


            if (mysqli_num_rows($product_list_result) > 0) {
                while ($product = mysqli_fetch_array($product_list_result)) { ?>


                    <tr>
                        <input type="hidden" name="pr_id[]" class="form-control" readonly value="<?php echo $product["pr_id"] ?>">

                        <td style="width: 200px;">
                            <h6 class="counter">
                                <?php echo $counter++; ?>
                            </h6>
                        </td>

                        <td>
                            <div class="profile-image" style="justify-content: center; margin-left: 25px;">
                                <form class="form" id="formproduct<?php echo $product["pr_id"] ?>">
                                    <div class="upload" style=" width: 125px;
                                        position: relative;
                                        margin: auto;">
                                        <?php
                                        $id = $product["pr_id"];
                                        $name = $product["pr_id"];
                                        $image = $product["image"];

                                        if (is_array($product)) { ?>
                                            <?php if (empty($product['image'])) { ?>
                                                <img src="../assets/images/default_images/tea_house.jpeg" width=200 height=200 title="yeaocha_main" style="  border-radius: 50% !important;
                                        border: 3px solid #DCDCDC;
                                        height: 90px;
                                        width: 90px;">
                                            <?php } else { ?>
                                                <img src="../assets/images/product_images/<?php echo $image; ?>" width=200 height=200 title="<?php echo $image; ?>" style="  border-radius: 50% !important;
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
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="name" value="<?php echo $name; ?>">
                                            <input type="file" name="image" id="imageproduct<?php echo $product["pr_id"] ?>" accept=".jpg, .jpeg, .png" style=" position: absolute;
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
                                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal<?php echo $product["pr_id"] ?>" style="top:0; background: transparent; border:0;width: 42px; height: 42px;"><i class="bi bi-arrows-angle-expand" style="color: #000; font-size: 20px; border:0; background: #fff;"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>


                        <td style="width: 200px;"><input type="text" name="product_name[]" class="form-control" value="<?php echo $product["product_name"] ?>"></td>
                        <td>
                            

                            <select name="ca_id[]" id="ca_id">
                                <option value="" disabled <?php echo empty($product["ca_id"]) ? 'selected' : ''; ?>>Choose Category</option>
                                <?php
                                $category_query = "SELECT * FROM `category` ORDER BY `ca_id` DESC";
                                $category_result = mysqli_query($conn, $category_query);
                                if (mysqli_num_rows($category_result) > 0) {
                                    while ($cat = mysqli_fetch_array($category_result)) {
                                        $category_name = $cat["category_name"]; 
                                ?>
                                        <option value="<?php echo $category_name; ?>" <?php echo ($cat["category_name"] === "$category_name" ) ? 'selected' : ''; ?>><?php echo $cat["category_name"]; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>

                        </td>

                        <td style="width: 200px;"><input type="text" name="selling_price[]" class="form-control" value="<?php echo $product["selling_price"] ?>"></td>

                        <td style="width: 200px;">
                            <h6 class="pt-2">
                                <?= date("Y-m-d", strtotime($product["date_created_at"])) ? date("Y-m-d", strtotime($product["date_created_at"])) : '0000-00-00' ?>
                            </h6>
                        </td>

                        <td style="width: 200px;">
                            <h6 class="pt-2">
                                <?= date("Y-m-d", strtotime($product["date_updated_at"])) ? date("Y-m-d", strtotime($product["date_updated_at"])) : '0000-00-00' ?>
                            </h6>
                        </td>

                        <input type="hidden" name="date_created_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($product["date_created_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">

                        <input type="hidden" name="date_updated_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($product["date_updated_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">

                        <td scope="col" style="width: 200px;">
                            <div class="d-flex">
                                <button class="btn btn-dark btn-sm delete_product button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $product['pr_id']; ?>" data-role="change_password" id="<?php echo $product['pr_id']; ?>"><i class='bi bi-trash'></i></button>
                            </div>
                        </td>

                    </tr>

                    <!-- Modal -->
                    <div class="modal fade pb-5" id="exampleModal<?php echo $product["pr_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style=" font-size: 14px; font-weight: 800; background: #535e70; color: #fff; text-align: center; border-bottom: 2px solid #ebedf2;">
                                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">View Product Image</h5>
                                    <button type="button" class="close mr-1" style="position:absolute;padding-top: 22px; background: transparent; border:0; top:0; right:20px; font-size:24px; " data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" style="color: #fff;">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-5">
                                                <?php
                                                if (is_array($product)) { ?>
                                                    <?php if (empty($product['image'])) { ?>
                                                        <img src="../assets/images/default_images/tea.jpeg" title="product" width=200 height=200 title="yeaocha_main" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 340px !important; height: 350px;">
                                                    <?php } else { ?>
                                                        <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $product["item_code"]; ?>" style="  width: 100%;height: auto;display: block;margin: 0 auto;max-height: 80vh; width: 340px !important; height: 350px;">
                                                <?php }
                                                } ?>
                                            </div>

                                        </div>
                                        <div class="col-6">
                                            <h3><strong>Product Name:</strong> <span><?= $product['product_name'] ?></span></h3>
                                            <h6><strong>Date Created:</strong> <span><?= $product["date_created_at"] ? $product["date_created_at"] : '0000-00-00' ?></span></h6>
                                            <h6><strong>Selling Price:</strong> <span><?= $product['selling_price'] ?></span></h6>
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


    <div class="w-100 d-flex justify-content-end">
        <button type="submit" id="save-btn" class="btn btn-sm bg-white btn-icon-text border main-btn" style="margin: 50px; width: 200px; height: 50px; align-item: right; right:0;">
            Submit
        </button>
    </div>

</form>