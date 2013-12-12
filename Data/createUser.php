#!/usr/bin/env php  
<?php

/**
 * Script creates a carnasso user (administrator).
 * 
 * The Password stored in the database, is the hashed 
 * concatenation of the clearpassword and a salt value.
 * The DB connection parameters are retrieved from the ZF2
 * configuration: ../config/autoload/local.php
 * 
 * @author: Marco Aeberli
 */

if( count($argv) != 3)
{
    echo "Creates a carnasso administrator user.\n";
    echo "Usage: $argv[0] username password\n\n";
    return -2; 
}

$username = $argv[1];
$password = $argv[2];

chdir(__DIR__);

// load DB connection informations
$db = require '../config/autoload/local.php';

// create salt value and hash the password with sha256
$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));

$saltedPassword =  $password . $salt;

$hashedPassword = hash('sha256', $saltedPassword);

// prepare the php insert query
$insertQuery = "INSERT INTO User (usr_name, usr_password, usr_password_salt) VALUES('$username', '$hashedPassword', '$salt')";


// DB connection and query execution
$link = mysql_connect($db['db']['host'].":".$db['db']['port'], $db['db']['user'], $db['db']['password']);
if (!$link) {
    die('DB Connection error: '.mysql_error());
}

$dbname = $db['db']['dbname'];
$db_selected = mysql_select_db($dbname, $link);
if (!$db_selected) {
    die ('Unable to select database $dbname : ' . mysql_error());
}

$result = mysql_query($insertQuery, $link);
if (!$result) {
    die('Error during insertion: ' . mysql_error());
}

mysql_close($link);
