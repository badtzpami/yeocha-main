<!-- 1st Card -->
<?php
$order_id = $_GET['order'];

$sql_order = "SELECT * FROM `order` WHERE or_id = '" . $order_id . "'";
$res_order = mysqli_query($conn, $sql_order);
$fetch_order = mysqli_fetch_array($res_order);

if ($fetch_order) {

    $sql_user = "SELECT * FROM `users` WHERE `user_id` = '" . $fetch_order['user_id'] . "' LIMIT 1";
    $res_user = mysqli_query($conn, $sql_user);
    $user = mysqli_fetch_array($res_user);
?>

    <div class="card-container">
        <!-- Card -->
        <div class="card card-custom" style="border-radius: 10px;">
            <div class="card-body">
                <!-- Header: Your Order Status -->
                <h5 class="card-title text-success">Your Order is (<?= $fetch_order['status']; ?>)</h5>

                <!-- Add class "active" to progress -->
                <div class="row d-flex justify-content-between px-3">
                    <div class="col-12">
                        <ul id="progressbar" class="text-center">
                            <?php
                            if ($fetch_order["status"] == "Check Out") {
                            ?>
                                <li class="active step0"></li>
                                <li class=" step0"></li>
                                <li class=" step0"></li>
                                <li class="step0"></li>
                            <?php   } else if ($fetch_order["status"] == "To Pack") { ?>

                                <li class="active step0"></li>
                                <li class="active step0"></li>
                                <li class=" step0"></li>
                                <li class="step0"></li>
                            <?php   } else  if ($fetch_order["status"] == "To Ship") { ?>

                                <li class="active step0"></li>
                                <li class="active step0"></li>
                                <li class="active step0"></li>
                                <li class="step0"></li>
                            <?php   } else if ($fetch_order["status"] == "Completed") { ?>

                                <li class="active step0"></li>
                                <li class="active step0"></li>
                                <li class="active step0"></li>
                                <li class="active step0"></li>
                            <?php   } else { ?>

                                <li class=" step0"></li>
                                <li class=" step0"></li>
                                <li class=" step0"></li>
                                <li class=" step0"></li>
                            <?php   }
                            ?>

                        </ul>
                    </div>
                </div>
                <div class="row justify-content-between  px-5 top">
                    <?php
                    if ($fetch_order["status"] == "Check Out") {
                    ?>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/CheckList.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">
                                        <?php
                                        if (isset($_SESSION["user_id_admin"])) { ?>
                                            Order <br />Checkout
                                        <?php
                                        } else if (isset($_SESSION["user_id_supplier"])) { ?>
                                            Item <br />Available
                                        <?php
                                        } else {
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Delivery.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">
                                        <?php
                                        if (isset($_SESSION["user_id_admin"])) { ?>
                                            Order <br />Processed
                                        <?php
                                        } else if (isset($_SESSION["user_id_supplier"])) { ?>
                                            Item <br />Packing
                                        <?php
                                        } else {
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Shipping.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">
                                        <?php
                                        if (isset($_SESSION["user_id_admin"])) { ?>
                                            Order <br />On The Way
                                        <?php
                                        } else if (isset($_SESSION["user_id_supplier"])) { ?>
                                            Item <br />On The Way
                                        <?php
                                        } else {
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Home.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">
                                        <?php
                                        if (isset($_SESSION["user_id_admin"])) { ?>
                                            Order <br />Delivered
                                        <?php
                                        } else if (isset($_SESSION["user_id_supplier"])) { ?>
                                            Item <br />Delivered
                                        <?php
                                        } else {
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php   } else if ($fetch_order["status"] == "To Pack") { ?>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/CheckList.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Checkout</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Delivery.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Processed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Shipping.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">Order <br />On The Way</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Home.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">Order <br />Delivered</p>
                                </div>
                            </div>
                        </div>
                    <?php   } else  if ($fetch_order["status"] == "To Ship") { ?>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/CheckList.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Checkout</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Delivery.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Processed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Shipping.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />On The Way</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Home.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold">Order <br />Delivered</p>
                                </div>
                            </div>
                        </div>
                    <?php   } else if ($fetch_order["status"] == "Completed") { ?>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/CheckList.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Checkout</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Delivery.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Processed</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Shipping.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />On The Way</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="row d-flex icon-content">
                                <img src="../assets/images/background/Home.png" alt="" class="icon" style="width: 80px;" />
                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold" style=" color: #007bff;">Order <br />Delivered</p>
                                </div>
                            </div>
                        </div>
                    <?php   }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="card-container">
        <!-- Card -->
        <div class="card card-custom" style="border-radius: 10px;">
            <div class="card-body">
                <!-- Header: Your Order Status -->
                <h5 class="card-title text-success">Your Order is (<?= $fetch_order['status']; ?>)</h5>

                <!-- Delivery Status -->
                <div class="d-flex align-items-center  mb-2">
                    <i class="bi bi-truck" style="font-size: 24px;"></i>
                    <p class="shipping-info p-2">
                        <strong style="font-size: 14px; margin: 80px 0; padding: 80px 0;">Supplier Delivery Express</strong>
                        <span style="float: right; margin: 0px; padding:0;"><input type="hidden" class="order-code" value="<?= $fetch_order['order_code']; ?>" readonly> </span>
                    <h6 class="card-title text-success" style="font-size:13px;padding:0;"><?= $fetch_order['order_code']; ?></h6>
                    </p>
                    <button class="btn btn-outline-primary" onclick="copyOrderCode()" style="display:flex;align-items:right;justify-content: right;right:0; width:10x; padding: 5px 30px; color: #28a745; font-size: 12px;">Copy</button>
                </div>

                <!-- Gray partition -->
                <hr>

                <!-- Delivery Information -->
                <p class="mt-3 mb-3"><strong style="font-size: 14px;">Delivery Information</strong></p>
                <div class="d-flex align-items-center">
                    <div class="activity">

                        <?php
                        $sql_stat = "SELECT * FROM `order_history` WHERE `order_code` = '" . $fetch_order['order_code'] . "' ORDER BY date_created_at DESC LIMIT 1";
                        $res_stat = mysqli_query($conn, $sql_stat);
                        $stat = mysqli_fetch_array($res_stat);

                        $status_list_query = "SELECT * FROM `order_history` WHERE  order_code = '" . $fetch_order['order_code'] . "'   ORDER BY date_created_at DESC";
                        $status_list_result = mysqli_query($conn, $status_list_query);

                        if (mysqli_num_rows($status_list_result) > 0) {
                            while ($status = mysqli_fetch_array($status_list_result)) {
                                $sql_code = "SELECT * FROM `order` WHERE `order_code` = '" . $fetch_order['order_code'] . "' LIMIT 1";
                                $res_code = mysqli_query($conn, $sql_code);
                                $code = mysqli_fetch_array($res_code);

                                if ($status["status"] == "Check Out") { ?>

                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>
                                        <?php
                                        if ($stat["status"] == "Check Out") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "Check Out") { ?>
                                                <b>Order is placed</b>
                                            <?php
                                            } else { ?>
                                                Order is placed
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php
                                } else {
                                }
                                if ($status["status"] == "To Pack") { ?>

                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>
                                        <?php
                                        if ($stat["status"] == "To Pack") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "To Pack") { ?>
                                                <b>Supplier is packing your package</b>
                                            <?php
                                            } else { ?>
                                                Supplier is packing your package
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php
                                } else {
                                }
                                if ($status["status"] == "To Ship") { ?>

                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>

                                        <?php
                                        if ($stat["status"] == "To Ship") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "To Ship") { ?>
                                                <b>Your package has arrived and to be received</b>
                                            <?php
                                            } else { ?>
                                                Your package has arrived and to be received
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php
                                } else {
                                }
                                if ($status["status"] == "At Your Shop") { ?>

                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>

                                        <?php
                                        if ($stat["status"] == "At Your Shop") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "At Your Shop") { ?>
                                                <b>Your package has been pick up by the delivery person</b>
                                            <?php
                                            } else { ?>
                                                Your package has been pick up by the delivery person
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php
                                } else {
                                }
                                if ($status["status"] == "Completed") { ?>

                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>

                                        <?php
                                        if ($stat["status"] == "Completed") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "Completed") { ?>
                                                <b>Your package has been delivered</b>
                                            <?php
                                            } else { ?>
                                                Your package has been delivered
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                <?php
                                } else {
                                }
                                if ($status["status"] == "Cancelled") { ?>
                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?php $date = new DateTime($stat["date_created_at"]);
                                                                    echo $date->format('d M H:i'); ?></div>

                                        <?php
                                        if ($stat["status"] == "Cancelled") { ?>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <?php
                                        } else { ?>
                                            <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <?php
                                        }
                                        ?>

                                        <div class="activity-content">
                                            <?php
                                            if ($stat["status"] == "Cancelled") { ?>
                                                <b>Your package has been cancelled.</b>
                                            <?php
                                            } else { ?>
                                                Your package has been cancelled.
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>





<?php
}

?>