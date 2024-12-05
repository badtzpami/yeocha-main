<?php
session_start();
session_destroy();

$url = '../usersignin/index.php';
header('Location: ' . $url);
?>