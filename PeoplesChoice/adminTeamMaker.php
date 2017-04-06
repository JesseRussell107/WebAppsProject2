<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "./head.php";
    include "./header.php";
    include "./tools/dbConnect.php";
    $projNum = $_POST["openNew"];
    ?>
    <div id="content">
        <h1>Make Teams</h1>
        <form action="TeamSubmit.php" method="post">
            <input class="button" type="submit" name="getballot" value="Submit Teams"/>
            <input type="text" name="proj" value="<?php echo $projNum ?>" hidden/>
            <?php
            $query = "SELECT * from rjpc_user group by Real_Name;";
            $result = mysql_query($query) or die("User query fail");
            $query3 = "Select * from rjpc_project;";
            $result3 = mysql_query($query3) or die("Project Query Fail");
            echo "<table>";
            $count = 1;
            while ($row = mysql_fetch_assoc($result)) {
                if ($row["Real_Name"] != "Admin") {
                    echo "<tr><td>";
                    echo $row["Real_Name"];
                    echo "</td><td>";
                    $user = $row["User_ID"];
                    echo "<select name=$user>";
                    for ($i = 1; $i < mysql_num_rows($result); $i++) {
                        if ($i === $count) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                        echo "<option value=$i $selected>Team $i</option>";
                    }
                    echo "</select></td></tr>";
                    $count++;
                }
            }
            echo"</table>";
            ?>
        </form>
    </div>
    <?php
    include "footer.php";
}
?>