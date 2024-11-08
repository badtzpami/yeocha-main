<?php
include '../config/connect.php';

error_reporting(0);
session_start();

// User's session

if ($_SESSION["user_id_admin"] != '') {
  $id = $_SESSION["user_id_admin"];
  $user_role = 'Admin';
} else if ($_SESSION["user_id_cashier"] != '') {
  $id = $_SESSION["user_id_cashier"];
  $user_role = 'Cashier';
} else if ($_SESSION["user_id_employee"] != '') {
  $id = $_SESSION["user_id_employee"];
  $user_role = 'Employee';
} else {
  $id = $_SESSION["user_id_supplier"];
  $user_role = 'Supplier';
}


$sessionId = $id;

$valid_user = "SELECT * FROM `users` WHERE `user_id` = '" . $sessionId . "' && `role` != '" . $user_role . "'";
$check_user = mysqli_query($conn, $valid_user);

if (!isset($sessionId) || mysqli_num_rows($check_user) < 0) {
  header("Location: ../user_signin/signin.php");
  session_destroy();
} else
  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `user_id` = $sessionId"));

?>


<?php include "../include/user_meta.php"; ?>

<title>User Profile</title>
<style>
  /* Container for the progress bar */
  .progress-div {
    display: none;
    /* Hidden by default, shown when needed */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    /* Adjust width as necessary */
    background-color: rgba(115, 132, 165, 0.678);
    /* Light background color */
    border: 1px solid #ccc;
    /* Border with a light gray color */
    border-radius: 5px;
    /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    /* Subtle shadow */
    padding: 20px;
    /* Padding inside the box */
    text-align: center;
    z-index: 1000;
    /* Make sure it's above other elements */
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  /* Message text above the progress bar */
  #progress_msg {
    color: #fff;
    font-weight: 500;
    font-family: 'Poppins-Regular', sans-serif;
    text-transform: uppercase;
    letter-spacing: 1px;

    margin-bottom: 10px;
    /* Space between message and progress bar */
    font-size: 16px;
  }

  /* Container for the progress bar itself
.progress-container {
  width: 50%;
  background-color: #e0e0e0;
  /* Light gray background for the bar */
  /* border-radius: 5px;
  overflow: hidden; */
  /* Ensures the progress bar stays within the rounded corners */
  /* } */

  /* The progress bar */
  .progress-bar {
    /* height: 20px; */
    /* Height of the progress bar */
    /* width: 0%; */
    /* Start at 0% width, will be animated */
    /* background-color: #052d5a; */
    /* Green color */
    /* border-radius: 5px;
  transition: width 1s ease-in-out; */
    /* Smooth transition for width changes */
  }

  /* @keyframes progress {
  from {
      width: 0;
  }

  to {
      width: 100%;
  }
}  */

  .progress-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: linear-gradient(45deg, #421710, #000);
    display: flex;
    justify-content: top;
    align-items: top;
    z-index: 9999;
  }

  .progress-circle {
    display: flex;
    justify-content: top;
    align-items: top;
    width: 150px;
    height: 150px;
    /* background-color: rgba(255, 255, 255, 0.8); */
    border-radius: 50%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    /* Keep it relative for z-index control */
    z-index: 10000;
  }

  .progress-value {
    position: absolute;
    top: 65px;
    left: 64px;
    font-weight: bold;
    color: #333;
    font-family: 'Montserrat', sans-serif;
    z-index: 10001;
    /* Make sure it's on top of everything */
  }


  .progress-ring {
    position: absolute;
    transform: rotate(-90deg);
  }

  .progress-ring__circle {
    transition: stroke-dasharray 0.5s;
    stroke-dasharray: 0 327;
    stroke-linecap: round;
  }

  /* For making the stroke visible with a background color */
  circle {
    stroke: darkred;
  }

  .progress-value {
    position: absolute;
    font-size: 14px;
    font-weight: bold;
    color: #333;
    font-family: 'Montserrat', sans-serif;
    z-index: 10001;
    /* Make sure it's on top of everything */
  }


  .progress-ring {
    position: absolute;
    transform: rotate(-90deg);
  }

  .progress-ring__circle {
    transition: stroke-dasharray 0.5s;
    stroke-dasharray: 0 327;
    stroke-linecap: round;
  }

  /* For making the stroke visible with a background color */
  circle {
    stroke: black;
  }

  .message-box {
    position: fixed;
    /* Fixes it relative to the viewport */
    top: 20px;
    /* Distance from the top */
    right: 20px;
    /* Distance from the right */
    z-index: 1000;
    /* Ensures it is in front of other elements */
    background-color: white;
    /* Background color */
    border: 1px solid #ccc;
    /* Border styling */
    border-radius: 5px;
    /* Rounded corners */
    padding: 15px;
    /* Inner spacing */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    /* Subtle shadow */
  }

  .close-btn {
    display: flex;
    align-items: right;
    border: 0;
    top: 0;
    right: 1px;
    margin: 10px;
  }
