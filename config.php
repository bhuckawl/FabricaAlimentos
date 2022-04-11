<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'sql102.epizy.com');
define('DB_USERNAME', 'epiz_31473600');
define('DB_PASSWORD', 'mD3daGkw6NNWIM');
define('DB_NAME', 'epiz_31473600_fabricaalimentos');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>