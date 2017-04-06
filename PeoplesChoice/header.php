<nav>
    <h1>People's Choice Awards</h1>
    <div class='dropdown'>
        <button onclick='dropdown()' class='dropbtn'>
            <?php
            //only start a session if none exists (lots of interlocking files)
            if(session_status()==PHP_SESSION_NONE) {
                session_start();
            }
            include "tools/dbConnect.php";
            if ($_SESSION["isLoggedIn"] === true) {
                //find the user's real name
                $query = "SELECT Real_Name FROM rjpc_user WHERE User_ID='" . $_SESSION['userName'] . "';";
                $result = mysql_query($query) or die("Error: unsuccessful query");
                $row = mysql_fetch_array($result);
                print($row["Real_Name"]);
            } else {
                print("Guest");
            }
            ?>
        </button>

        <div id='myDropdown' class='dropdown-content'>
            <a href="./PeoplesChoice.php">Homepage</a>
            <a href='http://judah.cedarville.edu/peopleschoice/index.php'>Old PCA</a>
        </div>
        <?php
        mysql_close($db);
        ?>
</nav>