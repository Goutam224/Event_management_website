<?php 
include 'connection.php';
session_start();
unset($_SESSION['IS_LOGIN']);
session_destroy();
header('location:login.php');
?>