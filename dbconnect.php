<?php

session_start();
$DB_HOST = 'gymappdatabase.mysql.database.azure.com';
$DB_USER = 'gymappadmin';
$DB_PASS = 'gymapppassword1!';
$DB_NAME = 'gymapp';

$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ( mysqli_connect_errno() ) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());

}