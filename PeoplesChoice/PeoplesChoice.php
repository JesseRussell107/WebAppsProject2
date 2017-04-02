<!DOCTYPE html>

<html>
    <head>
        <title>People's Choice Awards</title>
    </head>
    <body>
        <h2>People's Choice Awards</h2>
        <div>
            <?php
            $db = mysql_connect("james.cedarville.edu", "cs4220", "");
            mysql_select_db("cs4220");
            $query = "SELECT * from rjpc_user;";
            $result = mysql_query($query) or die("Waaaaaahh!");
            echo "<table>";
            while ($row = mysql_fetch_assoc($result)) {
                echo "<tr><td>";
                echo $row["Real_Name"];
                echo "<br></tr></td>";
            }
            ?>
        </div>
    </body>
</html>