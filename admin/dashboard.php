<?php
include '../config/connect.php';

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
<style>
    .filter_type {
        position: absolute !important;
        right: 45px !important;
        top: 15px !important;
    }

    .filter_type .icon {
        color: #aab7cf !important;
        padding-right: 20px !important;
        padding-bottom: 5px !important;
        transition: 0.3s !important;
        font-size: 16px !important;
    }


    .filter_type .icon:hover,
    .filter_type .icon:focus {
        color: #4154f1 !important;
    }


    .filter_type .dropdown-header {
        padding: 8px 15px !important;
    }

    .filter_type .dropdown-header h6 {
        text-transform: uppercase !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        letter-spacing: 1px !important;
        color: #aab7cf !important;
        margin-bottom: 0 !important;
        padding: 0 !important;
    }

    .filter_type .dropdown-item {
        padding: 8px 15px !important;
    }





    /* ///////////////////////////// */



    .filter_date {
        position: absolute !important;
        right: 0px !important;
        top: 15px !important;
    }

    .filter_date .icon {
        color: #aab7cf !important;
        padding-right: 20px !important;
        padding-bottom: 5px !important;
        transition: 0.3s !important;
        font-size: 16px !important;
    }


    .filter_date .icon:hover,
    .filter_date .icon:focus {
        color: #4154f1 !important;
    }


    .filter_date .dropdown-header {
        padding: 8px 15px !important;
    }

    .filter_date .dropdown-header h6 {
        text-transform: uppercase !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        letter-spacing: 1px !important;
        color: #aab7cf !important;
        margin-bottom: 0 !important;
        padding: 0 !important;
    }

    .filter_date .dropdown-item {
        padding: 8px 15px !important;
    }
</style>
<?php include "../include/user_top.php"; ?>

<?php include "../include/user_header.php"; ?>
<?php include "../include/sidebar_admin.php"; ?>




