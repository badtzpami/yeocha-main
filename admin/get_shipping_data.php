<?php
include '../config/connect.php';

// Retrieve filter type
$filter = $_GET['filter'];
$countOrder = 0;
$prevCountOrder = 0;
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


// Current period query
$query = "SELECT COUNT(or_id) AS countOrder, date_created_at  FROM `order_history` WHERE $dateCondition AND status = 'Check Out' OR status = 'Cancelled' ";
$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $countOrder = (int)$row['countOrder'];
}

// Previous period query
$prevQuery = "SELECT COUNT(or_id) AS prevCountOrder, date_created_at  FROM `order_history` WHERE $prevDateCondition AND status = 'Check Out' OR status = 'Cancelled' ";
$prevResult = $conn->query($prevQuery);

if ($prevResult && $prevRow = $prevResult->fetch_assoc()) {
    $prevCountOrder = (int)$prevRow['prevCountOrder'];
}

// Calculate percentage change
$percentage = $prevCountOrder > 0 ? ($countOrder / $prevCountOrder)* 50 : 0;


// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'countOrder' => $countOrder,
    'percentage' => $percentage,
]);

$conn->close();
?>
