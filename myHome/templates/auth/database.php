<?php
 
 $host = "localhost";
 $dbname = "myhomedb";
 $username = "root";
 $password = "FlavianLeonar2003$";

    // Create a new MySQLi instance
 $mysqli = new mysqli($host, $username, $password, $dbname);

    // Check connection
 if ($mysqli->connect_errno) {
     die("Connection failed: " . $mysqli->connect_error);
 }

 return $mysqli;