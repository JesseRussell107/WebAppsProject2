<?php
session_start();
//if a new session
if (!isset($_SESSION["isLoggedIn"])) {
    $_SESSION["isLoggedIn"] = false;
    $_SESSION["userName"] = "";
}
include "./sanitizeInput.php";
$logError = "";
//handles POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //what button did they press?
    if ($_POST["log"] === "Log in") {
        $username = sanitize_input($_POST["username"]);
        $password = sanitize_input($_POST["password"]);
        $logResult = verify_user($username, $password);
        //need to reset password
        if ($logResult === true && $password === "password") {
            header("location:./resetPassword.php");
            exit();
        }
        //bad login
        else if ($logResult === false) {
            $logError = "<p class='error'>Incorrect password</p>";
        } else { //successfully logged in and we don't need to reset the password
            $_SESSION["isLoggedIn"] = true;
        }
    } else if ($_POST["log"] === "Log out") {
        $_SESSION["isLoggedIn"] = false;
        $_SESSION["userName"] = "";
    } else {
        die("Error: Neither wanting to log in or log out");
    }
}

/**
 * Queries the database to verify the login information
 * @param type $usr
 * @param type $pass
 * @return boolean true if the password matches the user
 */
function verify_user($usr, $pass) {
    //connect to database
    include "tools/dbConnect.php";
    //find the user's password
    $query = "SELECT Username,Password FROM rjpc_user WHERE User_ID='$usr';";
    $result = mysql_query($query) or die("Error: unsuccessful query");
    $row = mysql_fetch_array($result);
    $hashPass = $row["Password"];
    mysql_close($db);
    //verify the passwords are the same
    $succeed = password_verify($pass, $hashPass);
    if ($succeed === true) {
        //log them in
        $_SESSION["userName"] = $usr;
        return true;
    } else {
        //we came in logged out, so stay logged out
        return false;
    }
}
?>
<nav>
    <h1>People's Choice Awards</h1>
    <div class='dropdown'>
        <button onclick='dropdown()' class='dropbtn'>
            <?php
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
            <form id="logForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php
                if ($_SESSION["isLoggedIn"] === true) {
                    ?>
                    <input class="button" type="submit" name="log" value="Log out"/>
                    <?php
                } else {
                    ?>
                    <label for="username">Name</label>
                    <select id="username" name="username" required="required">
                        <option value="">Select one</option>
                        <?php
                        include "./tools/dbConnect.php";
                        $query = "SELECT User_ID,Real_Name FROM rjpc_user order by Real_Name";
                        $result = mysql_query($query) or die("Error: unsuccessful query");
                        for ($rowNum = 0; $rowNum < mysql_num_rows($result); $rowNum++) {
                            $row = mysql_fetch_array($result);
                            print("<option value='" . $row['User_ID'] . "'>" . $row['Real_Name'] . "</option>");
                        }
                        mysql_close($db);
                        ?>
                    </select>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="password" autocomplete="off" required="required"/>
                    <input class="button" type="submit" name="log" value="Log in"/>
                    <?php
                }
                print($logError);
                ?>
            </form>
            <a href='http://judah.cedarville.edu/peopleschoice/index.php'>Old PCA</a>
        </div>
    </div>
</nav>

<?php
/*
 * adminPassword
 * test
 * howdy
 * TODO:
 * Admin control panel
 * Log in
 * Log out
 * Change password on password
 * Custom backgrounds
 * Use MySQLi
 */
// put your code here

/**
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */
/*
  $timeTarget = 0.05; // 50 milliseconds

  $cost = 8;
  do {
  $cost++;
  $start = microtime(true);
  password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
  $end = microtime(true);
  } while (($end - $start) < $timeTarget);

  print("Appropriate Cost Found: " . $cost . "\n");

  $options = [
  'cost' => 10,
  ];
  $pass = password_hash("test", PASSWORD_DEFAULT, $options);
  print($pass . "\n");
  $succeed = password_verify("test", $pass);
  if ($succeed == true) {
  print("Hooray, it matched!");
  } else {
  print("It failed...");
  }
 */
?>
