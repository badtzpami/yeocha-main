    
    <div class="card-container">

        <!-- Card -->
        <div class="card card-custom" style="width: 600px !important; height:465px !important; 
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #aab7cf transparent;">

            <div class="d-flex align-items-center">
                <div class="activity">
                    <?php

                    $status_list_query = "SELECT * FROM `order_history` ORDER BY date_created_at DESC";
                    $status_list_result = mysqli_query($conn, $status_list_query);

                    if (mysqli_num_rows($status_list_result) > 0) {
                        while ($status = mysqli_fetch_array($status_list_result)) {

                            $sql_stat = "SELECT * FROM `order_history` WHERE `order_code` = '" . $status['order_code'] . "' ORDER BY date_created_at DESC LIMIT 1";
                            $res_stat = mysqli_query($conn, $sql_stat);
                            $stat = mysqli_fetch_array($res_stat);

                            $supplier_list_query = "SELECT * FROM `users` WHERE `user_id` = " . $status['user_id'] . " && `role` = 'Supplier' ORDER BY `user_id` DESC";
                            $supplier_list_result = mysqli_query($conn, $supplier_list_query);
                            $supplier = mysqli_fetch_array($supplier_list_result);


                            if ($status["status"] == "Check Out") { ?>

                                <div class="activity-item d-flex">
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>
                                    <?php
                                    if ($stat["status"] == "Check Out") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content">
                                        <?php
                                        if ($stat["status"] == "Check Out") { ?>
                                            <b>Order <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> is placed</b>
                                        <?php
                                        } else { ?>
                                            Order <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> is placed
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
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>
                                    <?php
                                    if ($stat["status"] == "To Pack") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content">
                                        <?php
                                        if ($stat["status"] == "To Pack") { ?>
                                            <b><?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> is packing your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong>.</b>
                                        <?php
                                        } else { ?>
                                            <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> is packing your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong>.
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
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>

                                    <?php
                                    if ($stat["status"] == "To Ship") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content" style="content: '';
                                    position: absolute;
                                    right: -15px;
                                    width: 7px;
                                    height: 76px;
                                    top: 0;
                                    bottom: 0;
                                    background-color: #bfc2d6;">
                                        <?php
                                        if ($stat["status"] == "To Ship") { ?>
                                            <b>Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has arrived and to be received.</b>
                                        <?php
                                        } else { ?>
                                            Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has arrived and to be received.
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
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>

                                    <?php
                                    if ($stat["status"] == "At Your Shop") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content">
                                        <?php
                                        if ($stat["status"] == "At Your Shop") { ?>
                                            <b>Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been pick up by the delivery person.</b>
                                        <?php
                                        } else { ?>
                                            Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been pick up by the delivery person.
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
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>

                                    <?php
                                    if ($stat["status"] == "Completed") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content">
                                        <?php
                                        if ($stat["status"] == "Completed") { ?>
                                            <b>Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been delivered.</b>
                                        <?php
                                        } else { ?>
                                            Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been delivered.
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
                                    <div class="activite-label"><?php $date = new DateTime($status["date_created_at"]);
                                                                echo $date->format('d M H:i'); ?></div>

                                    <?php
                                    if ($stat["status"] == "Cancelled") { ?>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    } else { ?>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start' style="font-size: 18px;"></i>
                                    <?php
                                    }
                                    ?>

                                    <div style="font-size: 18px;" class="activity-content">
                                        <?php
                                        if ($stat["status"] == "Cancelled") { ?>
                                            <b>Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been cancelled.</b>
                                        <?php
                                        } else { ?>
                                            Your package <strong style="font-size: 16px; color: #28a745;"><?= $status["order_code"]; ?></strong> from <?= $supplier["firstname"] . " " . $supplier["lastname"]; ?> has been cancelled.
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    } else {
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>