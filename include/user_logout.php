<?php
session_start();
session_destroy();

$url = '../user_signin/signin.php';
header('Location: ' . $url);
?>