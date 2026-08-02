<?php

session_start();

require "../includes/database.php";

if (!isset($_GET["id"])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET["id"];

$sql = "SELECT
            skills.*,
            users.first_name,
            users.last_name,
            users.phone,
            users.email
        FROM skills
        JOIN users
        ON skills.user_id = users.id
        WHERE skills.id = $id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) != 1) {
    echo "Skill not found.";
    exit;
}

$skill = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $skill["title"]; ?> - SkillBarter
    </title>

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
                // Skill Details
            </div>

            <h2 class="section-title">
                <?php echo $skill["title"]; ?>
            </h2>

            <p class="section-sub">
                Skill offered by
                <?php
                echo $skill["first_name"] . " " . $skill["last_name"];
                ?>
            </p>

        </div>


        <div class="skill-cards">

            <div class="skill-card">

                <div class="skill-card-icon">
                    👤
                </div>

                <h3>
                    <?php echo $skill["title"]; ?>
                </h3>

                <p>
                    <?php echo $skill["description"]; ?>
                </p>


                <ul class="skill-list">

                    <li>
                        <strong>Provider:</strong>

                        <?php
                        echo $skill["first_name"] . " "
                           . $skill["last_name"];
                        ?>
                    </li>

                    <li>
                        <strong>Phone:</strong>

                        <?php
                        echo $skill["phone"];
                        ?>
                    </li>

                    <li>
                        <strong>Email:</strong>

                        <?php
                        echo $skill["email"];
                        ?>
                    </li>

                </ul>


                <br>


                <a
                    href="../index.php#search"
                    class="btn btn-secondary">

                    ← BACK TO SKILLS

                </a>

            </div>

        </div>

    </div>

</section>


<?php include "../includes/footer.php"; ?>

</body>

</html>