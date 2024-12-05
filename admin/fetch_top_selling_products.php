<?php
include '../config/connect.php';

// Get filter from query parameter
$filter = $_GET['filter'] ?? 'daily';
$dateCondition = "";

if ($filter === 'daily') {
    $dateCondition = "DATE(s.date_created_at) = CURDATE()";
} elseif ($filter === 'weekly') {
    $dateCondition = "DATE(s.date_created_at) >= DATE(NOW() - INTERVAL 7 DAY)";
} elseif ($filter === 'monthly') {
    $dateCondition = "DATE(s.date_created_at) >= DATE(NOW() - INTERVAL 1 MONTH)";
} elseif ($filter === 'yearly') {
    $dateCondition = "DATE(s.date_created_at) >= DATE(NOW() - INTERVAL 1 YEAR)";
}

// Query to fetch filtered data
$query = "
    SELECT 
        p.image AS product_image,
        p.product_name,
        p.selling_price AS price,
        SUM(s.quantity) AS total_items_sold,
        SUM(s.sell_price * s.quantity) AS revenue
    FROM 
        product p
    JOIN 
        sale s ON p.pr_id = s.pr_id
    WHERE 
        $dateCondition
    GROUP BY 
        p.pr_id
    ORDER BY 
        total_items_sold DESC
";

$result = $conn->query($query);

$data = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'product_image' => !empty($row['product_image']) 
                ? "../assets/images/material_images/{$row['product_image']}" 
                : "../assets/images/default_images/tea_house.jpeg",
            'product_name' => $row['product_name'],
            'price' => number_format($row['price'], 2),
            'total_items_sold' => $row['total_items_sold'],
            'revenue' => number_format($row['revenue'], 2),
        ];
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>
