<?php include "./head.php" ?>
<?php include "./logIn.php" ?>
<div id="content">
    <?php
    //find out if we should disable viewing (no projects to view)
    $db = mysql_connect("james.cedarville.edu", "cs4220", "");
    mysql_select_db("cs4220");
    $countquery = "Select count(Project_ID) from rjpc_project where Open = 1 or Closed = 1;";
    $countresult = mysql_query($countquery);
    $countrow = mysql_fetch_assoc($countresult);
    if (intval($countrow["count(Project_ID)"]) > 0) {
        $selectMenu = "";
        $selectenable = "enabled";
    } else {
        $selectMenu = "hidden";
        $selectenable = "disabled";
    }
    if ($_SESSION["isLoggedIn"]) {
        //find out if we should disable voting
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 1;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            if ($_SESSION["userName"] == 1) {
                $voteMenu = "hidden";
                $voteenable = "disabled";
            } else {
                $voteenable = "enabled";
            }
        } else {
            $voteMenu = "hidden";
            $voteenable = "disabled";
        }
        ?>
        <form class="actionForm" action="Voting.php" method="post">
            <select name="votenumber" <?php echo $voteMenu; ?>>
                <?php
                $query1 = "Select * from rjpc_project where Open = 1;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                //If there are no open projects

                for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                    $project = mysql_fetch_assoc($result1);
                    echo "<option value=" . $project["Project_ID"]
                    . ">Project "
                    . $project["Project_ID"] . "</option>";
                }
                if (isset($_POST['votenumber'])) {
                    $projNum = $_POST['votenumber'];
                }
                ?>
            </select>
            <input class="button" type="submit" name="getballot" value="Vote" <?php echo $voteenable; ?>/>
        </form>
        <?php
    }
    ?>

    <form class="actionForm" action="Results.php" method="post">
        <select name="projectnumber" <?php echo $selectMenu; ?>>
            <?php
            $query1 = "Select * from rjpc_project where Open = 1 or Closed = 1 order by Project_ID ;";
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
        <input class="button" type="submit" name="submit" value="View Results" <?php echo $selectenable; ?>/>
    </form>
    <?php
    $query = "SELECT * from rjpc_user group by Real_Name;";
    $result = mysql_query($query) or die("User query fail");
    $query3 = "Select * from rjpc_project;";
    $result3 = mysql_query($query3) or die("Project Query Fail");
    echo "<table><th></th>";
    for ($i = 1; $i <= mysql_num_rows($result3); $i++) {
        echo "<th>  Project $i  </th>";
    }
    echo "</tr>";
    while ($row = mysql_fetch_assoc($result)) {

        if ($row["Real_Name"] != "Admin") {
            echo "<tr><td>";
            echo "<a href='http://judah.cedarville.edu/~" . $row["Username"] . "/cs3220.html'>" . $row["Real_Name"] . "</a>";
            echo "       </td>";
            $user = $row["User_ID"];
            $query2 = "SELECT * from rjpc_team where User_ID = '$user' group by Project_ID;";
            $result2 = mysql_query($query2) or die("Score Query Fail");
            //Iterate over the projects
            for ($projNum = 1; $projNum <= mysql_num_rows($result3); $projNum++) {
                echo "<td class='center reward'>";
                //print out this user's score in each of the table sections.
                $place = mysql_fetch_assoc($result2);
                if ($place["Project_ID"] == $projNum) {
                    $holder = $place["Place"];
                    if ($holder == 1) {
                        echo "<img src='img/1st.png' alt='1st'>";
                    } else if ($holder == 2) {
                        echo "<img src='img/2nd.png' alt='2nd'>";
                    } else if ($holder == 3) {
                        echo "<img src='img/3rd.png' alt='3rd'>";
                    } else {
                        echo "";
                    }
                } else {
                    echo " ";
                }

                echo "</td>";
            }
            echo "</tr>";
        }
    }
    echo"</table>";
    ?>
</div>
<?php include "footer.php" ?>
