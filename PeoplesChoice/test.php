<!DOCTYPE html>
<!--
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test Login</title>
    </head>
    <body>
        <?php
        //form input
        $username = $password = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = test_input($_POST["username"]);
            $password = test_input($_POST["password"]);
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        
        function verify_user($usr, $pass) {
            
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Name</label>
            <select id="username" name="username" required="required">
                <!-- TODO: dynamically read in options from database -->
                <option value="">Select one</option>
                <option value="admin">Administrator</option>
                <option value="rwlively">Rich Lively</option>
                <option value="jrussell">Jesse Russell</option>
            </select>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="password" autocomplete="off" required="required"/>
            <input class="button" type="submit" value="Log in"/>
            <?php
            /*
             * TODO:
             * Admin control panel
             * Log in
             * Log out
             * Change password on password
             */
            // put your code here
            ?>
        </form>
    </body>
</html>
