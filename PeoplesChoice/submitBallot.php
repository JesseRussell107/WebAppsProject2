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
            $teamNumber = 5; //Jesse's team for project 2
            $query1 = "Select * from rjpc_team where User_ID = $dummy" .
                    " and Project_ID = $projNum";
            //This will return one row
            $result1 = mysql_query($query1) or die("Team query fail");
            $row = mysql_fetch_assoc($result1);
            if ($row["Has_Voted"] == 1) {
                echo "You already voted, ya dingus!";
            } else {

                //add the votes to the teams
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `First` = First + 3 WHERE `rjpc_vote`.`Team_ID` = $first"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting first");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = Total + 3 WHERE `rjpc_vote`.`Team_ID` = $first"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting first total");

                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Second` = Second + 2 WHERE `rjpc_vote`.`Team_ID` = $second"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting second");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = Total + 2 WHERE `rjpc_vote`.`Team_ID` = $second"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting third total");

                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Third` = Third + 1 WHERE `rjpc_vote`.`Team_ID` = $third"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting third");
                mysql_query("UPDATE `cs4220`.`rjpc_vote` SET `Total` = Total + 1 WHERE `rjpc_vote`.`Team_ID` = $third"
                                . " AND `rjpc_vote`.`Project_ID` = $projNum;") or die("Error voting third total");

                mysql_query("UPDATE `cs4220`.`rjpc_team` SET `Has_Voted` = '1' WHERE `rjpc_team`.`Team_ID` = "
                                . "$teamNumber AND `rjpc_team`.`User_ID` = $dummy AND `rjpc_team`.`Project_ID` = $projNum;")
                        or die('Error updating voting record');


                //need a for loop to post the write ins
                //This will need to be fixed
                $haswriteins = true;
                $i = 0;
                while($haswriteins){
                    $i = $i + 1;
                    $thingname = "writein" .(String) $i;
                    if(isset($_POST[$thingname])){
                        //Do a query
                        $team = $_POST[(String) $i];
                        $message = $_POST[$thingname];
                        $query5 = "Insert into rjpc_writein (Team_ID, Project_ID, Message) "
                                . "Values ($team, $projNum, $message);";
                        $mysql_query($query5) or die("Error sending write-ins");
                    } else {
                        $haswriteins = false;
                    }
                }
                echo "Thank you for your votes.";
            }
        }
        ?>
    </body>
</html>


