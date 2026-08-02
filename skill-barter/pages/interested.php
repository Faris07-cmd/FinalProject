<?php

session_start();

require "../includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] != "provider") {
    header("Location: ../dashboard.php");
    exit;
}

$provider_id = $_SESSION["user_id"];

if (!isset($_GET["id"])) {
    header("Location: requests.php");
    exit;
}

$request_id = $_GET["id"];

$check = mysqli_query(
    $conn,
    "SELECT id
     FROM interests
     WHERE request_id = $request_id
     AND provider_id = $provider_id"
);

if (mysqli_num_rows($check) == 0) {

    $sql = "INSERT INTO interests
            (request_id, provider_id)
            VALUES
            ($request_id, $provider_id)";

    mysqli_query($conn, $sql);
}

header("Location: requests.php");

exit;