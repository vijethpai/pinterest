<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "pinterest";

@mysql_connect ("$db_host","$db_username","$db_pass") or die ("Could not connect to MySQL");
@mysql_select_db("$db_name") or die ("No Database");

?>