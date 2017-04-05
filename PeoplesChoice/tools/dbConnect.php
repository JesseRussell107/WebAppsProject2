<?php
//connects to database
//NOTE: for testing, connected to local database
$db = mysql_connect("localhost", "root", "") or die("Error: unable to connect to database");
mysql_select_db("test") or die("Error: unable to open test table");
?>