<main id="main" class="main">

    <div class="page-header mb-5">
        <div class="page-header flex-wrap mt-3">
            <div class="row">
                <div class="col-9">
                    <div class="d-flex">
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Dashboard</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- End header -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">


                    <!-- Sales Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card" style="height: 200px !important;">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <!-- W -->
                                    <li><a class="dropdown-item" href="#" id="sale_this_week">ThiS Week</a></li>
                                    <li><a class="dropdown-item" href="#" id="sale_this_month">This Month</a></li>
                                    <li><a class="dropdown-item" href="#" id="sale_this_year">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Sales <span id="sale_title_status">| ThiS Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">

                                        <?php
                                        $new_query = "SELECT COUNT(sa_id) AS new_sales, date_created_at FROM sale WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 7 DAY)";
                                        $new_result = mysqli_query($conn, $new_query);
                                        $new = mysqli_fetch_array($new_result);


                                        $before_query = "SELECT COUNT(sa_id) AS before_sales, date_created_at FROM sale WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 14 DAY)";
                                        $before_result = mysqli_query($conn, $before_query);
                                        $before = mysqli_fetch_array($before_result);

                                        $sales = (($new['new_sales'] / $before['before_sales']) / $before['before_sales']) * 100;
                                        ?>
                                        <h6 id="sales-quantity"><?php echo $new['new_sales'] ?></h6>
                                        <span class="text-success small pt-1 fw-bold" id="sale_percent"><?php echo round($sales,1); ?>%</span> <span class="text-muted small pt-2 ps-1" id="sale_part">increase</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->




                    <!-- Revenue Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card" style="height: 200px !important;">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#" id="revenue_this_week">ThiS Week</a></li>
                                    <li><a class="dropdown-item" href="#" id="revenue_this_month">This Month</a></li>
                                    <li><a class="dropdown-item" href="#" id="revenue_this_year">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Revenue <span id="revenue_title_status">| This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-icon">₱</i>
                                    </div>
                                    <div class="ps-3">

                                        <?php
                                        $revenue_new_query = "SELECT count(sa_id) AS new_sales, SUM(total) AS new_sum, date_created_at FROM sale WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 7 DAY)";
                                        $revenue_new_result = mysqli_query($conn, $revenue_new_query);
                                        $revenue_new = mysqli_fetch_array($revenue_new_result);

                                        $revenue_before_query = "SELECT count(sa_id) AS before_sales, SUM(total) AS before_sum, date_created_at FROM sale WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 14 DAY)";
                                        $revenue_before_result = mysqli_query($conn, $revenue_before_query);
                                        $revenue_before = mysqli_fetch_array($revenue_before_result);

                                        $revenue_sales = (($revenue_new['new_sales'] / $revenue_before['before_sales']) / $revenue_before['before_sales']) * 100;
                                        ?>

                                        <h6 id="revenue-quantity">₱<?php echo $revenue_new['new_sum']; ?></h6>
                                        <span class="text-success small pt-1 fw-bold" id="revenue_percent"><?php echo round($revenue_sales, 1); ?>%</span> <span class="text-muted small pt-2 ps-1" id="revenue_part">increase</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->


                    <!-- Customers Card -->
                    <div class="col-xxl-3 col-xl-6">

                        <div class="card info-card customers-card" style="height: 200px !important;">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#" id="shipping_this_week">ThiS Week</a></li>
                                    <li><a class="dropdown-item" href="#" id="shipping_this_month">This Month</a></li>
                                    <li><a class="dropdown-item" href="#" id="shipping_this_year">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Check Out Item <span class="shipping_title_status">| This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                        $shipping_new_query = "SELECT COUNT(or_id) AS countOrder, date_created_at  FROM `order_history` WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 7 DAY) AND status = 'Check Out' OR status = 'Cancelled' ";
                                        $shipping_new_result = mysqli_query($conn, $shipping_new_query);
                                        $shipping_new = mysqli_fetch_array($shipping_new_result);

                                        $shipping_before_query = "SELECT COUNT(or_id) AS prevCountOrder, date_created_at  FROM `order_history` WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 14 DAY) AND status = 'Check Out' OR status = 'Cancelled' ";
                                        $shipping_before_result = mysqli_query($conn, $shipping_before_query);
                                        $shipping_before = mysqli_fetch_array($shipping_before_result);

                                        $shipping_percentage = ($shipping_new['countOrder'] / $shipping_before['prevCountOrder']) * 50;
                                        ?>

                                        <h6 id="shipping-quantity"><?php echo $shipping_new['countOrder']; ?></h6>
                                        <span class="text-success small pt-1 fw-bold" id="shipping_percent"><?php echo round($shipping_percentage, 1) ?>%</span> <span class="text-muted small pt-2 ps-1" id="shipping_part">increase</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->




                    <!-- 
                            create function that hen you choose from id="delivered_this_week", id="delivered_this_month", 
                            id="delivered_this_year here the select it all change the context of:
                            1. id="delivered_title_status":
                                id="delivered_this_week" - "| ThiS Week"
                                id="delivered_this_month" - "| ThiS Month"
                                id="delivered_this_year" - "| ThiS Year"
                            2. id="delivered-quantity":
                                id="delivered_this_week" - week_query from order table in yeocha_main = select all count of or_id as count_order_week, date_created_at FROM order where status is 'Completed' date_created_at is one week.
                                id="delivered_this_month" - month_query from order table in yeocha_main = select all count of or_id as count_order_month, date_created_at FROM order where status is 'Completed' date_created_at is one month.
                                id="delivered_this_year" - year_query from order table in yeocha_main = select all count of or_id as count_order_year, date_created_at FROM order where status is 'Completed' date_created_at is one year.
                            3.  id="delivered_percent":
                                id="delivered_this_week" - get the percentage here you use formula(if the number is have 3rd or so on.. need to round off) - from query above
                                id="delivered_this_month" - get the percentage here you use formula(if the number is have 3rd or so on.. need to round off) - from query above
                                id="delivered_this_year" - get the percentage here you use formula(if the number is have 3rd or so on.. need to round off) - from query above
                            4.  id="delivered_part":
                                id="delivered_this_week" - either increase or decrease based on the percentage if it is negative it label as decrease then if the percentage is not negative it label as increase
                                id="delivered_this_month" - either increase or decrease based on the percentage if it is negative it label as decrease then if the percentage is not negative it label as increase
                                id="delivered_this_year" - either increase or decrease based on the percentage if it is negative it label as decrease then if the percentage is not negative it label as increase

                                -please use javascript for the script
                    -->
                    <!-- Customers Card -->
                    <div class="col-xxl-3 col-xl-6">

                        <div class="card info-card customers-card" style="height: 200px !important;">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" id="delivered_this_week">ThiS Week</a></li>
                                    <li><a class="dropdown-item" href="#" id="delivered_this_month">This Month</a></li>
                                    <li><a class="dropdown-item" href="#" id="delivered_this_year">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Delivered Item <span id="delivered_title_status">| This Week</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box"></i>
                                    </div>
                                    <div class="ps-3">
                                        <?php
                                        $delivered_new_query = "SELECT COUNT(or_id) AS countOrder, date_created_at FROM `order_history` WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 7 DAY) AND status = 'Completed'";
                                        $delivered_new_result = mysqli_query($conn, $delivered_new_query);
                                        $delivered_new = mysqli_fetch_array($delivered_new_result);

                                        $delivered_before_query = "SELECT COUNT(or_id) AS prevCountOrder, date_created_at FROM `order_history` WHERE DATE(date_created_at) >= DATE(NOW() - INTERVAL 14 DAY) AND status = 'Completed'";
                                        $delivered_before_result = mysqli_query($conn, $delivered_before_query);
                                        $delivered_before = mysqli_fetch_array($delivered_before_result);

                                        $delivered_percentage = ($delivered_new['countOrder'] / $delivered_before['prevCountOrder']) * 50;
                                        ?>

                                        <h6 id="delivered-quantity"><?php echo $delivered_new['countOrder']; ?></h6>
                                        <span class="text-success small pt-1 fw-bold" id="delivered_percent"><?php echo round($delivered_percentage, 1); ?>%</span> <span class="text-muted small pt-2 ps-1" id="sdelivered_part">increase</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->



                    <!-- 

                            create function that when you choose from id="sale_report", id="order_report", 
                            id="logistic_report" here the select it all change the piegraph indication:
                            1. id="card-title":
                                id="sale_report" - "Sale Item "
                                id="order_report" - "Order Item "
                                id="logistic_report" - "Logistic Item"
                            2. id="sale_status":
                                 id="sale_daily" - "| This 8 Day"
                                id="sale_weekly" - "| This 8 Week"
                                id="sale_monthly" - "| This 8 Month"

                            <canvas id="myPieChart" width="300" height="300"></canvas>

                            
                            1. when you choose id="sale_report":
                            all data 8 months before today (8 months before - november):
                            in data belo must calculated base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'My Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]
                                
                            2. when you choose id="order_report":

                            all data 8 months before today (8 months before - november):
                            in data below must calculated the count of order base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'My Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]

                            3. when you choose id="logistic_report":
                            all data 8 months before today (8 months before - november):
                            in data below must calculated base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'My Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]




                            create function that when you choose from id="sale_daily", id="sale_weekly", 
                            id="sale_monthly" here the select it all change the piegraph indication:
                            1. id="card-title":
                               id="sale_report" - "Sale Item "
                                id="order_report" - "Order Item "
                                id="logistic_report" - "Logistic Item"
                            2. id="sale_status":
                                id="sale_daily" - "| This 8 Day"
                                id="sale_weekly" - "| This 8 Week"
                                id="sale_monthly" - "| This 8 Month"

                            <canvas id="myPieChart" width="300" height="300"></canvas>

                            1. when you choose id="sale_daily":
                            must change label into 8 days
                            labels: ['Day 1', 'Day 2', 'Day 3',..], // Labels for each section
                            all data 8 days before today (8 days before - november):
                            in data belo must calculated base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'Daily Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]
                                
                            2. when you choose id="sale_weekly":
                            must change label into 8 week
                            labels: ['Day1', 'Day2', 'Day3',..], // Labels for each section
                            all data 8 week before today (8 week before - november):
                            in data below must calculated base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'Monthly Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]

                            3. when you choose id="sale_monthly":
                            must change label into 8 Months
                            labels: ['January', 'February', 'March',..], // Labels for each section
                            all data 8 months before today (8 months before - november):
                            in data below must calculated base on the whole month in sale table query:
                            
                                datasets: [{
                                    label: 'Monthly Sale Dataset',
                                    data: [300, 50, 100], // Data values for each section
                                    backgroundColor: ['#419691', '#65ba91', '#3c6e82'], // Colors for each section
                                    hoverOffset: 4
                                }]

                           
                                -please use javascript for the script
                    -->

                    <!-- pie graph for sales report -->
                    <div class="col-xxl-6 col-xl-12">

                        <div class="card info-card customers-card" style="height: 505px !important;">

                            <div class="filter_type" id="filter-type">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Type Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" id="sale_report">Sale</a></li>
                                    <li><a class="dropdown-item" href="#" id="order_report">Order</a></li>
                                    <li><a class="dropdown-item" href="#" id="logistic_report">Logistic</a></li>
                                </ul>
                            </div>

                            <div class="filter_date" id="filter-date">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Date Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" id="sale_daily">Daily</a></li>
                                    <li><a class="dropdown-item" href="#" id="sale_weekly">Weekly</a></li>
                                    <li><a class="dropdown-item" href="#" id="sale_monthly">Monthly</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><span class="fw-bold" id="card-title" style="font-size: 14px; font-eight: 900;"><strong>Sale Item </strong></span> <span id="sale_status">| This 8 Days</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="ps-3">

                                        <div class="d-flex align-items-center m-2" style="margin-left: 80px !important;display: flex; flex-direction: column; left:0;flex-wrap: wrap; justify-content: center; align-items: center;">
                                            <canvas id="myPieChart" width="400" height="500"></canvas>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    
                   
                    <!-- Top Selling -->
                    <div class="col-xxl-6 col-xl-12">
                        <div class="card top-selling overflow-auto"  style="height: 505px !important;">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#" id="top_selling_weekly">Daily</a></li>
                                    <li><a class="dropdown-item" href="#" id="top_selling_monthly">Weekly</a></li>
                                    <li><a class="dropdown-item" href="#" id="top_selling_yearly">Monthly</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Selling <span id="table_title_status">| Today</span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Preview</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Sold</th>
                                            <th scope="col">Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch data
                                        $sql = "SELECT 
                                        p.image AS product_image,
                                        p.product_name,
                                        p.selling_price AS price,
                                        SUM(s.pr_id) AS total_items_sold,
                                        SUM(s.sell_price * s.quantity) AS revenue
                                        FROM 
                                        product p
                                        JOIN 
                                        sale s ON p.pr_id = s.pr_id
                                        GROUP BY 
                                        p.pr_id
                                        ORDER BY 
                                        total_items_sold DESC";
  $item_result = mysqli_query($conn, $sql);


  if (mysqli_num_rows($item_result) > 0) {
      while ($row = mysqli_fetch_array($item_result)) { ?>

                                        <tr>
                                            <td scope="row">
                                            <?php if (is_array($row)) { ?>
                                    <?php if (empty($row['image'])) { ?>
                                        <img src="../assets/images/default_images/tea_house.jpeg" >
                                    <?php } else { ?>
                                        <img src="../assets/images/material_images/<?php echo $row['image']; ?>" >
                                <?php }
                                } else {
                                }
                                ?>
                                            </td>
                                            <td><a href="#" style="font-size: 12px; color: #000;"><?php echo $row['product_name']; ?></a></td>
                                            <td><?php echo $row['price']; ?></td>
                                            <td class="fw-bold"><?php echo $row['total_items_sold']; ?></td>
                                            <td>$<?php echo $row['revenue']; ?></td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->

                </div>
            </div><!-- End Left side columns -->

            
        </div>
    </section>

</main><!-- End #main -->


<?php include "../include/user_footer.php"; ?>
<?php include "../include/user_bottom.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>







<script>
 document.addEventListener("DOMContentLoaded", function () {
    // Get filter buttons and table title
    const weekBtn = document.getElementById("top_selling_weekly");
    const monthBtn = document.getElementById("top_selling_monthly");
    const yearBtn = document.getElementById("top_selling_yearly");
    const tableTitleStatus = document.getElementById("table_title_status");

    // Function to fetch and update top-selling data
    const updateTopSelling = (filter) => {
        // Update table title
        const titles = {
            weekly: "| This Week",
            monthly: "| This Month",
            yearly: "| This Year",
        };
        tableTitleStatus.textContent = titles[filter];

        // Fetch filtered data
        fetch(`fetch_top_selling_products.php?filter=${filter}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                const tableBody = document.querySelector("table tbody");
                tableBody.innerHTML = ""; // Clear existing rows

                // Populate table with new data
                data.forEach((item) => {
                    const row = `
                        <tr>
                            <td><img src="${item.product_image}" alt="${item.product_name}" style="height: 50px; width: auto;"></td>
                            <td>${item.product_name}</td>
                            <td>₱${item.price}</td>
                            <td class="fw-bold">${item.total_items_sold}</td>
                            <td>₱${item.revenue}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML("beforeend", row);
                });
            })
            .catch((error) => console.error("Error fetching top-selling data:", error));
    };

    // Attach event listeners
    weekBtn.addEventListener("click", () => updateTopSelling("weekly"));
    monthBtn.addEventListener("click", () => updateTopSelling("monthly"));
    yearBtn.addEventListener("click", () => updateTopSelling("yearly"));
});


    document.addEventListener("DOMContentLoaded", function() {
        // Buttons for selecting the period
        const weekBtn = document.getElementById("revenue_this_week");
        const monthBtn = document.getElementById("revenue_this_month");
        const yearBtn = document.getElementById("revenue_this_year");

        // Elements to update
        const revenueTitleStatus = document.getElementById("revenue_title_status");
        const revenueQuantity = document.getElementById("revenue-quantity");
        const revenuePercent = document.getElementById("revenue_percent");
        const revenuePart = document.getElementById("revenue_part");

        // Function to update revenue data dynamically
        const updateRevenueData = (filter) => {
            // Adjust the title based on the filter
            const titles = {
                week: "| This Week",
                month: "| This Month",
                year: "| This Year"
            };
            revenueTitleStatus.textContent = titles[filter];

            // Fetch data from the server
            fetch(`get_revenue_data.php?filter=${filter}`)
                .then(response => response.json())
                .then(data => {
                    // Update revenue quantity
                    revenueQuantity.textContent = `₱${data.revenue.toLocaleString()}`;

                    // Calculate percentage change and update
                    const percentage = parseFloat(data.percentage.toFixed(1)); // Round to one decimal place
                    revenuePercent.textContent = `${percentage}%`;

                    // Apply success or danger classes based on the percentage
                    revenuePercent.classList.toggle("text-success", percentage >= 0);
                    revenuePercent.classList.toggle("text-danger", percentage < 0);

                    // Set increase/decrease label based on percentage
                    revenuePart.textContent = percentage < 0 ? "decrease" : "increase";
                })
                .catch(error => console.error("Error fetching revenue data:", error));
        };

        // Event listeners for the buttons
        weekBtn.addEventListener("click", () => updateRevenueData("week"));
        monthBtn.addEventListener("click", () => updateRevenueData("month"));
        yearBtn.addEventListener("click", () => updateRevenueData("year"));
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const weekBtn = document.getElementById("shipping_this_week");
        const monthBtn = document.getElementById("shipping_this_month");
        const yearBtn = document.getElementById("shipping_this_year");

        const shippingTitleStatus = document.querySelector(".shipping_title_status");
        const shippingQuantity = document.getElementById("shipping-quantity");
        const shippingPercent = document.getElementById("shipping_percent");
        const shippingPart = document.getElementById("shipping_part");

        const updateShippingData = (filter) => {
            // Update title
            const titles = {
                week: "| ThiS Week",
                month: "| ThiS Month",
                year: "| ThiS Year",
            };
            shippingTitleStatus.textContent = titles[filter];

            // Fetch data from the server
            fetch(`get_shipping_data.php?filter=${filter}`)
                .then((response) => response.json())
                .then((data) => {
                    // Update shipping quantity
                    shippingQuantity.textContent = data.countOrder;

                    // Calculate and update percentage
                    const percentage = parseFloat(data.percentage.toFixed(2));
                    shippingPercent.textContent = `${percentage}%`;
                    shippingPercent.classList.toggle("text-success", percentage >= 0);
                    shippingPercent.classList.toggle("text-danger", percentage < 0);

                    // Update increase/decrease label
                    shippingPart.textContent = percentage < 0 ? "decrease" : "increase";
                })
                .catch((error) => console.error("Error fetching shipping data:", error));
        };

        // Event listeners for filter buttons
        weekBtn.addEventListener("click", () => updateShippingData("week"));
        monthBtn.addEventListener("click", () => updateShippingData("month"));
        yearBtn.addEventListener("click", () => updateShippingData("year"));
    });

    document.addEventListener("DOMContentLoaded", function () {
    const weekBtn = document.getElementById("delivered_this_week");
    const monthBtn = document.getElementById("delivered_this_month");
    const yearBtn = document.getElementById("delivered_this_year");

    const deliveredTitleStatus = document.getElementById("delivered_title_status");
    const deliveredQuantity = document.getElementById("delivered-quantity");
    const deliveredPercent = document.getElementById("delivered_percent");
    const deliveredPart = document.getElementById("delivered_part");

    const updateDeliveredData = (filter) => {
        // Update title
        const titles = {
            week: "| This Week",
            month: "| This Month",
            year: "| This Year",
        };
        deliveredTitleStatus.textContent = titles[filter];

        // Fetch data from the server
        fetch(`get_delivered_data.php?filter=${filter}`)
            .then((response) => response.json())
            .then((data) => {
                // Update delivered quantity
                deliveredQuantity.textContent = data.countOrder;

                // Calculate and update percentage
                const percentage = parseFloat(data.percentage.toFixed(2));
                deliveredPercent.textContent = `${Math.abs(percentage)}%`;
                deliveredPercent.classList.toggle("text-success", percentage >= 0);
                deliveredPercent.classList.toggle("text-danger", percentage < 0);

                // Update increase/decrease label
                deliveredPart.textContent = percentage < 0 ? "decrease" : "increase";
            })
            .catch((error) => console.error("Error fetching delivered data:", error));
    };

    // Event listeners for filter buttons
    weekBtn.addEventListener("click", () => updateDeliveredData("week"));
    monthBtn.addEventListener("click", () => updateDeliveredData("month"));
    yearBtn.addEventListener("click", () => updateDeliveredData("year"));
});

