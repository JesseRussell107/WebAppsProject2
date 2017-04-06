<?php
if (isset($_POST['projectnumber'])) {
    $projNum = $_POST['projectnumber'];
} else {
    $projNum = 1;
}
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Results</title>
    </head>
    <body>
        <a href="PeoplesChoice.php">Main Page</a>
        <form action="" method="post">
            <select name="projectnumber">
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query1 = "Select * from rjpc_project;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                    $project = mysql_fetch_assoc($result1);
                    if ($project["Opened"] === 1) {
                        echo "<option value=$i>Project $i</option>";
                    } else if ($project["Closed"] === 1){
                        echo "<option value=$i>Project $i</option>";
                    }
                }
                if (isset($_POST['projectnumber'])) {
                    $projNum = $_POST['projectnumber'];
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Go"/>
        </form>
        <div>
            <h2>
                <?php
                echo "Project $projNum scores";
                ?>
            </h2>
            <p>(Refresh to see up-to-date stats)<p>
            <div id="results">
                <table>
                    <tr>
                        <td><b>Contestants</b></td>
                        <td><b>Score</b></td>
                    </tr>
                    <?php
                    $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                    mysql_select_db("cs4220");
                    $query2 = "SELECT Team_ID, Total "
                            . "FROM rjpc_vote "
                            . "WHERE rjpc_vote.Project_ID = $projNum;";
                    $result2 = mysql_query($query2) or die("Vote Query Fail");
                    for ($j = 1; $j <= mysql_num_rows($result2); $j++) {
                        $score = mysql_fetch_assoc($result2);
                        $teamNumber = $score["Team_ID"];
                        $query3 = "SELECT Real_Name "
                                . "FROM rjpc_user, rjpc_team "
                                . "WHERE rjpc_team.Team_ID =$teamNumber "
                                . "AND rjpc_team.Project_ID =$projNum "
                                . "AND rjpc_team.User_ID = rjpc_user.User_ID;";
                        $result3 = mysql_query($query3);
                        echo "<tr><td>";
                        for ($k = 1; $k <= mysql_num_rows($result3); $k++) {
                            $row = mysql_fetch_assoc($result3);
                            $realname = $row["Real_Name"];
                            echo"$realname <br>";
                        }
                        echo "</td>";
                        $total = $score["Total"];
                        echo"<td>$total</td><tr>";
                    }
                    ?>
                </table>
            </div>
            <div id="writeins">
                <h3>Write-in Awards</h3>
                <table>
                    <?php
                    $query4 = "Select * from rjpc_write_in where Project_ID = $projNum;";
                    $result4 = mysql_query($query4);
                    while ($roww = mysql_fetch_assoc($result4)) {
                        $team = $roww["Team_ID"];
                        $query3 = "SELECT Real_Name "
                                . "FROM rjpc_user, rjpc_team "
                                . "WHERE rjpc_team.Team_ID =$team "
                                . "AND rjpc_team.Project_ID =$projNum "
                                . "AND rjpc_team.User_ID = rjpc_user.User_ID;";
                        $result3 = mysql_query($query3);
                        echo "<tr id=$team><td>";
                        for ($k = 1; $k <= mysql_num_rows($result3); $k++) {
                            $rowe = mysql_fetch_assoc($result3);
                            $realname = $rowe["Real_Name"];
                            echo"$realname <br>";
                        }
                        echo "</td><td>";
                        echo $roww["Message"];
                        echo "</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
