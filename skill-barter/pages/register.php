<?php

require "../includes/database.php";

$role = $_POST["role"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = $_POST["password"];

$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users
(role, first_name, last_name, phone, email, password)
VALUES
('$role', '$first_name', '$last_name', '$phone', '$email', '$password')";

if (mysqli_query($conn, $sql)) {

    header("Location: ../index.php?success=1");
    exit;

} else {

    echo "Error: " . mysqli_error($conn);

}

mysqli_close($conn);