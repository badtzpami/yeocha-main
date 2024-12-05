<?php

// Include database connection
include '../config/connect.php';

// Retrieve filter type
$filter = $_GET['filter'];
$salesCount = 0;
$prevSalesCount = 0;
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
$query = "SELECT COUNT(sa_id) AS new_sales, date_created_at FROM sale WHERE $dateCondition ";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $salesCount = (int)$row['new_sales'];
}

// Query for previous period sales data
$prevQuery = "SELECT COUNT(sa_id) AS before_sales, date_created_at FROM sale WHERE $prevDateCondition ";
$prevResult = $conn->query($prevQuery);

if ($prevResult && $prevRow = $prevResult->fetch_assoc()) {
    $prevSalesCount = (int)$prevRow['before_sales'];
}

// Calculate percentage change
$percentage = $prevSalesCount > 0 ? (($salesCount / $prevSalesCount) / $prevSalesCount) * 100 : 0;

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'salesCount' => $salesCount,
    'percentage' => round($percentage,1)
]);

$conn->close();
?>
