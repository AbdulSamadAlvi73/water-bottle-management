<?php

include("./conn.php");

session_start();
session_unset();
session_destroy();
header('location:./Admin/admin.php');

?>