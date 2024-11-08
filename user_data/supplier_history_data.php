<!-- Table with stripped rows -->
<table class="table table-hover" id="table_history">
    <thead>
        <tr>
            <th>#</th>
            <th>Material Name</th>
            <th>Type</th>
            <th>Stock</th>
            <th>Selling Price</th>
            <th>Units</th>
            <th>REMARKS</th>
            <th>Date Updated</th>
            <!-- <th>Action</th> -->
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php
        $material_list_query = "SELECT * FROM `supplier_history` ORDER BY `sh_id` DESC";
        $material_list_result = mysqli_query($conn, $material_list_query);
        $counter = 1; // Initialize counter 


        if (mysqli_num_rows($material_list_result) > 0) {
            while ($material = mysqli_fetch_array($material_list_result)) { ?>

                <tr>

                    <td style="width: 200px;">
                        <h6 class="counter">
                            <?php echo $counter++; ?>
                        </h6>
                    </td>


                    <td>
                        <h6 class="counter" style="width: 200px;">
                            <?php echo $material["material_name"] ?>
                        </h6>
                    </td>
                    <td>
                        <h6 class="counter" style="width: 200px;">
                            <?php
                            if ($material["type"] == 1) {
                                echo 'RAW';
                            } else if ($material["type"] == 2) {
                                echo 'DISPOSABLE';
                            } else {
                                echo 'Empty Type of Material';
                            }
                            ?>
                        </h6>
                    </td>

                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?php echo $material["stock"] ?>
                        </h6>
                    </td>

                    
                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?php echo $material["selling_price"] ?>
                        </h6>
                    </td>

                    <td>
                        <h6 class="counter" style="width: 100px;">
                            <?php
                            if ($material["unit"] == 1) {
                                echo 'ML';
                            } else if ($material["unit"] == 2) {
                                echo 'G';
                            }  else if ($material["unit"] == 3) {
                                echo 'PCS';
                            } else {
                                echo 'Empty Unit of Material';
                            }
                            ?>
                        </h6>
                    </td>

                    <td>
                        <h6 class="counter" style="width: 200px;">
                            <?php echo $material["remarks"]; ?>
                        </h6>
                    </td>

                    <!-- <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($material["date_created_at"])) ? date("Y-m-d", strtotime($material["date_created_at"])) : '0000-00-00' ?>
                        </h6>
                    </td> -->

                    <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($material["date_created_at"])) ? date("Y-m-d", strtotime($material["date_created_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>
                </tr>



        <?php
            }
        }
        ?>

    </tbody>
</table>
<!-- End Table with stripped rows -->