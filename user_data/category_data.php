<!-- Table with stripped rows -->
<table class="table table-hover" id="table_category">
    <thead>
        <tr>
            <th>#</th>
            <th>Category Name <span style="color:red">*</span></th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php
        $category_list_query = "SELECT * FROM `category` ORDER BY `ca_id` DESC";
        $category_list_result = mysqli_query($conn, $category_list_query);
        $counter = 1; // Initialize counter 


        if (mysqli_num_rows($category_list_result) > 0) {
            while ($row = mysqli_fetch_array($category_list_result)) { ?>

                <tr>
                    <input type="hidden" name="ca_id[]" class="form-control" readonly value="<?php echo $row["ca_id"] ?>">


                    <td style="width: 200px;">
                        <h6 class="counter">
                            <?php echo $counter++; ?>
                        </h6>
                    </td>
                    <td style="width: 200px;"><input type="text" name="category_name[]" class="form-control" value="<?php echo $row["category_name"] ?>"></td>

                    <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($row["date_created_at"])) ? date("Y-m-d", strtotime($row["date_created_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>

                    <td style="width: 200px;">
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($row["date_updated_at"])) ? date("Y-m-d", strtotime($row["date_updated_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>
                    <input type="hidden" name="date_created_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($row["date_created_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">
                    <input type="hidden" name="date_updated_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($row["date_updated_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">

                    <td scope="col"  style="width: 200px;">
                        <div class="d-flex">
                            <button class="btn btn-dark btn-sm delete_category button3" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $row['ca_id']; ?>" data-role="change_password" id="<?php echo $row['ca_id']; ?>"><i class='bi bi-trash'></i></button>
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