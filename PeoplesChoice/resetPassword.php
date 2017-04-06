<?php
session_start();
include "./head.php";
include "./sanitizeInput.php";
$passErr = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["userName"];
    $password = sanitize_input($_POST["pwd"]);

    if ($password === "password") {
        $passErr = "<p class='error'>Can't use password \"password\"!</p>";
    } else {
        $options = [
            'cost' => 10,
        ];
        $newpass = password_hash($password, PASSWORD_DEFAULT, $options);

        include "./tools/dbConnect.php";
        $query = "UPDATE rjpc_user SET Password='" . $newpass . "' WHERE User_ID='" . $userID . "'";
        $result = mysql_query($query) or die("Error: unsuccessful query");
        mysql_close($db);

        //now that we set the new password, we are logged in
        $_SESSION["isLoggedIn"] = true;

        header("location:./PeoplesChoice.php");
        exit();
    }
}
?>
<?php include "./header.php" ?>
<div id="content">
    <div class="centerDiv" id="resetDiv">
        <p id="resetTitle">You need to reset your password</p>
        <?php print($passErr); ?>
        <form id="resetForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return confirmPass()">
            <label for="pass1">Password</label>
            <input id="pass1" name="pwd" type="password" placeholder="password" autocomplete="off" required="required"/>
            <label for="pass2">Confirm Password</label>
            <input id="pass2" name="cpwd" type="password" placeholder="password" autocomplete="off" required="required"/>
            <input class="button" type="submit" name="reset" />
        </form>
    </div>
</div>
<?php
include "./footer.php";
?>
