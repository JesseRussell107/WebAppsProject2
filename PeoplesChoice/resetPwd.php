<?php

include "./head.php";
header("refresh:2;url=./admin.php");

$options = [
    'cost' => 10,
];
$newpass = password_hash("password", PASSWORD_DEFAULT, $options);

$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$userID = $_POST["userid"];
mysql_query("Update rjpc_user set Password = \"$newpass\" WHERE User_ID = $userID") or die("Error resetting user");
echo "<p>Successfully reset password; redirecting</p>"
?>