</style>
<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>

<?php
if ($user['role'] == 'Admin') { ?>
  <?php include "../include/sidebar_admin.php"; ?>
<?php } else if ($user['role'] == 'Cashier') { ?>
  <?php include "../include/sidebar_cashier.php"; ?>
<?php } else if ($user['role'] == 'Employee') { ?>
  <?php include "../include/sidebar_employee.php"; ?>
<?php } else { ?>
  <?php include "../include/sidebar_supplier.php"; ?>
<?php } ?>

<!-- Message Box -->
<div class="message-box" id="messageBox" style="display: none;">
  <div class="close-btn" id="closeBtn">
    <button type="button" class="close mr-1" style="border:0; background: none;" aria-label="Close">
      <span aria-hidden="true" style="border:0; font-size: 22px;">&times;</span>
    </button>
  </div>
  <i id="logo_msg"></i>
  <p id="new_msg"></p>
  <div class="loading-bar-container">
    <div class="loading-bar" id="loadingBar"></div>
  </div>
</div>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <?php
          if ($user['role'] == 'Admin') { ?>
            <a href="../admin/dashboard.php">Home</a>
          <?php } else if ($user['role'] == 'Cashier') { ?>
            <a href="../cashier/dashboard.php">Home</a>
          <?php } else if ($user['role'] == 'Employee') { ?>
            <a href="../employee/dashboard.php">Home</a>
          <?php } else { ?>
            <a href="../supplier/user_item.php">Home</a>
          <?php } ?>

        </li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-5 d-flex flex-column align-items-center">
            <!-- <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->

            <?php

            $id = $user["user_id"];
            $name = $user["firstname"];
            $image = $user["image"];

            if (is_array($user)) { ?>
              <?php if (empty($user['image'])) { ?>
                <img src="../assets/images/default_images/profile_picture.jpeg" width=240 height=155 title="profile" style="width: 220px; border-radius: 50%;">
              <?php } else { ?>
                <img src="../assets/images/user_images/<?php echo $image; ?>" width=240 height=155 title="<?php echo $image; ?>" style="width: 220px; border-radius: 50%;">
            <?php }
            } ?>
            <h2><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h2>
            <h3><?php echo $user['role']; ?></h3>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">

            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Edit Profile</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#signature-settings">Edit Signature</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Information</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>


            </ul>

            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">About</h5>
                <p class="small fst-italic"><?php echo $user['about'] ? $user['about'] : 'Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.'; ?></p>

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?php echo $user['firstname'] . " " . $user['lastname']; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8"><?php echo $user['address']; ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8">+639 <?php echo $user['phone'] = substr_replace($user['phone'], "", 0, 4); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?php echo $user['email']; ?></div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Birthday</div>
                  <div class="col-lg-9 col-md-8"><?php echo $user['birthday']; ?></div>
                </div>


                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Age</div>
                  <div class="col-lg-9 col-md-8"><?php echo $user['age']; ?></div>
                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-settings">

                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                <div class="col-12">

                  <form class="form col-md-8 col-lg-8" id="profile_form" action="" enctype="multipart/form-data" method="post">
                    <div class="profile_upload">
                      <?php
                      if (is_array($user)) { ?>
                        <?php if (empty($user['image'])) { ?>
                          <img src="../assets/images/default_images/profile_picture.jpeg" width=160 height=160 title="profile">
                        <?php } else { ?>
                          <img src="../assets/images/user_images/<?php echo $image; ?>" width=160 height=160 title="<?php echo $image; ?>">
                      <?php }
                      } ?>
                      <div class="round mt-5 ">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="name" value="<?php echo $name; ?>">
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                        <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                      </div>
                    </div>
                  </form>

                </div>

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="signature-settings">
                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Signature Image</label>

                <!-- Signature Edit Form -->
                <form class="signature col-md-8 col-lg-8" id="signature" action="" enctype="multipart/form-data" method="post">
                  <div class="upload_signature">
                    <?php
                    $id_signature = $user["user_id"];
                    $name_signature = $user["firstname"] . $user["lastname"];
                    $image_signature = $user["signature"];

                    if (is_array($user)) { ?>
                      <?php if (empty($user['signature'])) { ?>
                        <img src="../assets/images/default_images/your_signature.png" width=180 height=180 title="profile">
                      <?php } else { ?>
                        <img src="../assets/images/signature_images/<?php echo $image_signature; ?>" width=160 height=160 title="<?php echo $image_signature; ?>">
                    <?php }
                    } ?>
                    <div class="round_signature">
                      <input type="hidden" name="id_signature" value="<?php echo $id_signature; ?>">
                      <input type="hidden" name="name_signature" value="<?php echo $name_signature; ?>">
                      <input type="file" name="image_signature" id="image_signature" accept=".jpg, .jpeg, .png">
                    </div>
                  </div>
                </form><!-- End Signature Edit Form -->

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form id="editInfo" action="" method="post">
                  <input type="hidden" name="id" id="id" value="<?php echo $user['user_id'] ?>">

                  <div class="row mb-3">
                    <label for="userName" class="col-md-4 col-lg-3 col-form-label">User Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="username" readonly value="<?php echo $user['username']; ?>" placeholder="Enter your user name">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="firstname" value="<?php echo $user['firstname']; ?>" placeholder="Enter your first name">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="lastname" value="<?php echo $user['lastname']; ?>" placeholder="Enter your last name">
                    </div>
                  </div>



                  <!-- <?php if ($user['role'] == 'Supplier') { ?>
                    <div class="row mb-3">
                      <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" name="store" value="<?php echo $user['store']; ?>" placeholder="Enter your store name">
                      </div>
                    </div>
                  <?php } ?> -->


                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea class="form-control" name="about" style="height: 100px"><?php echo $user['about']; ?></textarea>
                    </div>
                  </div>


                  <div class="row mb-3">
                    <label for="Job" class="col-md-4 col-lg-3 col-form-label">Job</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" readonly class="form-control" name="role" value="<?php echo $user['role']; ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="address" value="<?php echo $user['address']; ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-2 col-lg-2">
                      <input type="text" class="form-control" name="phone1" value="+639" readonly>
                    </div>
                    <div class="col-md-7 col-lg-7">
                      <input type="text" class="form-control" name="phone2" placeholder="123456789" value="<?php echo $user['phone'] = substr_replace($user['phone'], "", 0, 0); ?>" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                  </div>


                  <div class="row mb-3">
                    <label for="Birthday" class="col-md-4 col-lg-3 col-form-label">Birthday</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="date" class="form-control" name="birthday" value="<?php echo $user['birthday']; ?>">
                    </div>
                  </div>


                  <div class="row mb-3">
                    <label for="Birthday" class="col-md-4 col-lg-3 col-form-label">Age</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" class="form-control" name="age" value="<?php echo $user['age']; ?>">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form class="forms-sample mt-5" id="changePassword">
                  <input type="hidden" name="pass_id" id="pass_id" value="<?php echo $user['user_id'] ?>">

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="password" id="password" class="form-control" id="currentPassword" autocomplete="current-password">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="newpassword1" id="newpassword1" class="form-control" id="newPassword" autocomplete="new-password">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="newpassword2" id="newpassword2" class="form-control" id="renewPassword" autocomplete="new-password">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->
              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->




