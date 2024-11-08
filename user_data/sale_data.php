<!-- Table with stripped rows -->
<table class="table table-hover" id="table_sale">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Code</th>
            <th>Quantity</th>
            <th>OVERALL TOTAL</th>
            <th>Date Created</th>
            <th>Time Created</th>
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php
        $product_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.product_name as product_name, p.ca_id,  p.image, s.sales_code,s.pr_id, s.sell_price, s.quantity, SUM(s.quantity) AS total_quantity,  s.total as total, SUM(s.total) AS total_orders, s.date_created_at, s.date_updated_at
           FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE sa_id != '' GROUP BY s.sales_code ORDER BY s.date_created_at DESC";
        $product_list_result = mysqli_query($conn, $product_list_query);

        $counter = 1; // Initialize counter 



        if (mysqli_num_rows($product_list_result) > 0) {
            while ($product = mysqli_fetch_array($product_list_result)) { ?>

                <tr>


                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?php echo $counter++; ?>
                        </h6>
                    </td>


                    <td>
                        <h6 class="counter" style="width: 200px;">
                            <?php

                            $item_code_list_query1 = "SELECT s.sa_id, p.pr_id as pr_id, p.product_name as product_name, p.ca_id, p.image, s.pr_id, s.sell_price, s.total as total, s.date_created_at, s.date_updated_at FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE s.sales_code = '" . $product["sales_code"] . "' ORDER BY s.sales_code DESC";
                            $item_code_list_result1 = mysqli_query($conn, $item_code_list_query1);
                            $item1 = mysqli_fetch_array($item_code_list_result1);
                            echo $item1["product_name"];
                            $item_code_list_query = "SELECT s.sa_id, p.pr_id as pr_id, p.product_name as product_name, p.ca_id, p.image, s.pr_id, s.sell_price, s.total as total, s.date_created_at, s.date_updated_at FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE s.sales_code = '" . $product["sales_code"] . "' AND product_name != '" . $item1["product_name"] . "' ORDER BY s.sales_code DESC";
                            $item_code_list_result = mysqli_query($conn, $item_code_list_query);

                            if (mysqli_num_rows($item_code_list_result) > 0) {
                                while ($item = mysqli_fetch_array($item_code_list_result)) { ?>
                                    , <?php echo $item["product_name"] ?>
                            <?php   }
                            }
                            ?>
                        </h6>

                    </td>

                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?= $product["total_quantity"] ? $product["total_quantity"] : '' ?> PCS
                        </h6>
                    </td>


                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?= "₱" . $product["total_orders"] ? "₱" . $product["total_orders"]  : ''  ?>
                        </h6>
                    </td>

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

                </tr>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal<?php echo $product["pr_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(0,0,0,0.7);">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background: linear-gradient(to bottom, #e6e5f2, #4599cd);">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;">View Product Image</h5>
                                <button type="button" class="close mr-1" style="padding-top: 22px;" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <div class="card-container">
                                        <?php
                                        include '../config/connect.php';

                                        $show_list_query = "SELECT s.sa_id, p.pr_id as pr_id, 
                                        p.product_name as product_name, 
                                        p.ca_id,  p.image, s.sales_code, 
                                        s.pr_id, s.sell_price, 
                                        s.quantity, s.total, s.date_created_at, s.date_updated_at
                                        FROM product p LEFT JOIN sale s ON p.pr_id = s.pr_id WHERE sa_id != '' 
                                        AND  s.sales_code = '" . $product["sales_code"] . "' 
                                        ORDER BY s.sales_code DESC";

                                        $show_list_result = mysqli_query($conn, $show_list_query);

                                        if (mysqli_num_rows($show_list_result) > 0) {
                                            while ($show = mysqli_fetch_array($show_list_result)) { ?>
                                                <div class="card-items <?= strtolower($show['ca_id']) ?>" data-name="<?= strtolower($show['item_code']) ?>">
                                                    <?php
                                                    $image = $show["image"];

                                                    if (is_array($show)) { ?>
                                                        <?php if (empty($show['image'])) { ?>
                                                            <img src="../assets/images/default_images/product.jpg" title="Product Image" alt="Product Image" class="card-img">
                                                        <?php } else { ?>
                                                            <img src="../assets/images/product_images/<?php echo $image; ?>" title="<?php echo $image; ?>" alt="Product Image" class="card-img">
                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                    <div class="product-name ml-2 mr-2"><?=  $product_name = substr_replace($show['product_name'], "", 9, 0) ?></div>
                                                    <div class="item-code mt-2 ml-2 mr-2"><?= $show['item_code'] ?></div>
                                                   
                                                    <div class="price-quantity mt-4 ml-2 mr-2">
                                                        <div class="mt-1">Price: <b><?= $show['sell_price'] ?></b></div>

                                                        <div>QTY: <input type="text" value="<?= $show['quantity'] ?>" class="quantity" style="border: none;"></div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
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