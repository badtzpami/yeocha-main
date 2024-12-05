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
                        <h4 class="page-title pl-0 h5 pl-sm-2 text-muted d-inline-block">Reports</h4>
                    </div>
                </div>
                <div class="col-3">

                    <div class="d-flex">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item">Reports</li>
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
            <div class="col-lg-12" style="display: flex; justify-content: center; height: 505px !important;">
                <div class="row">






                    <!-- pie graph for sales report -->
                    <div class="col-xxl-12 col-xl-12" id="sales-report-section" style="display: block;">

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
                                    <li><a class="dropdown-item" href="#" id="topselling_report">Top Selling</a></li>
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

                                        <div class="d-flex align-items-center m-2" style="display: flex; flex-direction: column; left:0;flex-wrap: wrap; justify-content: center; align-items: center;">
                                            <canvas id="myPieChart" width="400" height="500"></canvas>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Top Selling Section, initially hidden -->
                    <div class="col-xxl-12 col-xl-12" id="top-selling-section" style="display: none;">
                        <div class="card top-selling overflow-auto" style="height: 505px !important;">
                            <div class="filter_type" id="filter-type">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Type Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#" id="sale_report">Sale</a></li>
                                    <li><a class="dropdown-item" href="#" id="order_report2">Order</a></li>
                                    <li><a class="dropdown-item" href="#" id="logistic_report">Logistic</a></li>
                                    <li><a class="dropdown-item" href="#" id="topselling_report">Top Selling</a></li>
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
                                                                <img src="../assets/images/default_images/tea_house.jpeg">
                                                            <?php } else { ?>
                                                                <img src="../assets/images/material_images/<?php echo $row['image']; ?>">
                                                        <?php }
                                                        } ?>
                                                    </td>
                                                    <td><a href="#" style="font-size: 12px; color: #000;"><?php echo $row['product_name']; ?></a></td>
                                                    <td><?php echo $row['price']; ?></td>
                                                    <td class="fw-bold"><?php echo $row['total_items_sold']; ?></td>
                                                    <td>$<?php echo $row['revenue']; ?></td>
                                                </tr>
                                        <?php }
                                        } ?>
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
    
    document.addEventListener('DOMContentLoaded', function() {
        // Make sure the element exists before adding the event listener
        const topsellingReportBtn = document.getElementById("topselling_report");
        const topSellingSection = document.getElementById("top-selling-section");
        const salesReportSection = document.getElementById("sales-report-section");

        // Log elements to ensure they exist
        console.log(topsellingReportBtn);
        console.log(topSellingSection);

        if (topsellingReportBtn && topSellingSection) {
            topsellingReportBtn.addEventListener("click", function() {
                console.log("Top Selling Report clicked");
                topSellingSection.style.display = "block"; // Show the Top Selling section
                salesReportSection.style.display = "none"; // Show the Top Selling section
            });
        } else {
            console.log("Elements not found, check the IDs.");
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Make sure the element exists before adding the event listener
    const logisticReportBtn = document.getElementById("logistic_report");
    const topSellingSection = document.getElementById("top-selling-section");
    const salesReportSection = document.getElementById("sales-report-section");

    // Log elements to ensure they exist
    console.log(logisticReportBtn);
    console.log(topSellingSection);
    console.log(salesReportSection);

    if (logisticReportBtn && salesReportSection && topSellingSection) {
        logisticReportBtn.addEventListener("click", function() {
            console.log("Logistic Report clicked");
            // Show the sales report section and hide the top selling section
            salesReportSection.style.display = "block";
            topSellingSection.style.display = "none";
        });
    } else {
        console.log("Elements not found, check the IDs.");
    }
});

    document.addEventListener("DOMContentLoaded", function() {



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
                                label: function(tooltipItem) {
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