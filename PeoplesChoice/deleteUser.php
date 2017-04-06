<?php
include "./head.php";
header("refresh:2;url=./admin.php");
$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$userID = $_POST["userid"];
mysql_query("DELETE FROM `rjpc_user` WHERE User_ID = $userID") or die("Error deleting user");
echo "<p>Successfully removed user; redirecting</p>"
?>