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
            $query1 = "Select * from rjpc_team where User_ID = $dummy" .
                    " and Project_ID = $projNum";
            //This will return one row
            $result1 = mysql_query($query1) or die("Team query fail");
            $row = mysql_fetch_assoc($result1);
            if ($row["Has_Voted"] == 1) {
                echo "You already voted, ya dingus!";
            } else {
                mysql_query("UPDATE `cs4220`.`rjpc_team` SET `Has_Voted` = '1' WHERE `rjpc_team`.`Team_ID` = "
                ."$teamNum AND `rjpc_team`.`User_ID` = $dummy AND `rjpc_team`.`Project_ID` = $projNum;")
                        or die('Error updating voting record');
                //add the votes to the teams
                
                
            }
        }
        ?>
    </body>
</html>


