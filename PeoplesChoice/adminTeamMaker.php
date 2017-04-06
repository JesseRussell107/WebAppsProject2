<?php include "./head.php"; ?>

<a href="PeoplesChoice.php">Main Page</a>
<h1>Make Teams</h1>
<form action="TeamSubmit.php" method="post">
    <select name="projectNumber">
        <?php
        $db = mysql_connect("james.cedarville.edu", "cs4220", "");
        mysql_select_db("cs4220");
        $query1 = "Select * from rjpc_project where Open = 0 AND Closed = 0;";
        $result1 = mysql_query($query1) or die("Project Query Fail");
        //If there are no open projects
        if (mysql_num_rows($result1) == 0) {
            echo "<option value='0'>No Unopened projects</option>";
        } else {
            for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                $project = mysql_fetch_assoc($result1);
                echo "<option value=" . $project["Project_ID"]
                . ">Project "
                . $project["Project_ID"] . "</option>";
            }
            if (isset($_POST['votenumber'])) {
                $projNum = $_POST['votenumber'];
            }
        }
        ?>
    </select>
    <input type="submit" name="getballot" value="Submit Teams"/>
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
            for ($i = 1; $i < mysql_num_rows($result); $i++) {
                echo "<option value=$i>Team $i</option>";
            }
            echo "</select></td></tr>";
        }
    }
    echo"</table>";
    ?>
</form>
<?php include "footer.php" ?>