<?php include 'config/config.php';

error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>CFOS</title>
    <link href="images/logo/cfoss.png" rel="icon">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Favicons -->
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="css/page.css" rel="stylesheet">

    <!-- /////////////////////////////////////////////////////////////////////// -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <!-- <link rel="stylesheet" href="css/product.css"> -->

    <link href="css/page.css" rel="stylesheet">

    <link rel="stylesheet" href="css/slider.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- custom js file link  -->
    <script src="js/category_button.js" defer></script>
    <script src="js/search.js" defer></script>
    <script src="js/quantity.js" defer></script>

    <!-- /////////////////////////////////////////// -->

    <!-- Stylesheet -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <link href="css/checkout.css" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <!-- FontAwesome 4.7.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'include/user_header.php'; ?>


    <!-- ======= hero Section ======= -->
    <section id="top" style="background-color: #000;padding: 35px;">
    </section><!-- End Hero Section -->

    <main id="main">

        <form id="addOrder">

            <div style="width: 100%; padding: 30px 50px; background: #eee; ">
                <?php $sql_cd = "SELECT * FROM `users_orders`";
                $res_cd = mysqli_query($db, $sql_cd);

                if (mysqli_num_rows($res_cd) > 0) {
                    while ($ftch = mysqli_fetch_array($res_cd)) {
                        $randString = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 8);
                        if ($ftch['order_numbers'] != $randString) {
                            $newcode = $randString;
                        }
                    }
                }
                ?>
                <div class="checkout bg-white" style="width: 100%; height: auto; ">
                    <h1 class="heading">
                        <ion-icon name="cart-outline"></ion-icon> ORDER CODE </br><input type="text" name="code[]" style="color:#8f00ff; border: none; outline:none; width: 200px;" placeholder="" value="<?php echo $randString; ?>" readonly>
                    </h1>

                    <div class="item-flex">

                        <section class="checkout">

                            <h2 class="section-heading">Payment Details</h2>

                            <div class="payment-form">

                                <div class="payment-method">

                                    <button class="method selected">
                                        <ion-icon name="card"></ion-icon>

                                        <span>Cash</span>

                                        <ion-icon class="checkmark fill" name="checkmark-circle"></ion-icon>
                                    </button>

                                </div>

                                <form action="#">

                                    <?php
                                    $id = $_SESSION['user_id'];
                                    $user = "SELECT * FROM `users` WHERE u_id = $id";
                                    $res_user = mysqli_query($db, $user);
                                    $user = mysqli_fetch_array($res_user);
                                    $u_id = $user['u_id'];
                                    $firstname = $user['firstname'];
                                    $lastname = $user['lastname'];
                                    $email = $user['email'];
                                    $phone = $user['phone'];

                                    $s_id = $user['s_id'];

                                    ?>
                                    <div class="cardholder-name">
                                        <label for="cardholder-name" class="label-default">Customer Name</label>
                                        <input type="text" name="cardholder-name" value="<?php echo $user['firstname'] . " " . $user['lastname']; ?>" id="cardholder-name" class="input-default" readonly>
                                    </div>

                                    <div class="cardholder-name">
                                        <label for="cardholder-name" class="label-default">School Address</label>
                                        <input type="text" name="cardholder-name" value="<?php echo $canteen['school_name'] ?>" id="cardholder-name" class="input-default" readonly>
                                    </div>

                                    <div class="cardholder-name">
                                        <label for="cardholder-name" class="label-default">Room Location</label>
                                        <input type="text" name="cardholder-name" value="<?php echo $user['location']; ?>" id="cardholder-name" class="input-default" readonly>
                                    </div>
                                    <h2 class="section-heading">Contact Details</h2>

                                    <div class="cardholder-name">
                                        <label for="cardholder-name" class="label-default">Email</label>
                                        <input type="text" name="cardholder-name" value="<?php echo $user['email']; ?>" id="cardholder-name" class="input-default" readonly>
                                    </div>
                                    <div class="cardholder-name">
                                        <label for="cardholder-name" class="label-default">Contact Number</label>
                                        <div class="col-sm-3"></div>

                                        <input type="text" name="extra_number" value="<?php echo $user['phone']; ?>" id="cardholder-name" class="input-default" readonly>
                                    </div>

                                </form>

                            </div>

                            <button id="mybutton" class="btn btn-primary">
                                <b>Place Order</b> $ <span id="payAmount"></span>
                            </button>



                        </section>

                        <section class="cart">

                            <div class="cart-item-box">

                                <h2 class="section-heading">Order Summery</h2>


                                <?php $checked_array1 = $_POST['chck1'];
                                $sql_canteen1 = "SELECT * FROM `canteen` WHERE s_id = 1";
                                $res_canteen1 = mysqli_query($db, $sql_canteen1);
                                $canteen1 = mysqli_fetch_array($res_canteen1);
                                if ($checked_array1 != 0) { ?>

                                    <h6><?php echo $canteen1['school_name']; ?></h6>
                                <?php } else {
                                    echo '';
                                } ?>



                                <?php
                                foreach ($_POST['prodname1'] as $key1 => $value1) {
                                    if (in_array($_POST['prodname1'][$key1], $checked_array1)) {
                                        $prodname1 = $_POST['prodname1'][$key1];
                                        $prodid1 = $_POST['prodid1'][$key1];
                                        $prod_price1 = $_POST['prod_price1'][$key1];
                                        $prod_qty1 = $_POST['prod_qty1'][$key1];
                                        $final_prod = $final_prod + $prod_qty1;
                                        $prod_sum1 = $prod_qty1 * $prod_price1;
                                        $total_sum1 += $prod_sum1;

                                        $canteen1 = "SELECT * FROM `canteen` WHERE s_id = 1";
                                        $res_canteen1 = mysqli_query($db, $canteen1);
                                        $canteen1 = mysqli_fetch_array($res_canteen1);

                                        $school_name1 = $canteen1['school_name'];
                                        $school_address1 = $canteen1['address'];
                                        $school_phone1 = $canteen1['phone'];
                                ?>
                                        <?php $sql_order1 = "SELECT * FROM `dishes` WHERE d_id = '" . $prodid1 . "'";
                                        $res_order1 = mysqli_query($db, $sql_order1);
                                        $order1 = mysqli_fetch_array($res_order1);
                                        $stock = $order1['stock'] - $prod_qty1;
                                        if ($checked_array1 != 0) { ?>

                                            <?php
                                            $id = $_SESSION['user_id'];
                                            $loginquery = "SELECT * FROM `users` WHERE u_id = $id";
                                            $result = mysqli_query($db, $loginquery);
                                            $row = mysqli_fetch_array($result);

                                            if ($row['s_id'] == 2) {
                                                date_default_timezone_set('Asia/Manila');
                                                $hour = date("h");
                                                $minute = date("i");
                                                if ($minute == '00' || $minute == 0) {
                                                    $new_minute = '00';

                                                    $new_hour = $hour + 1;
                                                } else {
                                                    $minute1 = 60 - $minute;
                                                    $new_minute = 60 - $minute1;
                                                    $new_hour = $hour + 1;
                                                }
                                                $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                            ?>
                                                <div style="text-align: right;">
                                                    <?php
                                                    echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                                    echo "Today: " .  date("d M"); ?>
                                                </div>
                                            <?php } else {


                                                date_default_timezone_set('Asia/Manila');
                                                $hour = date("h");
                                                $minute = date("i");
                                                if ($minute == '00' || $minute == 0) {
                                                    $new_minute = '00';

                                                    $new_hour = $hour + 1;
                                                } else {
                                                    $minute_left = 60 - $minute;
                                                    $new_minute = 60 - $minute_left;
                                                    $new_minute = $new_minute + 30;
                                                    if ($new_minute > 60) {
                                                        $new_minute = $new_minute - 60;
                                                        $new_hour = $hour + 2;
                                                    } else {

                                                        $new_hour = $hour + 1;
                                                    }
                                                }
                                            }
                                            $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                            ?>



                                            <!-- /////////// -->
                                            <div class="product-card">

                                                <div class="card">

                                                    <div class="img-box" style="padding: 10px;">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <img src="images/dishes/<?= $order1['d_image']; ?>" alt="Green tomatoes" style="width:50px; height:50px;" class="product-img">
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <?php echo $order1['dishes_name'] . "</br> X " . $prod_qty1;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P<?php echo $prod_price1; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="text-align: right;">
                                                            <div class="col-sm-8"></div>
                                                            <div class="col-sm-4"><b>P <?php echo $prod_sum1; ?></b></div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                            <input type="hidden" name="chck[]" value="<?php echo $order1['dishes_name']; ?>">
                                            <input type="hidden" name="prodid[]" value="<?= $order1['d_id']; ?>">
                                            <input type="hidden" name="prodname[]" value="<?= $order1['dishes_name']; ?>">
                                            <input type="hidden" name="prod_price[]" value="<?= $order1['selling_price']; ?>">
                                            <input type="hidden" name="prod_qty[]" value="<?php echo $prod_qty1; ?>">
                                            <input type="hidden" name="code[]" style="color:#8f00ff; border: none; outline:none; width: 200px;" value="<?php echo $randString; ?>">

                                            <input type="hidden" name="s_id[]" value="1">
                                            <input type="hidden" name="school_name[]" value="<?php echo $school_name1; ?>">
                                            <input type="hidden" name="school_address[]" value="<?php echo $school_address1; ?>">
                                            <input type="hidden" name="school_phone[]" value="<?php echo $school_phone1; ?>">
                                            <input type="hidden" name="u_id[]" value="<?php echo $u_id; ?>">

                                            <input type="hidden" name="firstname[]" value="<?php echo $firstname; ?>">
                                            <input type="hidden" name="lastname[]" value="<?php echo $lastname; ?>">
                                            <input type="hidden" name="email[]" value="<?php echo $email; ?>">
                                            <input type="hidden" name="phone[]" value="<?php echo $phone; ?>">
                                            <input type="hidden" name="status[]" value="Check Out">
                                            <input type="hidden" name="stock[]" value="<?php echo $stock; ?>">
                                            <input type="hidden" name="time_arrival[]" value="<?php echo $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a"); ?>">
                                            <input type="hidden" name="day_arrival[]" value="<?php echo date("d M"); ?>">

                                            <input type="hidden" id="money1" name="cash[]">
                                            <input type="hidden" id="change1" name="change[]">
                                            <input type="hidden" id="ordered3" name="ordered[]">


                                            <script>
                                                function cash1(value1) {
                                                    var order1 = document.getElementById("ordered1").value;
                                                    total1 = 0;
                                                    document.getElementById("money1").value = value1;
                                                    total1 = value1 - order1;
                                                    if (total1 > 0) {
                                                        document.getElementById("received1").value = total1;
                                                        document.getElementById("change1").value = total1;
                                                        document.getElementById("ordered3").value = order1;
                                                    } else {
                                                        document.getElementById("received1").value = 0;
                                                        document.getElementById("change1").value = 0;
                                                    }
                                                }
                                            </script>


                                    <?php  } else {
                                            echo '';
                                        }
                                    }
                                }
                                if ($checked_array1 != 0) { ?>

                                    <h6>Cash: <input type="text" onkeyup="cash1(this.value)" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;"></h6>
                                    <h6>Change: <input type="text" id="received1" name="change1[]" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;"></h6>
                                    <h6>Order Total: <input type="text" id="ordered1" value="<?php echo $total_sum1; ?>" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;" readonly></h6>
                                    <?php
                                    $id = $_SESSION['user_id'];
                                    $loginquery = "SELECT * FROM `users` WHERE u_id = $id";
                                    $result = mysqli_query($db, $loginquery);
                                    $row = mysqli_fetch_array($result);

                                    if ($row['s_id'] == 1) {

                                        $tax1 = 0;
                                        date_default_timezone_set('Asia/Manila');
                                        $hour = date("h");
                                        $minute = date("i");
                                        if ($minute == '00' || $minute == 0) {
                                            $new_minute = '00';

                                            $new_hour = $hour + 1;
                                        } else {
                                            $minute1 = 60 - $minute;
                                            $new_minute = 60 - $minute1;
                                            $new_hour = $hour + 1;
                                        } ?>
                                        <div style="text-align: right;">
                                            <?php
                                            echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                            echo "Today: " .  date("d M"); ?>
                                        </div>
                                    <?php } else {
                                        $tax1 = 17;
                                        if ($final_prod == 1) {
                                            $tax1 = $tax1;
                                        } elseif ($final_prod > 2 && $final_prod < 5) {
                                            $tax1 = $tax1 + 20;
                                        } elseif ($final_prod > 6 && $final_prod < 10) {
                                            $tax1 = $tax1 + 40;
                                        } elseif ($final_prod > 11 && $final_prod < 15) {
                                            $tax1 = $tax1 + 60;
                                        } elseif ($final_prod > 16 && $final_prod < 25) {
                                            $tax1 = $tax1 + 80;
                                        }
                                        date_default_timezone_set('Asia/Manila');
                                        $hour = date("h");
                                        $minute = date("i");
                                        if ($minute == '00' || $minute == 0) {
                                            $new_minute = '00';

                                            $new_hour = $hour + 1;
                                        } else {
                                            $minute_left = 60 - $minute;
                                            $new_minute = 60 - $minute_left;
                                            $new_minute = $new_minute + 30;
                                            if ($new_minute > 60) {
                                                $new_minute = $new_minute - 60;
                                                $new_hour = $hour + 2;
                                            } else {

                                                $new_hour = $hour + 1;
                                            }
                                        }
                                        $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                    ?>
                                        <div style="text-align: right;">
                                            <?php
                                            echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                            echo "Today: " .  date("d M"); ?>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '';
                                }   ?>
                            </div>
                            <div class="cart-item-box">
                                <?php $checked_array2 = $_POST['chck2'];
                                $sql_canteen2 = "SELECT * FROM `canteen` WHERE s_id = 2";
                                $res_canteen2 = mysqli_query($db, $sql_canteen2);
                                $canteen2 = mysqli_fetch_array($res_canteen2);
                                if ($checked_array2 != 0) { ?>

                                    <h6><?php echo $canteen2['school_name']; ?></h6>
                                <?php } else {
                                    echo '';
                                } ?>
                                <?php
                                foreach ($_POST['prodname2'] as $key2 => $value2) {
                                    if (in_array($_POST['prodname2'][$key2], $checked_array2)) {
                                        $prodname2 = $_POST['prodname2'][$key2];
                                        $prodid2 = $_POST['prodid2'][$key2];
                                        $prod_price2 = $_POST['prod_price2'][$key2];
                                        $prod_qty2 = $_POST['prod_qty2'][$key2];



                                        $prod_sum2 = $prod_qty2 * $prod_price2;
                                        $total_sum2 += $prod_sum2;


                                        $canteen2 = "SELECT * FROM `canteen` WHERE s_id = 2";
                                        $res_canteen2 = mysqli_query($db, $canteen1);
                                        $canteen2 = mysqli_fetch_array($res_canteen2);

                                        $school_name2 = $canteen2['school_name'];
                                        $school_address2 = $canteen2['address'];
                                        $school_phone2 = $canteen2['phone'];
                                ?>


                                        <?php $sql_order2 = "SELECT * FROM `dishes` WHERE d_id = '" . $prodid2 . "'";
                                        $res_order2 = mysqli_query($db, $sql_order2);
                                        $order2 = mysqli_fetch_array($res_order2);
                                        $stock = $order2['stock'] - $prod_qty2;

                                        if ($checked_array2 != 0) {
                                            $final_prod = $final_prod + $prod_qty2;
                                        ?>

                                            <!-- /////////// -->
                                            <div class="product-card">

                                                <div class="card">

                                                    <div class="img-box" style="padding: 10px;">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <img src="images/dishes/<?= $order2['d_image']; ?>" alt="Green tomatoes" style="width:50px; height:50px;" class="product-img">
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <?php echo $order2['dishes_name'] . "</br> X " . $prod_qty2;  ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P<?php echo $prod_price2; ?>
                                                            </div>
                                                        </div>
                                                        <div class="row" style="text-align: right;">
                                                            <div class="col-sm-8"></div>
                                                            <div class="col-sm-4"><b>P <?php echo $prod_sum2; ?></b></div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                            <?php
                                            $id = $_SESSION['user_id'];
                                            $loginquery = "SELECT * FROM `users` WHERE u_id = $id";
                                            $result = mysqli_query($db, $loginquery);
                                            $row = mysqli_fetch_array($result);

                                            if ($row['s_id'] == 2) {
                                                date_default_timezone_set('Asia/Manila');
                                                $hour = date("h");
                                                $minute = date("i");
                                                if ($minute == '00' || $minute == 0) {
                                                    $new_minute = '00';

                                                    $new_hour = $hour + 1;
                                                } else {
                                                    $minute1 = 60 - $minute;
                                                    $new_minute = 60 - $minute1;
                                                    $new_hour = $hour + 1;
                                                }
                                                $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                            ?>
                                                <div style="text-align: right;">
                                                    <?php
                                                    echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                                    echo "Today: " .  date("d M"); ?>
                                                </div>
                                            <?php } else {


                                                date_default_timezone_set('Asia/Manila');
                                                $hour = date("h");
                                                $minute = date("i");
                                                if ($minute == '00' || $minute == 0) {
                                                    $new_minute = '00';

                                                    $new_hour = $hour + 1;
                                                } else {
                                                    $minute_left = 60 - $minute;
                                                    $new_minute = 60 - $minute_left;
                                                    $new_minute = $new_minute + 30;
                                                    if ($new_minute > 60) {
                                                        $new_minute = $new_minute - 60;
                                                        $new_hour = $hour + 2;
                                                    } else {

                                                        $new_hour = $hour + 1;
                                                    }
                                                }
                                            }
                                            echo $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                            ?>
                                            <input type="hidden" name="chck[]" value="<?php echo $order2['dishes_name']; ?>">
                                            <input type="hidden" name="prodid[]" value="<?= $order2['d_id']; ?>">
                                            <input type="hidden" name="prodname[]" value="<?= $order2['dishes_name']; ?>">
                                            <input type="hidden" name="prod_price[]" value="<?= $order2['selling_price']; ?>">
                                            <input type="hidden" name="prod_qty[]" value="<?php echo $prod_qty2; ?>">
                                            <input type="hidden" name="code[]" style="color:#8f00ff; border: none; outline:none; width: 200px;" placeholder="" value="<?php echo $randString; ?>">

                                            <input type="hidden" name="s_id[]" value="2">
                                            <input type="hidden" name="school_name[]" value="<?php echo $school_name2; ?>">
                                            <input type="hidden" name="school_address[]" value="<?php echo $school_address2; ?>">
                                            <input type="hidden" name="school_phone[]" value="<?php echo $school_phone2; ?>">
                                            <input type="hidden" name="u_id[]" value="<?php echo $u_id; ?>">

                                            <input type="hidden" name="firstname[]" value="<?php echo $firstname; ?>">
                                            <input type="hidden" name="lastname[]" value="<?php echo $lastname; ?>">
                                            <input type="hidden" name="email[]" value="<?php echo $email; ?>">
                                            <input type="hidden" name="phone[]" value="<?php echo $phone; ?>">
                                            <input type="hidden" name="status[]" value="Check Out">
                                            <input type="hidden" name="stock[]" value="<?php echo $stock; ?>">
                                            <input type="hidden" name="time_arrival[]" value="<?php echo $time_arrival; ?>">
                                            <input type="hidden" name="day_arrival[]" value="<?php echo date("d M"); ?>">

                                            <input type="hidden" id="money2" name="cash[]">
                                            <input type="hidden" id="change2" name="change[]">
                                            <input type="hidden" id="ordered4" name="ordered[]">

                                            <script>
                                                function cash2(value2) {
                                                    var order2 = document.getElementById("ordered2").value;
                                                    total2 = 0;
                                                    document.getElementById("money2").value = value2;
                                                    total2 = value2 - order2;
                                                    if (total2 > 0) {
                                                        document.getElementById("received2").value = total2;
                                                        document.getElementById("change2").value = total2;
                                                        document.getElementById("ordered4").value = order2;
                                                    } else {
                                                        document.getElementById("received2").value = 0;
                                                        document.getElementById("change2").value = 0;
                                                    }
                                                }
                                            </script>



                                            <!-- /////////////// -->
                                    <?php } else {
                                            echo '';
                                        }
                                    }
                                }

                                if ($checked_array2 != 0) { ?>

                                    <h6>Cash: <input type="text" onkeyup="cash2(this.value)" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;"></h6>
                                    <h6>Change: <input type="text" id="received2" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;"></h6>
                                    <h6>Order Total: <input type="text" id="ordered2" value="<?php echo $total_sum2; ?>" style="width: 100px; border-left:none;border-top:none;border-right:none;outline:0; border-bottom: solid #000 2px;"></h6>

                                    <?php
                                    $id = $_SESSION['user_id'];
                                    $loginquery = "SELECT * FROM `users` WHERE u_id = $id";
                                    $result = mysqli_query($db, $loginquery);
                                    $row = mysqli_fetch_array($result);

                                    if ($row['s_id'] == 2) {
                                        $tax2 = 0;
                                        date_default_timezone_set('Asia/Manila');
                                        $hour = date("h");
                                        $minute = date("i");
                                        if ($minute == '00' || $minute == 0) {
                                            $new_minute = '00';

                                            $new_hour = $hour + 1;
                                        } else {
                                            $minute1 = 60 - $minute;
                                            $new_minute = 60 - $minute1;
                                            $new_hour = $hour + 1;
                                        }
                                        $time_arrival = $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a");
                                    ?>
                                        <div style="text-align: right;">
                                            <?php
                                            echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                            echo "Today: " .  date("d M"); ?>
                                        </div>
                                    <?php } else {
                                        $tax2 = 17;
                                        if ($final_prod == 1) {
                                            $tax2 = $tax2;
                                        } elseif ($final_prod > 2 && $final_prod < 5) {
                                            $tax2 = $tax2 + 20;
                                        } elseif ($final_prod > 6 && $final_prod < 10) {
                                            $tax2 = $tax2 + 40;
                                        } elseif ($final_prod > 11 && $final_prod < 15) {
                                            $tax2 = $tax2 + 60;
                                        } elseif ($final_prod > 16 && $final_prod < 25) {
                                            $tax2 = $tax2 + 80;
                                        }
                                        date_default_timezone_set('Asia/Manila');
                                        $hour = date("h");
                                        $minute = date("i");
                                        if ($minute == '00' || $minute == 0) {
                                            $new_minute = '00';

                                            $new_hour = $hour + 1;
                                        } else {
                                            $minute_left = 60 - $minute;
                                            $new_minute = 60 - $minute_left;
                                            $new_minute = $new_minute + 30;
                                            if ($new_minute > 60) {
                                                $new_minute = $new_minute - 60;
                                                $new_hour = $hour + 2;
                                            } else {

                                                $new_hour = $hour + 1;
                                            }
                                        } ?>
                                        <div style="text-align: right;">
                                            <?php
                                            echo "Receive by " . $hour . ":" . $minute .  " " . date("a") . " - " . $new_hour . ":" . $new_minute . " " . date("a") . "</br>";
                                            echo "Today: " .  date("d M"); ?>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '';
                                }   ?>
                            </div>


                            <div class="wrapper">


                                <div class="amount">

                                    <div class="subtotal">
                                        <b><span>Order Subtotal</span></b><span>P <span id="subtotal"><?php echo $sub_total = $total_sum1 + $total_sum2 ?></span></span>
                                    </div>

                                    <div class="tax">
                                        <b><span>CASH</span></b><span>P <span id="tax"><?php echo $tax = $tax1 + $tax2; ?></span></span>
                                    </div>

                                    <div class="shipping">

                                    </div>

                                    <div class="Total Payment">
                                        <b><span>Total Payment</span></b><span>P <span id="total"><?php echo $sub_total + $tax; ?></span></span><?php $_SESSION['total'] = $total; ?>
                                    </div>

                                </div>

                            </div>

                        </section>

                    </div>

                </div>
            </div>


        </form>
    </main>

    <!-- ======= Footer ======= -->
    <?php include 'include/user_footer.php'; ?>


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- modal -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- sweetalert2 message -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="js/jquery-3.6.0.js"></script>

    <!-- <script src="js/quantity.js" defer></script> -->

    <!-- sweetalert2 message -->
</body>

</html>
<script>
    function getValue() {
        const txt = document.getElementById("chash1");
        const txtValue = txt.value;

        const result = document.getElementById("result1");
    }

    // Add Modal
    $(document).on('submit', '#addOrder', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("valid_order", true);
        {
            Swal.fire({
                title: 'Do you want to save the changes?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Save',
                denyButtonText: `Don't save`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "cart_checkout_process.php", //action
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            var res = jQuery.parseJSON(response);
                            if (res.status == 400) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Something Went Wrong.',
                                    text: res.msg,
                                    timer: 3000
                                })
                            } else if (res.status == 500) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Something Went Wrong.',
                                    text: res.msg,
                                    timer: 3000
                                })
                            } else if (res.status == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'SUCCESS',
                                    text: res.msg,
                                    timer: 2000
                                }).then(function() {
                                    location.href = '/CFOS/order_waiting.php';
                                });
                            }
                        }
                    })
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info').then(function() {
                        location.reload();
                    });
                }
            })
        }
    });
</script>