<?php

session_start();

require "../includes/database.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST["id"])) {
    die("Skill ID is missing.");
}

$id = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["description"];

$user_id = $_SESSION["user_id"];

$check = mysqli_query(
    $conn,
    "SELECT * FROM skills
     WHERE id = $id
     AND user_id = $user_id"
);

if (mysqli_num_rows($check) != 1) {
    die("You are not allowed to update this skill.");
}

$sql = "UPDATE skills SET
        title = '$title',
        description = '$description'
        WHERE id = $id
        AND user_id = $user_id";

if (mysqli_query($conn, $sql)) {

    header("Location: ../dashboard.php?success=skill_updated");
    exit;

} else {

    echo "Error: " . mysqli_error($conn);

}

mysqli_close($conn);