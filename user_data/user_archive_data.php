<!-- Table with stripped rows -->
<table class="table table-hover" id="table_archive">
    <thead>
        <tr>
            <th>#</th>
            <th>User ID</th>
            <th>Position <span style="color:red">*</span></th>
            <th>First Name <span style="color:red">*</span></th>
            <th>Last Name <span style="color:red">*</span></th>
            <th>Email <span style="color:red">*</span></th>
            <th>Phone <span style="color:red">*</span></th>
            <th>Address <span style="color:red">*</span></th>
            <th>Birthday <span style="color:red">*</span></th>
            <th>Age <span style="color:red">*</span></th>
            <th>Start Date <span style="color:red">*</span></th>
            <th>Date Created</th>
            <th>Date Updated</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="input-container-archive">

        <?php

        include '../config/connect.php';
        error_reporting(0);
        session_start();

        $id = $_SESSION["user_id_admin"];
        $sessionId = $id;
        $user_list_query = "SELECT * FROM `users` WHERE `user_id` != $sessionId && `status` = 'INACTIVE' && `role` != 'Supplier' ORDER BY `user_id` DESC";
        $user_list_result = mysqli_query($conn, $user_list_query);
        $counter = 1; // Initialize counter 


        if (mysqli_num_rows($user_list_result) > 0) {
            while ($row = mysqli_fetch_array($user_list_result)) { ?>

                <tr>
                    <input type="hidden" name="user_id[]" class="form-control" readonly value="<?php echo $row["user_id"] ?>">


                    <td scope="col">
                        <h6 class="counter">
                            <?php echo $counter++; ?>
                        </h6>
                    </td> <!-- Counter for each row -->
                    <td scope="col">
                        <h6 class="pt-2">
                            <?php echo $row["username"] ?>
                        </h6>
                    </td>
                    <td>
                        <select name="role[]" id="role">
                            <option value="" disabled <?php echo empty($row["role"]) ? 'selected' : ''; ?>>Choose a role</option>
                            <option value="Admin" <?php echo ($row["role"] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="Cashier" <?php echo ($row["role"] === 'Cashier') ? 'selected' : ''; ?>>Cashier</option>
                            <option value="Employee" <?php echo ($row["role"] === 'Employee') ? 'selected' : ''; ?>>Employee</option>
                        </select>

                    </td>
                    <td><input type="text" name="firstname[]" class="form-control" value="<?php echo $row["firstname"] ?>"></td>
                    <td><input type="text" name="lastname[]" class="form-control" value="<?php echo $row["lastname"] ?>"></td>
                    <td><input type="text" name="email[]" class="form-control" value="<?php echo $row["email"] ?>"></td>
                    <td>
                        <div style="display: flex;"><input type="text" name="phone1[]" class="form-control" value="+639" readonly><input type="text" name="phone2[]" class="form-control" value="<?php echo substr_replace($row['phone'], "", 0, 4) ?>"></div>
                    </td>
                    <td><input type="text" name="address[]" class="form-control" value="<?php echo $row["address"] ?>"></td>
                    <td><input type="date" name="birthday[]" class="form-control" value="<?php echo $row["birthday"] ?>"></td>
                    <td><input type="text" name="age[]" class="form-control" value="<?php echo $row["age"] ?>"></td>
                    <td><input type="date" name="start_date[]" class="form-control" value="<?= date("Y-m-d", strtotime($row["start_date"])) ? date("Y-m-d", strtotime($row["start_date"])) : '0000-00-00 00:00:00' ?>"></td>
                    <td>
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($row["date_created_at"])) ? date("Y-m-d", strtotime($row["date_created_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>

                    <td>
                        <h6 class="pt-2">
                            <?= date("Y-m-d", strtotime($row["date_updated_at"])) ? date("Y-m-d", strtotime($row["date_updated_at"])) : '0000-00-00' ?>
                        </h6>
                    </td>
                    <input type="hidden" name="date_created_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($row["date_created_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">
                    <input type="hidden" name="date_updated_at[]" class="form-control" value="<?= date("Y-m-d", strtotime($row["date_updated_at"])) ? '0000-00-00 00:00:00' : '0000-00-00 00:00:00' ?>">

                    <td scope="col">
                        <div class="d-flex">
                            <button class="btn btn-dark btn-sm change_pass button1" data-bs-toggle="modal" data-bs-target="#changePassword" value="<?= $row['user_id']; ?>" data-role="change_password" id="<?php echo $row['user_id']; ?>"><i class='bi bi-key'></i></button>
                            <!-- <button class="btn btn-info btn-sm m-b-10 account_edit button1" data-bs-toggle="modal" data-bs-target="#updateUserAccount" value="<?= $row['user_id']; ?>" data-role="update" id="<?php echo $row['user_id']; ?>" style="background-color: #DAA520; border-style: solid; border-color: #000;  border-color: #6c8cc4;"><i class='bi bi-pencil' style="color: #fff; font-size: 20px;"></i></button>&nbsp;&nbsp;&nbsp; -->
                            <button class="btn btn-danger btn-sm account_archive button2" data-role="update" id="<?php echo $row['user_id']; ?>"><i class='bi bi-archive'></i></button>
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