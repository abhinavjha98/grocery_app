<?php

/*******************************
 * 
 *  Developer : Ajay randhawa
 *  Email : ajayrandhawartg@gmail.com
 *  
 *  Please don't share this script on nulled websites 
 *  Buy from Envato & appreciate Developer
 * 
 * ******************************/


// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','grocery');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
