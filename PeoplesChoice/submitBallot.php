<!DOCTYPE html>

<html>
    <head>
        <title>Vote</title>
    </head>
    <body>
        <a href="Results.php">Results</a>
        <br> 
        <?php
        $first = $_POST["first"];
        $second = $_POST["second"];
        $third = $_POST["third"];
        $projNum = $_POST["projNum"];
        if ($first == $second || $first == $third || $second == $third) {
            echo "You moron! You can't make someone first second and third!";
        } else {
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            //need a way to tie the currently logged in user to this.
            $dummy = 138; //Jesse's ID
            $teamNum = 5; //Jesse's team for project 2
            $query1 = "Select * from rjpc_team where User_ID = $dummy" .
                    " and Project_ID = $projNum";
            //This will return one row
            $result1 = mysql_query($query1) or die("Team query fail");
            $row = mysql_fetch_assoc($result1);
            if ($row["Has_Voted"] == 1) {
                echo "You already voted, ya dingus!";
            } else {
                mysql_query("UPDATE `cs4220`.`rjpc_team` SET `Has_Voted` = '1' WHERE `rjpc_team`.`Team_ID` = "
                                . "$teamNum AND `rjpc_team`.`User_ID` = $dummy AND `rjpc_team`.`Project_ID` = $projNum;")
                        or die('Error updating voting record');

                //add the votes to the teams
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `First` = 'First' + 3 WHERE `rjpc_team`.`Team_ID` = $first"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting first");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = 'Total' + 3 WHERE `rjpc_team`.`Team_ID` = $first"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting first total");

                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Second` = 'Second' + 2 WHERE `rjpc_team`.`Team_ID` = $second"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting second");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = 'Total' + 2 WHERE `rjpc_team`.`Team_ID` = $second"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting third total");

                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Third` = 'Third' + 1 WHERE `rjpc_team`.`Team_ID` = $third"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting third");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = 'Total' + 1 WHERE `rjpc_team`.`Team_ID` = $third"
                                . " AND `rjpc_team`.`Project_ID` = $projNum;") or die("Error voting third total");

                //need a for loop to post the write ins
                
                
            }
        }
        ?>
    </body>
</html>


