<!DOCTYPE HTML>
<html>
    <?php
    include "./head.php";
    ?>
    <body>
        <h1>Make Teams</h1>
        <form action="" method="post">
            <select name="votenumber">
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query1 = "Select * from rjpc_project;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                //If there are no open projects
                if (mysql_num_rows($result1) == 0) {
                    echo "<option value='0'>None Closed</option>";
                } else {
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        if ($project["Open"] == 0 && $project["Closed"] == 1) {
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
        <form method="post">
            <?php
            $query = "SELECT * from rjpc_user group by Real_Name;";
            $result = mysql_query($query) or die("User query fail");
            $query3 = "Select * from rjpc_project;";
            $result3 = mysql_query($query3) or die("Project Query Fail");
            echo "<table>";
            while ($row = mysql_fetch_assoc($result)) {
                if ($row["Real_Name"] != "Admin") {
                    echo "<tr><td>";
                    echo $row["Real_Name"];
                    echo "</td><td>";
                    $user = $row["User_ID"];
                    echo "<select name=$user>";
                    for ($i = 1; $i <= mysql_num_rows($result); $i++) {
                        echo "<option value=$i>Team $i</option>";
                    }
                    echo "</select></td></tr>";
                }
            }
            echo"</table>";
            ?>
        </form>
    </body>
</html>