</script>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cardTitle = document.getElementById('card-title');
        const saleStatus = document.getElementById('sale_status');
        const ctx = document.getElementById('myPieChart').getContext('2d');

        let pieChart; // To store the current chart instance

        // Initialize the chart with default data
        const initializeChart = (labels, data, label) => {
            if (pieChart) pieChart.destroy(); // Destroy previous chart instance if any

            const total = data.reduce((a, b) => a + b, 0); // Calculate total for percentages

            pieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: ['#6cad9e', '#5c8a6c', '#818f64', '#422b54', '#6f648f', '#8b648f', '#64778f', '#64888f'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function (tooltipItem) {
                                    const value = tooltipItem.raw;
                                    const percentage = ((value / total) * 100).toFixed(2);
                                    return `${tooltipItem.label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, context) => {
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${percentage}%`;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        };

        // Handlers for type filters
        document.getElementById('sale_report').addEventListener('click', () => {
            cardTitle.textContent = 'Sale Item';
            saleStatus.textContent = '| This 8 Days';
            initializeChart(['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'], [300, 50, 100, 200, 150, 400, 120, 80], 'Sale Dataset');
        });

        document.getElementById('order_report').addEventListener('click', () => {
            cardTitle.textContent = 'Order Item';
            saleStatus.textContent = '| This 8 Days';
            initializeChart(['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'], [500, 200, 300, 150, 100, 450, 120, 70], 'Order Dataset');
        });

        document.getElementById('logistic_report').addEventListener('click', () => {
            cardTitle.textContent = 'Completed Order Item';
            saleStatus.textContent = '| This 8 Days';
            initializeChart(['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'], [400, 300, 200, 100, 250, 300, 180, 60], 'Logistic Dataset');
        });

        // Handlers for date filters
        document.getElementById('sale_daily').addEventListener('click', () => {
            saleStatus.textContent = '| This 8 Days';
            initializeChart(['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7', 'Day 8'], [30, 50, 70, 20, 90, 10, 40, 80], 'Daily Dataset');
        });

        document.getElementById('sale_weekly').addEventListener('click', () => {
            saleStatus.textContent = '| This 8 Weeks';
            initializeChart(['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'], [70, 50, 90, 20, 100, 50, 80, 40], 'Weekly Dataset');
        });

        document.getElementById('sale_monthly').addEventListener('click', () => {
            saleStatus.textContent = '| This 8 Months';
            initializeChart(['April', 'May', 'June', 'July', 'August', 'September', 'October', 'November'], [300, 200, 100, 400, 500, 300, 200, 150], 'Monthly Dataset');
        });

        // Initialize with default sale data
        document.getElementById('sale_report').click();
    });
</script>