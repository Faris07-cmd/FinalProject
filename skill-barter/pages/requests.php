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

$sql = "SELECT
            requests.id,
            requests.title,
            requests.description,
            requests.created_at,
            users.first_name,
            users.last_name
        FROM requests
        JOIN users
        ON requests.user_id = users.id
        ORDER BY requests.created_at DESC";

$requests = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Skill Requests - SkillBarter</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

<?php include "../includes/navbar.php"; ?>

<section id="search">

    <div class="container">

        <div class="section-header">

            <div class="section-tag">
                // Skill Requests
            </div>

            <h2 class="section-title">
                People Looking For Help
            </h2>

            <p class="section-sub">
                Find requests that match the skills you can offer.
            </p>

        </div>


        <div class="request-cards">

            <?php if (mysqli_num_rows($requests) > 0) { ?>

                <?php while ($request = mysqli_fetch_assoc($requests)) { ?>

                    <?php

                    $request_id = $request["id"];

                    $check = mysqli_query(
                        $conn,
                        "SELECT id FROM interests
                         WHERE request_id = $request_id
                         AND provider_id = $provider_id"
                    );

                    $alreadyInterested = mysqli_num_rows($check) > 0;

                    ?>

                    <div class="skill-card">

                        <div class="skill-card-icon">
                            📋
                        </div>

                        <h3>
                            <?php echo $request["title"]; ?>
                        </h3>

                        <p>
                            <?php echo $request["description"]; ?>
                        </p>

                        <ul class="skill-list">

                            <li>
                                <strong>Requested by:</strong>

                                <?php
                                echo $request["first_name"]
                                    . " "
                                    . $request["last_name"];
                                ?>
                            </li>

                        </ul>

                        <?php if ($alreadyInterested) { ?>

                            <p style="margin-top: 15px;">
                                ✅ You are interested
                            </p>

                        <?php } else { ?>

                            <a
                                href="interested.php?id=<?php echo $request["id"]; ?>"
                                class="btn btn-primary">

                                I'M INTERESTED

                            </a>

                        <?php } ?>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="skill-card">

                    <div class="skill-card-icon">
                        📭
                    </div>

                    <h3>
                        No Requests
                    </h3>

                    <p>
                        There are no skill requests available right now.
                    </p>

                </div>

            <?php } ?>

        </div>

    </div>

</section>

<?php include "../includes/footer.php"; ?>

</body>

</html>