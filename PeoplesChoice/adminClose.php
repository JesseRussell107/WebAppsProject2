<?php

include "./head.php";
header("refresh:2;url=./admin.php");
$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$projNum = $_POST["close"];

mysql_query("Update rjpc_project Set Closed = 1 Where Project_ID = $projNum;") or die("Error closing project");
mysql_query("Update rjpc_project Set Open = 0 Where Project_ID = $projNum;") or die("Error unopening project");
echo "<p>Successfully closed project; redirecting</p>"
?>