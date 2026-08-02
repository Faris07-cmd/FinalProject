<?php

$host = "localhost";
$user = "root";
$password = "9<>h7=n!2jEf";
$database = "skill_barter";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}