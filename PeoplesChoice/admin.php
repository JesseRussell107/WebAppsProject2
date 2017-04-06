<?php
session_start();
include "./head.php";
//not admin, then cannot access
if ($_SESSION["userName"] != 1) {
    header("location:./PeoplesChoice.php");
    exit();
}
include "./header.php";
include "./tools/dbConnect.php";
?>
<div id="content">
    <!--manage projects-->
    <div class="section">
        <h2>Manage Projects</h2>
        <?php
        //open new projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 0 and Closed = 0;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminForm.php"); ?>">
                <label for="openNew">Open Projects:</label>
                <select name="openNew" id="openNew" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 0 and Closed = 0 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=".$project['Project_ID'].">Project ".$project['Project_ID']."</option>";
                    }
                    ?>
                </select>
                <input class="button" id="openNewButton" type="submit" value="Open"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to open for the first time</p>");
        }
        
        //close open projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 1;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminForm.php"); ?>">
                <label for="close">Close Projects:</label>
                <select name="close" id="close" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 1 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=".$project['Project_ID'].">Project ".$project['Project_ID']."</option>";
                    }
                    ?>
                </select>
                <input class="button" id="closeButton" type="submit" value="Close"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to close</p>");
        }
        
        //re-open projects
        $countquery = "Select count(Project_ID) from rjpc_project where Open = 0 and Closed = 1;";
        $countresult = mysql_query($countquery);
        $countrow = mysql_fetch_assoc($countresult);
        if (intval($countrow["count(Project_ID)"]) > 0) {
            ?>
            <form method="POST" action="<?php echo htmlspecialchars("./adminForm.php"); ?>">
                <label for="reopen">Re-open Projects:</label>
                <select name="reopen" id="reopen" required="">
                    <option value="">Select one</option>
                    <?php
                    $query1 = "Select * from rjpc_project where Open = 0 and Closed = 1 order by Project_ID;";
                    $result1 = mysql_query($query1) or die("Project Query Fail");
                    for ($i = 1; $i <= mysql_num_rows($result1); $i++) {
                        $project = mysql_fetch_assoc($result1);
                        echo "<option value=".$project['Project_ID'].">Project ".$project['Project_ID']."</option>";
                    }
                    ?>
                </select>
                <input class="button" id="reopenButton" type="submit" value="Re-Open"/>
            </form>
            <?php
        } else {
            print("<p>There are no projects to re-open</p>");
        }
        ?>
    </div>
    <!--modify users-->
    <div class="section"></div>
    <!--add users-->
    <div class="section"></div>
    <!--new class-->
    <div class="section"></div>
</div>
<?php
include "./footer.php";
mysql_close($db);
?>