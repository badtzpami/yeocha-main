<?php
session_start();
session_destroy();

$url = '../usersignin/signin.php';
header('Location: ' . $url);
?>