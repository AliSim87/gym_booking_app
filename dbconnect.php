<?php

session_start();
$DB_HOST = 'sql309.epizy.com';
$DB_USER = 'epiz_25235579';
$DB_PASS = 'xaY6JAuPdkv2M';
$DB_NAME = 'epiz_25235579_gymapp';

$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ( mysqli_connect_errno() ) {
    die ('Failed to connect to MySQL: ' . mysqli_connect_error());

}