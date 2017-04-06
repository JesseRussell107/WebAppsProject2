<nav>
    <h1>People's Choice Awards</h1>
    <button id="headerName">
        <?php
        include "tools/dbConnect.php";
        //show the user's real name if they are logged in or they are resetting their password
        if ($_SESSION["isLoggedIn"] === true || isSet($_SESSION["userName"])) {
            //find the user's real name
            $query = "SELECT Real_Name FROM rjpc_user WHERE User_ID='" . $_SESSION['userName'] . "';";
            $result = mysql_query($query) or die("Error: unsuccessful query");
            $row = mysql_fetch_array($result);
            print($row["Real_Name"]);
        } else {
            print("Guest");
        }
        mysql_close($db);
        ?>
    </button>
</nav>

