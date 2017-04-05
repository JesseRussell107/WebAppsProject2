<!DOCTYPE html>

<html>
    <head>
        <title>People's Choice Awards</title>
        
    </head>
    <body>
        <h1>People's Choice Awards</h1>
        <h3 id="hello">Hello, Guest</h3>
        <br> 
        <a href="Results.php">Results</a>
        <br> 
        <a href="Voting.php">Vote</a>
        <br>
        <h3>Placement (1st - 3rd)</h3>
        <div>
            <?php
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            $query = "SELECT * from rjpc_user group by Real_Name;";
            $result = mysql_query($query) or die("User query fail");
            $query3 = "Select * from rjpc_project;";
            $result3 = mysql_query($query3) or die("Project Query Fail");
            echo "<table><tr><td></td>";
            for ($i = 1; $i <= mysql_num_rows($result3); $i++) {
                echo "<td>  Project $i  </td>";
            }
            echo "</tr>";
            while ($row = mysql_fetch_assoc($result)) {

                if ($row["Real_Name"] != "Admin") {
                    echo "<tr><td>";
                    echo $row["Real_Name"];
                    echo "       </td>";
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
                            if ($holder == 0) {
                                echo " ";
                            } else {
                                echo "$holder";
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
    </body>
</html>