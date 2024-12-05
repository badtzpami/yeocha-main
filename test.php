<?php
// Ensure error reporting is enabled for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// MySQL database connection settings
$servername = "localhost:4306";  // Replace with your server information
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password
$dbname = "yeocha_main";  // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission when the button is clicked
if (isset($_POST['create_order'])) {

    // SQL query for selecting the last or_id and generating the new one
    $sql = "
    SET @last_or_id = (SELECT MAX(or_id) FROM `order`);
    SET @new_or_id = @last_or_id + 1;

    -- Randomly generate order_code using SQL functions
    SET @order_code = CONCAT(
        CHAR(65 + FLOOR(RAND() * 26)), 
        CHAR(65 + FLOOR(RAND() * 26)), 
        FLOOR(RAND() * 1000),
        CHAR(65 + FLOOR(RAND() * 26)), 
        CHAR(65 + FLOOR(RAND() * 26)), 
        CHAR(65 + FLOOR(RAND() * 26))
    );

    -- Random user_id between 4 and 8
    SET @user_id = FLOOR(RAND() * 5) + 4;

    -- Random sm_id from supplier_material (1-113)
    SET @sm_id = FLOOR(RAND() * 113) + 1;

    -- Get the selling price for selected sm_id from supplier_material
    SET @sell_price = (SELECT selling_price FROM supplier_material WHERE sm_id = @sm_id LIMIT 1);

    -- Random quantity between 1 and 20
    SET @quantity = FLOOR(RAND() * 20) + 1;

    -- Calculate total (quantity * sell_price)
    SET @total = @quantity * @sell_price;

    -- Round cash up to nearest hundred
    SET @cash = CEIL(@total / 100) * 100;

    -- Random shipment date (or 0000-00-00 00:00:00)
    SET @shipment_date_at = DATE_FORMAT(DATE_ADD('2024-01-01', INTERVAL FLOOR(RAND() * 365) DAY), '%Y-%m-%d %H:%i:%s');

    -- Random day_arrival format (e.g., '27 Nov')
    SET @day_arrival = DATE_FORMAT(@shipment_date_at, '%d %b');

    -- Random time_arrival between '8:00 AM - 8:00 PM'
    SET @time_arrival = CONCAT(FLOOR(RAND() * (20 - 8 + 1)) + 8, ':00 AM - ', FLOOR(RAND() * (20 - 8 + 1)) + 8, ':00 PM');

    -- Random status
    SET @status = ELT(FLOOR(RAND() * 6) + 1, 'Check Out', 'To Pack', 'To Ship', 'At Your Shop', 'Completed', 'Cancelled');

    -- Increment date_created_at between January 2023 and December 2024
    SET @date_created_at = DATE_FORMAT(DATE_ADD('2023-01-01', INTERVAL FLOOR(RAND() * 730) DAY), '%Y-%m-%d %H:%i:%s');

    -- Insert the new order into the 'order' table
    INSERT INTO `order` (or_id, order_code, user_id, sm_id, quantity, sell_price, total, cash, `change`, shipment_date_at, day_arrival, time_arrival, status, date_created_at)
    VALUES
    (@new_or_id, @order_code, @user_id, @sm_id, @quantity, @sell_price, @total, @cash, @total - @cash, @shipment_date_at, @day_arrival, @time_arrival, @status, @date_created_at);
    ";

    // Execute the SQL query
    if ($conn->multi_query($sql)) {
        echo "<p>New order created successfully!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

// Close the connection after processing
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>
<body>
    <h1>Create a New Order</h1>

    <!-- Form to trigger order creation -->
    <form method="POST">
        <button type="submit" name="create_order" value="1" style="width: 100%; height: 100%;">Create New Order</button>
    </form>

</body>
</html>
