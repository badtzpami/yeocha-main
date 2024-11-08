<?php

//main connection file for both admin & front end
$servername = "localhost:4306"; //server
$username = "root"; //username
$password = ""; //password
$dbname = "yeocha_main";  //database

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname); // connecting 

// Check connection
if (!$conn) {   //checking connection to DB	
    die("Connection failed: " . mysqli_connect_error());
}

?>
