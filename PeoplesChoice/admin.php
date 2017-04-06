<?php
session_start();
include "./head.php";
//not admin, then cannot access
if ($_SESSION["userName"] != 1) {
    header("location:./PeoplesChoice.php");
    exit();
}
include "./header.php";
include "./tools/dbConnect.php";
?>
<div id="content">
    <!--manage projects-->
    <div class="section">
        <h2>Manage Projects</h2>
        <?php
        //open new projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 0 and Closed = 0;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminTeamMaker.php"); ?>">
                <label for="openNew">Open Projects:</label>
                <select name="openNew" id="openNew" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 0 and Closed = 0 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=" . $project['Project_ID'] . ">Project " . $project['Project_ID'] . "</option>";
                    }
                    ?>
                </select>
                <input class="button" id="openNewButton" type="submit" value="Open"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to open for the first time</p>");
        }

        //close open projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 1;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminClose.php"); ?>">
                <label for="close">Close Projects:</label>
                <select name="close" id="close" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 1 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=" . $project['Project_ID'] . ">Project " . $project['Project_ID'] . "</option>";
                    }
                    ?>
                </select>
                <input class="button" id="closeButton" type="submit" value="Close"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to close</p>");
        }

        //re-open projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 0 and Closed = 1;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminReopen.php"); ?>">
                <label for="reopen">Re-open Projects:</label>
                <select name="reopen" id="reopen" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 0 and Closed = 1 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=" . $project['Project_ID'] . ">Project " . $project['Project_ID'] . "</option>";
                    }
                    ?>
                </select>
                <input class="button" id="reopenButton" type="submit" value="Re-Open"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to re-open</p>");
        }
        ?>
    </div>
    <!--modify users-->
    <div class="section">
        <h2>Manage Users</h2>
        <table>
            <?php
            $query = "SELECT * from rjpc_user group by Real_Name;";
            $result = mysql_query($query) or die("User query fail");
            echo "<tr><th>Name</th><th>Delete</th><th>Reset</th></tr>";
            while ($row = mysql_fetch_assoc($result)) {
                echo "<tr><td>";
                echo "<a href='http://judah.cedarville.edu/~" . $row["Username"] . "/cs3220.html'>" . $row["Real_Name"] . "</a>";
                echo "</td>";
                echo "<td><form method='post' action=\"" . htmlspecialchars("./deleteUser.php") . "\">";
                echo "<input type='text' name='userid' value ='" . $row["User_ID"] . "' hidden />";
                if ($row["Real_Name"] != "Admin") {
                    echo "<input class='button' type='submit' value ='Delete User'/>";
                }
                echo "</form>";
                echo "</td>";
                echo "<td><form method='post' action=\"" . htmlspecialchars("./resetPwd.php") . "\">";
                echo "<input type='text' name='userid' value ='" . $row["User_ID"] . "' hidden />";
                echo "<input class='button' type='submit' value ='Reset Password'/>";
                echo "</form>";
                echo "</td></tr>";
            }
            ?>
        </table>
    </div>
    <!--add users-->
    <div class="section">
        <h2>Add Users</h2>
        <form method='post' action=" <?php echo htmlspecialchars("./addUser.php") ?>">
            <input type="text" name="username"/>
            <input type="text" name="realname"/>
            <input class="button" type="submit" value="Add User"/>
        </form>
    </div>
    <!--new class-->
    <div class="section">
        <h2>New Class</h2>
        <form method="post" action="<?php echo htmlspecialchars("./newClass.php") ?>">
            <input type="text" name="numProj"/>
            <input class="button" type="submit" value="Boom"/>
        </form>
    </div>
</div>
<?php
include "./footer.php";
mysql_close($db);
?>