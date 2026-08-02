<?php

session_start();

require "../includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];

$user_id = $_SESSION["user_id"];

$sql = "DELETE FROM skills
        WHERE id = $id
        AND user_id = $user_id";

if (mysqli_query($conn, $sql)) {

    header("Location: ../dashboard.php?success=skill_deleted");
    exit;

} else {

    echo "Error: " . mysqli_error($conn);

}

mysqli_close($conn);