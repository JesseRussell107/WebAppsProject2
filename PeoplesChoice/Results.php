<?php
if (isset($_POST['projectnumber'])) {
    $projNum = $_POST['projectnumber'];
}
?>


<!DOCTYPE html>

<html>
    <head>
        <title>Results</title>
    </head>
    <body>
        <form action="" method="post">
            <select name="projectnumber">
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query1 = "Select * from rjpc_project;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                    $project = mysql_fetch_assoc($result1);
                    if ($project["Opened"] == 1 || $project["Closed"] == 1) {
                        echo "<option value=$i>Project $i</option>";
                    }
                }
                $db.close();
                ?>
            </select>
            <input type="submit" name="submit" value="Go"/>
        </form>
        <div>
            <h2>
                <?php
                echo "Project $projNum";
                ?>
            </h2>
            <div id="results">
                <table>
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query2 = "SELECT Real_Name, rjpc_team.Team_ID, Total " .
                        "FROM rjpc_team, rjpc_user, rjpc_vote " .
                        "WHERE rjpc_team.Team_ID = rjpc_vote.Team_ID " .
                        "AND rjpc_team.Project_ID = $projNum " .
                        "AND rjpc_vote.Project_ID = $projNum " .
                        "AND rjpc_team.User_ID = rjpc_user.User_ID;";
                $result2 = mysql_query($query2) or die("Vote Query Fail");
                for ($j = 1; $j <= mysql_num_rows($result2); $j++) {
                    $score = mysql_fetch_assoc($result2);
                    $realname = $score["Real_Name"];
                    
                    echo "<tr>";
                    echo"<td> $realname </td>";
                    
                }
                $db.close();
                ?>
                </table>
            </div>
        </div>
    </body>
</html>
