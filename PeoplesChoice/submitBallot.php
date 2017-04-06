<!DOCTYPE html>

<html>
    <head>
        <title>Vote</title>
    </head>
    <body>
        <a href="Results.php">Results</a>
        <br> 
        <?php
        if (isset($_POST["first"])) {
            $first = $_POST["first"];
        }
        if (isset($_POST["second"])) {
            $second = $_POST["second"];
        }
        if (isset($_POST["third"])) {
            $third = $_POST["third"];
        }
        $projNum = $_POST["projNum"];
        if (!isset($first) || !isset($second) || !isset($third)) {
            echo "You didn't vote for all the positions. Grow a backbone, ya pansy!";
        } else if ($first == $second || $first == $third || $second == $third) {
            echo "You moron! You can't make someone first second and third!";
        } else {
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            //*******************************************
            $dummy = $_SESSION["userName"];
            //*******************************************
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
                
                mysql_query("UPDATE rjpc_team SET Place = 0 WHERE Project_ID = $projNum AND Place = 1") or die ("Error zeroing first");
                mysql_query("UPDATE rjpc_team SET Place = 0 WHERE Project_ID = $projNum AND Place = 2") or die ("Error zeroing second");
                mysql_query("UPDATE rjpc_team SET Place = 0 WHERE Project_ID = $projNum AND Place = 3") or die ("Error zeroing third");

                $placement = mysql_query("SELECT * FROM rjpc_vote Where Project_ID = $projNum GROUP BY Total DESC LIMIT 3;") 
                        or die("Error with placement query");
                
                
                
                $firstplace = mysql_fetch_assoc($placement);
                $secondplace = mysql_fetch_assoc($placement);
                $thirdplace = mysql_fetch_assoc($placement);
                
                $firstteam = $firstplace["Team_ID"];
                mysql_query("UPDATE rjpc_team SET Place = 1 WHERE Project_ID = $projNum AND Team_ID = $firstteam");

                $secondteam = $firstplace["Team_ID"];
                mysql_query("UPDATE rjpc_team SET Place = 2 WHERE Project_ID = $projNum AND Team_ID = $secondteam");
                
                $thirdteam = $firstplace["Team_ID"];
                mysql_query("UPDATE rjpc_team SET Place = 3 WHERE Project_ID = $projNum AND Team_ID = $thirdteam");
                //need a for loop to post the write ins
                //This will need to be fixed
                $haswriteins = true;
                $i = 0;
                while ($haswriteins) {
                    $i = $i + 1;
                    $thingname = "writein" . (String) $i;
                    if (isset($_POST[$thingname])) {
                        //Do a query
                        $team = $_POST[(String) $i];
                        $message = $_POST[$thingname];
                        mysql_query("Insert into rjpc_write_in (Team_ID, Project_ID, Message) "
                                        . "Values ($team, $projNum, \"$message\");") or die("Error sending write-ins");
                    } else {
                        $haswriteins = false;
                    }
                }
                echo "Thank you for your votes.";
                mysql_query("UPDATE `cs4220`.`rjpc_team` SET `Has_Voted` = '1' WHERE"
                                . " `rjpc_team`.`User_ID` = $dummy AND `rjpc_team`.`Project_ID` = $projNum;")
                        or die('Error updating voting record');
            }
        }
        ?>
    </body>
</html>


