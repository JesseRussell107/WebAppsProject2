<?php
include "./head.php";
header("refresh:2;url=./admin.php");
$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$projNum = $_POST["reopen"];
mysql_query("Update rjpc_project Set Open = 1 Where Project_ID = $projNum;") or die("Error reopening project");
echo "<p>Successfully reopened project; redirecting</p>"
?>