<?php
//env vars
$HOST = getenv('PHP_DB_HOST', true);
$USER = getenv('PHP_DB_USER', true);
$PASSWORD = getenv('PHP_DB_PASSWORD', true);
$DB = getenv('PHP_DB_DB', true);

//connect to DB
$conn = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
if(!$conn){
    echo "connection error: " . mysqli_connect_error();
}
?>

