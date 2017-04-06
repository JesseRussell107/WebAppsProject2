<?php
include "./head.php";
header("refresh:2;url=./admin.php");
$db = mysql_connect("james.cedarville.edu", "cs4220", "");
mysql_select_db("cs4220");
$query = "SELECT * from rjpc_user where User_ID != 1 group by Real_Name;";
$result = mysql_query($query) or die("User query fail");
$projNum = $_POST["proj"];
for ($i = 0; $i < mysql_num_rows($result); $i++) {
    $row = mysql_fetch_assoc($result);
    $userid = (String) $row["User_ID"];
    $teamid = $_POST[$userid];
    mysql_query("Insert into rjpc_team(Team_ID,User_ID,Project_ID,Has_Voted,Place) "
                    . "values ($teamid, $userid, $projNum,0,0);") or die("Error inserting a team");
}
mysql_query("Update rjpc_project Set Open = 1 Where Project_ID = $projNum;") or die("Error opening project");
echo "<p>Successfully created teams; redirecting</p>"
?>