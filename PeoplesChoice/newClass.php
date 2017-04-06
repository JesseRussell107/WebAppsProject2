<?php

include "./head.php";
header("refresh:2;url=./admin.php");

$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");

$numProj = $_POST["numProj"];
mysql_query("Delete from rjpc_write_in Where 1") or die("Error deleting writein");
mysql_query("Delete from rjpc_vote Where 1") or die("Error deleting vote");
mysql_query("Delete from rjpc_project Where 1") or die("Error deleting project");
mysql_query("Delete from rjpc_team Where 1") or die("Error deleting team");
mysql_query("Delete from rjpc_user Where User_ID != 1") or die("Error deleting user");
for($i = 1; $i<=intval($numProj); $i++){
    mysql_query("Insert into rjpc_project(Project_ID) Values ($i)") or die("Error inserting project");
}
echo "<p>Successfully created new class; redirecting</p>"
?>