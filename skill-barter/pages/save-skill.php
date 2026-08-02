<?php

session_start();

require "../includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] != "provider") {
    header("Location: ../dashboard.php?success=skill_created");
    exit;
}

$user_id = $_SESSION["user_id"];

$title = $_POST["title"];
$description = $_POST["description"];

$sql = "INSERT INTO skills
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