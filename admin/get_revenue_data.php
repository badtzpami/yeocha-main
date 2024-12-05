<?php

// Include database connection
include '../config/connect.php';

// Retrieve filter type
$filter = $_GET['filter'];
$salesCount = 0.0;
$salesSum = 0.0;
$prevSalesCount = 0.0;
$prevSalesSum = 0.0;
$percentage = 0.0;

// Determine date range
$dateCondition = '';
$prevDateCondition = ''; // Variable to store the condition for the previous period

if ($filter === 'week') {
    $dateCondition = "DATE(date_created_at) >= DATE(NOW() - INTERVAL 7 DAY)";
    $prevDateCondition = "DATE(date_created_at) >= DATE(NOW() - INTERVAL 14 DAY)";
} elseif ($filter === 'month') {
    $dateCondition = "DATE(date_created_at) >= DATE(NOW() - INTERVAL 1 MONTH)";
    $prevDateCondition = "DATE(date_created_at) >= DATE(NOW() - INTERVAL 2 MONTH)";
} elseif ($filter === 'year') {
    $dateCondition = "YEAR(date_created_at) = YEAR(NOW())";
    $prevDateCondition = "YEAR(date_created_at) = YEAR(NOW() - INTERVAL 1 YEAR)";
}

// Query for current period sales data

$query = "SELECT count(sa_id) AS new_sales, SUM(total) AS new_sum, date_created_at FROM sale WHERE $dateCondition ";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $salesCount = (float)$row['new_sales'];
    $salesSum = (float)$row['new_sum'];
}

// Query for previous period sales data
$prevQuery = "SELECT count(sa_id) AS before_sales, SUM(total) AS before_sum, date_created_at FROM sale WHERE $prevDateCondition ";
$prevResult = $conn->query($prevQuery);


if ($prevResult && $prevRow = $prevResult->fetch_assoc()) {
    $prevSalesCount = (float)$prevRow['before_sales'];
    $prevSalesSum = (float)$prevRow['before_sum'];
}

// Calculate percentage change (prevent division by zero)

$percentage = (($salesCount / $prevSalesCount) / $prevSalesCount) * 100;

// Return JSON response
header('Content-Type: application/json');

echo json_encode([
    'revenue' => $salesSum,
    'percentage' => $percentage
]);


$conn->close();
?>
