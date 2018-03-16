<?php
session_start();
$_SESSION['admin'] = "false";
$_SESSION['mgr'] = "false";
header("Location: login.php");
  ?>