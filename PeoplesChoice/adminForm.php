<?php

session_start();
include "./head.php";
//not admin, then cannot access
if ($_SESSION["userName"] != 1) {
    header("location:./PeoplesChoice.php");
    exit();
}
//Post
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //manage projects
    if (isset($_POST["openNew"])) {
        $projNum = $_POST["openNew"];
        include "./TeamSubmit.php";
    }
}
include "./header.php";
include "./tools/dbConnect.php";
?>
