<?php
    if(isset($_POST['projectnumber'])){
        $projNum = $_POST['projectnumber'];
    }
?>


<!DOCTYPE html>

<html>
    <head>
        <title>Results</title>
    </head>
    <body>
        <form action="" method="post">
            <select name="projectnumber">
                <?php
                $db = mysql_connect("james.cedarville.edu", "cs4220", "");
                mysql_select_db("cs4220");
                $query1 = "Select * from rjpc_project;";
                $result1 = mysql_query($query1) or die("Project Query Fail");
                for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                    $project = mysql_fetch_assoc($result1);
                    if ($project["Opened"] == 1 || $project["Closed"] == 1) {
                        echo "<option value=$i>Project $i</option>";
                    }
                }
                ?>
            </select>
            <input type="submit" name="submit" value="Go"/>
        </form>
        <div>
            <?php
            echo "$projNum";
            ?>
        </div>
    </body>
</html>
