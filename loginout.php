<?php
session_start();
unset($_SESSION['user']);
header("Location: ./public/index.php");
exit();