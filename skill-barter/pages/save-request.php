<?php

session_start();

require "../includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] != "seeker") {
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$title = $_POST["title"];
$description = $_POST["description"];

$sql = "INSERT INTO requests
(user_id, title, description)
VALUES
('$user_id', '$title', '$description')";

if (mysqli_query($conn, $sql)) {

    header("Location: ../dashboard.php?success=request_created");
    exit;

} else {

    echo "Error: " . mysqli_error($conn);

}

mysqli_close($conn);