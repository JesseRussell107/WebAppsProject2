<?php
if (isset($_POST['projectnumber'])) {
    $projNum = $_POST['projectnumber'];
} else {
    $projNum = 1;
}
include "./head.php";
include "./header.php";
?>
<div id="content">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <select name="projectnumber">
            <?php
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            $query1 = "Select * from rjpc_project where Open = 1 or Closed = 1 order by Project_ID;";
            $result1 = mysql_query($query1) or die("Project Query Fail");
            for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                $project = mysql_fetch_assoc($result1);
                echo "<option value=".$project['Project_ID'].">Project ".$project['Project_ID']."</option>";
            }
            if (isset($_POST['projectnumber'])) {
                $projNum = $_POST['projectnumber'];
            }
            ?>
        </select>
        <input class="button" type="submit" name="submit" value="View Project"/>
    </form>
    <div>
        <h2 class="center">
            <?php
            echo "Project $projNum scores";
            ?>
        </h2>
        <p class="center">(Refresh to see up-to-date stats)<p>
        <div id="results">
            <table>
                <tr>
                    <th>Contestants</th>
                    <th>Score</th>
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
                    echo"<td class='center'>$total</td></tr>";
                }
                ?>
            </table>
        </div>
        <div id="writeins">
            <h3 class="center">Write-in Awards</h3>
            <table>
                <tr>
                    <th>Team</th>
                    <th>Message</th>
                </tr>
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
                    echo "</td><td class='center'>";
                    echo $roww["Message"];
                    echo "</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>
<?php include "./footer.php"; ?>
