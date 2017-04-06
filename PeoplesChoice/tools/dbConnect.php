<?php
//connects to database
//NOTE: for testing, connected to local database
$db = mysql_connect("james.cedarville.edu", "cs4220", "") or die("Error: unable to connect to database");
mysql_select_db("cs4220") or die("Error: unable to open test table");
?>