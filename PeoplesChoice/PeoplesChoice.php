<!DOCTYPE html>

<html>
    <head>
        <title>People's Choice Awards</title>
    </head>
    <body>
        <h2>People's Choice Awards</h2>
        <a href="Results.php">Results</a>
        <div>
            <?php
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            $query = "SELECT * from rjpc_user;";
            $result = mysql_query($query) or die("User query fail");
            $query3 = "Select * from rjpc_project;";
            $result3 = mysql_query($query3) or die("Project Query Fail");
            echo "<table><tr><td></td>";
            for ($i = 1; $i <= mysql_num_rows($result3); $i++) {
                echo "<td>Project $i</td>";
            }
            echo "</tr>";
            while ($row = mysql_fetch_assoc($result)) {
                echo "<tr><td>";
                echo $row["Real_Name"];
                echo "</td>";
                $user = $row["User_ID"];
                $query2 = "SELECT * from rjpc_team where User_ID = '$user';";
                $result2 = mysql_query($query2) or die("Score Query Fail");
                //Iterate over the projects
                for ($projNum = 1; $projNum <= mysql_num_rows($result3); $projNum++) {
                    echo "<td>";
                    //print out this user's score in each of the table sections.
                    $place = mysql_fetch_assoc($result2);
                    if ($place["Project_ID"] == $projNum) {
                        $holder = $place["Place"];
                        echo "$holder";
                    } else {
                        echo "0";
                    }

                    echo "</td>";
                }
                echo "</tr>";
            }
            echo"</table>";
            ?>
        </div>
    </body>
</html>