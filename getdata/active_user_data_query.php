<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Table</title>
    <style>
        @media print {
            @page {
                margin-top: 120px;
                /* size: auto; */
            }

            body {
                margin: 0cm;
            }

            /* Default header margin for the first page */
            body:first-child header {
                margin-top: 10px;
                margin-bottom: 120px;
            }

            /* Add margin for the second page and beyond */
            body:not(:first-child) {
                margin-top: 10px;
                margin-bottom: 120px;
            }

            table {
                border-collapse: collapse;
                margin-top: 20px;
                /* width: 100%; */
            }

            thead {
                display: table-header-group;
            }

            tbody tr {
                page-break-inside: avoid;
            }

            th,
            td {
                padding: 10px;
                /* Updated padding */
                font-size: 10px;
            }

            th {
                background-color: #f2f2f2;
            }

            /* Hide specific elements when printing */
            .no-print {
                display: none !important;
            }

            /* Hide browser print header and footer */
            body::before,
            body::after {
                content: none !important;
            }

            /* Hide header and footer for print */
            header,
            footer {
                display: none;
            }
        }

        /* Regular table styles */
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 10px;
            /* Updated padding */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Specific width for Description column */
        .description-column {
            width: 25px !important;
            /* Sets the width for Description column */
        }

        header {
            margin-bottom: 30px;
        }

        img {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 25px;
            right: 0;
            margin: auto;
        }

        img.logo_image {
            display: flex;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
        <img align='center' src="C:\xampp\htdocs\yeocha_main\assets\images\default_images\yeotrack_logo.png"
            width="200"
            height="100"
            style="border-radius: 50%; border: 0; object-fit: cover;"
            alt="Yeotrack Logo" class="logo_image"/>
        <h1 style="margin: 0; padding: 0; line-height: 1.8; font-size: 14px; color: black; text-align: center;">
            Yeotrack
        </h1>
    </div>


    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Position</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Birthday</th>
                <th>Age</th>
                <th>Start Date</th>
                <th>Date Created</th>
                <th>Date Updated</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include '../config/connect.php';

            error_reporting(0);
            session_start();

            $id = $_SESSION["user_id_admin"];
            $sessionId = $id;
            $user_list_query = "SELECT * FROM `users` WHERE `user_id` != $sessionId && `status` = 'ACTIVE' && `role` != 'Supplier' ORDER BY `user_id` DESC";
            $user_list_result = mysqli_query($conn, $user_list_query);

            if (mysqli_num_rows($user_list_result) > 0) {
                while ($user = mysqli_fetch_array($user_list_result)) {

            ?>
                    <td><?= $user["username"]; ?></td>
                    <td><?= $user["role"]; ?></td>
                    <td><?= $user["firstname"]; ?></td>
                    <td><?= $user["lastname"]; ?></td>
                    <td><?= $user["email"]; ?></td>
                    <td style="width: 200px;"><?= "+639" . substr_replace($user['phone'], "", 0, 4); ?></td>
                    <td><?= $user["address"]; ?></td>
                    <td><?= $user["birthday"]; ?></td>
                    <td><?= $user["age"]; ?></td>
                    <td><?= $user["start_date"] ? $user["start_date"] : '0000-00-00 00:00:00' ?></td>
                    <td><?= $user["date_created_at"] ? $user["date_created_at"] : '0000-00-00 00:00:00' ?></td>
                    <td><?= $user["date_updated_at"] ? $user["date_updated_at"] : '0000-00-00 00:00:00' ?></td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>

    <div style="align-items: right;flex-direction: column;height: 100%; text-align: right;right: 25px; padding-top: 50px;">
        <?php
        $user_query = "SELECT * FROM `users` WHERE `user_id` = '" . $_SESSION["user_id_admin"] . "' ORDER BY `user_id` DESC";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_array($user_result);

        if (is_array($user)) { ?>
            <?php if (empty($user['signature'])) { ?>
                <img src="C:\xampp\htdocs\yeocha_main\assets\images\default_images\your_signature.png" width='120' height='120' style="opacity: 50%; border: 0; object-fit: cover;" />
            <?php } else { ?>
                <img src="C:\xampp\htdocs\yeocha_main\assets\images\images\signature_images\<?php echo $user["signature"]; ?>" width='120' height='120' style="opacity: 50%; border: 0; object-fit: cover;" />
        <?php }
        } ?>
        <h5 style="margin: 0; padding: 0; line-height: 1.8; font-size: 14px; color: black;">
            <span style="color: black;"><?php echo $user["firstname"] ?></span> <span style="color: black;"><?php echo $user["lastname"] ?></span>
        </h5>
        <h1 style="margin: 0;padding: 0;line-height: 1.8;font-size: 14px;color: blue;">
            <span style="color: black; font-weight: 900; border-top: solid 1px #000; width: 200px;">Report Owner By</span>
        </h1>
    </div>

</body>

</html>