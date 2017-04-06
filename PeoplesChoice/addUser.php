<?php

include "./head.php";
header("refresh:2;url=./admin.php");

$options = [
    'cost' => 10,
];
$newpass = password_hash("password", PASSWORD_DEFAULT, $options);

$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$userName = $_POST["username"];
$realName = $_POST["realname"];
mysql_query("Insert into rjpc_user(Username,Password,Real_Name) values (\"$userName\",\"$newpass\",\"$realName\");") or die("Error deleting user");
echo "<p>Successfully added user; redirecting</p>"
?>