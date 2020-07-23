<?php 

require('Settings.php');

mysql_connect($db_server, $db_user, $db_pass)or die(mysql_error());
mysql_select_db($db_name)or die(mysql_error());

?>