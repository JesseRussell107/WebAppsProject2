<?php
if (isset($_POST['votenumber'])) {
    $projNum = $_POST['votenumber'];
} else {
    $projNum = 0;
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Vote</title>
        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">

        </script>
    </head>
    <body>
        <a href="PeoplesChoice.php">Main Page</a>
        <h1>Vote</h1>
        <form action="" method="post">
            <select name="votenumber">
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query1 = "Select * from rjpc_project;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                //If there are no open projects
                if (mysql_num_rows($result1) == 0) {
                    echo "<option value='none'>None Open</option>";
                } else {
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        if ($project["Open"] == 1 && $project["Closed"] == 0) {
                            echo "<option value=" . $project["Project_ID"]
                            . ">Project "
                            . $project["Project_ID"] . "</option>";
                        }
                    }
                    if (isset($_POST['votenumber'])) {
                        $projNum = $_POST['votenumber'];
                    }
                }
                ?>
            </select>
            <input type="submit" name="getballot" value="Go"/>
        </form>
        <div>
            <form id='ballot' method="post" action="submitBallot.php">
                <?php
                //Will need to add another condition in here if the currently
                //logged in user has already voted
                //Will also need a way to post the writeins
                if ($projNum == 0) {
                    echo "Please select a project";
                } else {
                    echo "<input type='text' name='projNum' value='$projNum' hidden />";
                    echo "<input type='submit' name='sendballot' value='Submit my Ballot'><table>";
                    $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                    mysql_select_db("cs4220");
                    $query2 = "SELECT Team_ID, Total "
                            . "FROM rjpc_vote "
                            . "WHERE rjpc_vote.Project_ID = $projNum;";
                    $result2 = mysql_query($query2) or die("Vote Query Fail");
                    for ($j = 1; $j <= mysql_num_rows($result2); $j++) {
                        $score = mysql_fetch_assoc($result2);
                        $teamNum = $score["Team_ID"];
                        $query3 = "SELECT Real_Name "
                                . "FROM rjpc_user, rjpc_team "
                                . "WHERE rjpc_team.Team_ID =$teamNum "
                                . "AND rjpc_team.Project_ID =$projNum "
                                . "AND rjpc_team.User_ID = rjpc_user.User_ID;";
                        $result3 = mysql_query($query3);
                        echo "<tr id=$teamNum><td>";
                        for ($k = 1; $k <= mysql_num_rows($result3); $k++) {
                            $row = mysql_fetch_assoc($result3);
                            $realname = $row["Real_Name"];
                            echo"$realname <br>";
                        }
                        echo "</td><td>";
                        echo "<input type='radio' name='first' value='$teamNum' checked> First";
                        echo "</td><td>";
                        echo "<input type='radio' name='second' value='$teamNum'> Second";
                        echo "</td><td>";
                        echo "<input type='radio' name='third' value='$teamNum'> Third";
                        echo "</td></tr>";
                    }
                    echo "</table>";
                }
                ?>
                <div id='writeins'>
                    <?php
                    echo "<select name='writeinteam1'>";
                    $query = "SELECT * from rjpc_user group by Real_Name;";
                    $result = mysql_query($query) or die("User query fail");
                    while ($row = mysql_fetch_assoc($result)) {
                        if ($row["Real_Name"] != "Admin") {
                            echo "<option value=" . $row["User_ID"]
                            . ">" . $row["Real_Name"] . "</option>";
                        }
                    }
                    echo "<input type='text' name='writein1' />";
                    ?>
                    <!-- I need to ask Dr. G about how to do this part-->
                    <button id='addwritein' type='button' value='addwritein'>Add a Write-In</button>
                </div>
            </form>
        </div>
    </body>
</html>


