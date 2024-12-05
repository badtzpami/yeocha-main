<?php
header('Content-Type: application/json');

// Include database connection
include '../config/connect.php';

$type = $_GET['type'] ?? 'sale'; // 'sale', 'order', or 'logistic'
$timeframe = $_GET['timeframe'] ?? 'monthly'; // 'daily', 'weekly', or 'monthly'

$query = "";

if ($type == 'sale') {
    if ($timeframe == 'daily') {
        $query = "SELECT DATE(date_column) AS label, SUM(amount) AS value
                  FROM sale
                  WHERE status = 'Check Out'
                  AND date_column >= CURDATE() - INTERVAL 7 DAY
                  GROUP BY DATE(date_column)
                  ORDER BY DATE(date_column)";
    } elseif ($timeframe == 'weekly') {
        $query = "SELECT CONCAT('Week ', WEEK(date_column)) AS label, SUM(amount) AS value
                  FROM sale
                  WHERE status = 'Check Out'
                  AND date_column >= CURDATE() - INTERVAL 8 WEEK
                  GROUP BY WEEK(date_column)
                  ORDER BY WEEK(date_column)";
    } else {
        $query = "SELECT MONTHNAME(date_column) AS label, SUM(amount) AS value
                  FROM sale
                  WHERE status = 'Check Out'
                  GROUP BY MONTH(date_column)
                  ORDER BY MONTH(date_column)
                  LIMIT 8";
    }
} elseif ($type == 'order') {
    $query = "SELECT MONTHNAME(date_column) AS label, COUNT(*) AS value
              FROM orders
              WHERE status = 'Completed'
              GROUP BY MONTH(date_column)
              ORDER BY MONTH(date_column)
              LIMIT 8";
} elseif ($type == 'logistic') {
    $query = "SELECT MONTHNAME(date_column) AS label, SUM(amount) AS value
              FROM logistics
              WHERE status = 'Completed'
              GROUP BY MONTH(date_column)
              ORDER BY MONTH(date_column)
              LIMIT 8";
}

$result = $conn->query($query);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
