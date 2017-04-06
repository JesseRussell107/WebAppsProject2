<?php include "./head.php"; ?>

<a href="PeoplesChoice.php">Back to Main Page</a>
<div>
    <?php
    $db = mysql_connect("james.cedarville.edu", "cs4220", "");
    mysql_select_db("cs4220");
    $query = "SELECT * from rjpc_user where User_ID != 1 group by Real_Name;";
    $result = mysql_query($query) or die("User query fail");
    $projNum = $_POST["projectNumber"];
    for ($i = 0; $i < mysql_num_rows($result); $i++) {
        $row = mysql_fetch_assoc($result);
        $userid = (String) $row["User_ID"];
        $teamid = $_POST[$userid];
        mysql_query("Insert into rjpc_team(Team_ID,User_ID,Project_ID,Has_Voted,Place) "
                . "values ($teamid, $userid, $projNum,0,0);") or die("Error inserting a team");
    }
    echo "Teams have been set up.";
    ?>
</div>
<?php include "./footer.php"; ?>
