<!-- UI only -->

<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session
$id = $_SESSION["user_id_admin"];

$sessionId = $id;

$valid_user = "SELECT * FROM `users` WHERE `user_id` = '" . $sessionId . "' && `role` != 'Admin'";
$check_user = mysqli_query($conn, $valid_user);

if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
    header("Location: ../index.php");
    session_destroy();
} else
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = $sessionId"));

?>


<?php include "../include/user_meta.php"; ?>

<title>Dashboard</title>

<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>
<?php include "../include/sidebar_admin.php"; ?>

<main id="main" class="main">
  <h3 class="text-center">DELIVERIES</h3>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Order Code</th>
      <th scope="col">Amount</th>
      <th scope="col">Store</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody class="text-center">
    <tr>
      <td class="fw-normal text-center">NGSWHD</td>
      <td class="fw-normal text-center">500.00</td>
      <td class="fw-normal text-center">Subzero</td>
      <td class="fw-normal text-center">In Transit</td>
    </tr>
    <tr>
      <th class="fw-normal text-center">ASDFG</th>
      <td class="fw-normal text-center">351.00</td>
      <td class="fw-normal text-center">R&R</td>
      <td class="fw-normal text-center">To Pack</td>
    </tr>
    <tr>
      <td class="fw-normal text-center">GWERTY</th>
      <td class="fw-normal text-center">765.00</td>
      <td class="fw-normal text-center">SubZero</td>
      <td class="fw-normal text-center">In Transit</td>
    </tr>
    <tr>
      <td class="fw-normal text-center">ZXCVBN</th>
      <td class="fw-normal text-center">530.00</td>
      <td class="fw-normal text-center">SubZero</td>
      <td class="fw-normal text-center">To Ship</td>
    </tr>
  </tbody>
</table>



</main>




<?php include "../include/user_footer.php"; ?>
<?php include "../include/user_bottom.php"; ?>