<script>
  // Function to show the custom message box
  function showMessageBox(title, message, icon) {
    // Update the message box content

    $('#new_msg').html(`<div class="alert alert-info" role="alert" style="font-size: 16px;"><strong><span>${title}</span></strong><br><span>${message}</span></div>`);

    // Optionally, set different styles based on the icon
    if (icon === 'success') {
      $('#message').css('color', 'green');
      $('#logo_msg').css('color', 'green');
      $('#logo_msg').css('font-size', '52px');
      $('#logo_msg').css('display', 'flex');
      $('#logo_msg').css('justify-content', 'center');
      $('#logo_msg').css('text-align', 'center');
      $('#logo_msg').css('margin-bottom', '22px');
      $('#logo_msg').attr('class', 'bi bi-check-circle-fill'); // Set class for success
      $('#loadingBar').css('background-color', 'green');
    } else if (icon === 'warning') {
      $('#message').css('color', 'orange');
      $('#logo_msg').css('color', 'orange');
      $('#logo_msg').css('font-size', '52px');
      $('#logo_msg').css('display', 'flex');
      $('#logo_msg').css('justify-content', 'center');
      $('#logo_msg').css('text-align', 'center');
      $('#logo_msg').css('margin-bottom', '22px');
      $('#logo_msg').attr('class', 'bi bi-exclamation-circle-fill'); // Set class for success
      $('#loadingBar').css('background-color', 'orange');
    } else {
      $('#message').css('color', 'red');
      $('#logo_msg').css('color', 'red');
      $('#logo_msg').css('font-size', '52px');
      $('#logo_msg').css('display', 'flex');
      $('#logo_msg').css('justify-content', 'center');
      $('#logo_msg').css('text-align', 'center');
      $('#logo_msg').css('margin-bottom', '22px');
      $('#logo_msg').attr('class', 'bi bi-dash-circle-fill'); // Set class for success
      $('#loadingBar').css('background-color', 'red');
    }

    // Show the message box
    $('#messageBox').show();

    // Hide the message box after 4 seconds (adjust as needed)
    setTimeout(function() {
      $('#messageBox').fadeOut();
    }, 10000);
  }



  // Close message box on clicking the close button
  $('#closeBtn').on('click', function() {
    $('#messageBox').fadeOut();
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    $(document).ready(function() {

      // new form update
      $(document).on('submit', '#editInfo', function(e) {
        e.preventDefault();
        // alert("äw");
        var formData = new FormData(this);
        formData.append("update_user_information", true);

        $.ajax({
          url: '../user_process/user_profile_process.php',
          type: 'POST',
          data: formData,
          contentType: false, // Important for file uploads
          processData: false, // Important for file uploads
          success: function(res_info) {

            console.log("Response:", res_info); // Log the raw response

            var res = jQuery.parseJSON(res_info);

            if (res.success == 200) {
              showMessageBox(res.title, res.message, 'success');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            } else if (res.success == 400) {
              showMessageBox(res.title, res.message, 'warning');

            } else {
              showMessageBox(res.title, res.message, 'warning');
            }
          },
          error: function(error) {
            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
            console.log('error', error);
          }
        });
      });
    });



    $(document).ready(function() {

      // new form update
      $(document).on('submit', '#changePassword', function(e) {
        e.preventDefault();
        // alert("äw");
        var formData = new FormData(this);
        formData.append("update_user_password", true);

        $.ajax({
          url: '../user_process/user_profile_process.php',
          type: 'POST',
          data: formData,
          contentType: false, // Important for file uploads
          processData: false, // Important for file uploads
          success: function(res_pass) {

            console.log("Response:", res_pass); // Log the raw response

            var res = jQuery.parseJSON(res_pass);

            if (res.success == 200) {
              showMessageBox(res.title, res.message, 'success');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            } else if (res.success == 400) {
              showMessageBox(res.title, res.message, 'warning');

            } else {
              showMessageBox(res.title, res.message, 'warning');

            }
          },
          error: function(error) {
            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
            console.log('error', error);
          }
        });
      });
    });





    $(document).ready(function() {
      $('#image').on('change', function() {
        $('#profile_form').submit(); // Automatically submit the form on file selection
      });

      $('#profile_form').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this); // Create a FormData object

        $.ajax({
          url: '../user_process/user_profile_process.php',
          type: 'POST',
          data: formData,
          contentType: false, // Important for file uploads
          processData: false, // Important for file uploads
          success: function(response) {
            var res = jQuery.parseJSON(response);

            if (res.success == 100) {
              showMessageBox(res.title, res.message, 'success');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            } else {
              showMessageBox(res.title, res.message, 'warning');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            }
          },
          error: function(error) {
            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
            console.log('error', error);
          }
        });
      });
    });


    $(document).ready(function() {
      $('#image_signature').on('change', function() {
        $('#signature').submit();
      });

      $('#signature').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this); // Create a FormData object

        $.ajax({
          url: '../user_process/user_signature_process.php',
          type: 'POST',
          data: formData,
          contentType: false, // Important for file uploads
          processData: false, // Important for file uploads
          success: function(response) {
            console.log(response); // Log the response

            var res = jQuery.parseJSON(response);

            if (res.success == 100) {
              showMessageBox(res.title, res.message, 'success');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            } else {
              showMessageBox(res.title, res.message, 'warning');
              setTimeout(function() {
                location.href = '/yeocha_main/include/user_profile.php';
              }, 8000);
            }
          },
          error: function(error) {
            showMessageBox("Error", "An unexpected error occurred. Please try again.", "error");
            console.log('error', error);
          }
        });
      });
    });
  });
</script>




<?php include "../include/user_footer.php"; ?>
<?php include "../include/user_bottom.php"; ?>

<!-- 
<script type="text/javascript">
  document.getElementById("image_signature").onchange = function() {
    document.getElementById("signature").submit();
  };
</script> -->