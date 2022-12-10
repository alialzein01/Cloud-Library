<?php

$server = "localhost";
$conn_username = "root";
$conn_password = "";
$dbname = "cloud_lib";

$connection = mysqli_connect($server, $conn_username, $conn_password, $dbname) or die("Connection Failed");