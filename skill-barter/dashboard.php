<?php

session_start();

require "includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: pages/login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$role = $_SESSION["role"];
$first_name = $_SESSION["first_name"];

$mySkills = null;
if ($role == "provider") {

    $mySkills = mysqli_query(
        $conn,
        "SELECT *
         FROM skills
         WHERE user_id = $user_id
         ORDER BY created_at DESC"
    );
}

$myRequests = null;
if ($role == "seeker") {

    $myRequests = mysqli_query(
        $conn,
        "SELECT *
         FROM requests
         WHERE user_id = $user_id
         ORDER BY created_at DESC"
    );
}

?>
<?php

$message = "";

if (isset($_GET["success"])) {

    switch ($_GET["success"]) {

        case "skill_created":
            $message = "Skill created successfully!";
            break;

        case "skill_updated":
            $message = "Skill updated successfully!";
            break;

        case "skill_deleted":
            $message = "Skill deleted successfully!";
            break;

        case "request_created":
            $message = "Request created successfully!";
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - SkillBarter</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
          href="assets/css/style.css">

    <script src="assets/js/app.js" defer></script>

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section id="register">

    <div class="container">

        <!-- Dashboard header -->
<div class="register-grid">

    <div class="register-left">

        <h2>
            Welcome<br>
            <?php echo $first_name; ?>
        </h2>

        <?php if ($role == "provider") { ?>

            <p>
                You are registered as a
                <strong>Skill Provider</strong>.
            </p>

            <p>
                Share your skills with people who need
                them and manage your offers from here.
            </p>

        <?php } else { ?>

            <p>
                You are registered as a
                <strong>Skill Seeker</strong>.
            </p>

            <p>
                Create requests when you need help,
                or browse the skills offered by others.
            </p>

        <?php } ?>

    </div>


    <div class="register-form">

        <?php if ($role == "provider") { ?>

            <h3>Your Dashboard</h3>

            <a
                href="pages/add-skill.php"
                class="btn btn-primary">
                + ADD NEW SKILL
            </a>

            <br><br>

            <a
                href="pages/requests.php"
                class="btn btn-secondary">
                BROWSE REQUESTS →
            </a>

        <?php } else { ?>

            <h3>Your Dashboard</h3>

            <a
                href="pages/add-request.php"
                class="btn btn-primary">
                + CREATE REQUEST
            </a>

            <br><br>

            <a
                href="index.php#search"
                class="btn btn-secondary">
                BROWSE SKILLS →
            </a>

        <?php } ?>

    </div>

</div>


<?php if ($role == "provider") { ?>

    <!-- PROVIDER SKILLS -->

    <div class="dashboard-skills">

        <div class="section-header">
            <div class="section-tag">// Your Skills</div>
            <h2 class="section-title">My Skills</h2>
        </div>

        <div class="dashboard-cards">

            <?php if (mysqli_num_rows($mySkills) > 0) { ?>

                <?php while ($skill = mysqli_fetch_assoc($mySkills)) { ?>

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

                        <div class="skill-actions">

                            <a
                                href="pages/skill.php?id=<?php echo $skill["id"]; ?>"
                                class="btn btn-primary">
                                VIEW
                            </a>

                            <a
                                href="pages/edit.php?id=<?php echo $skill["id"]; ?>"
                                class="btn btn-secondary">
                                EDIT
                            </a>

                            <a
                                href="pages/delete.php?id=<?php echo $skill["id"]; ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Delete this skill?');">
                                DELETE
                            </a>

                        </div>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="skill-card">

                    <div class="skill-card-icon">
                        📭
                    </div>

                    <h3>No Skills Yet</h3>

                    <p>
                        You haven't added any skills yet.
                    </p>

                    <a
                        href="pages/add-skill.php"
                        class="btn btn-primary">
                        ADD YOUR FIRST SKILL
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>


<?php } else { ?>

    <!-- SEEKER REQUESTS -->

    <div class="dashboard-skills">

        <div class="section-header">
            <div class="section-tag">// Your Requests</div>
            <h2 class="section-title">My Requests</h2>
        </div>

        <div class="dashboard-cards">

            <?php if (mysqli_num_rows($myRequests) > 0) { ?>

                <?php while ($request = mysqli_fetch_assoc($myRequests)) { ?>

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


                        <?php

                        $request_id = $request["id"];

                        $interested = mysqli_query(
                            $conn,
                            "SELECT
                                users.first_name,
                                users.last_name,
                                users.phone,
                                users.email
                             FROM interests
                             JOIN users
                             ON interests.provider_id = users.id
                             WHERE interests.request_id = $request_id
                             ORDER BY interests.created_at DESC"
                        );

                        ?>


                        <h4 style="margin-top: 25px;">
                            Interested Providers
                        </h4>


                        <?php if (mysqli_num_rows($interested) > 0) { ?>

                            <?php while ($provider = mysqli_fetch_assoc($interested)) { ?>

                                <div style="
                                    border-top: 1px solid rgba(0,0,0,0.1);
                                    padding-top: 15px;
                                    margin-top: 15px;
                                ">

                                    <p>
                                        <strong>
                                            <?php
                                            echo $provider["first_name"]
                                                . " "
                                                . $provider["last_name"];
                                            ?>
                                        </strong>
                                    </p>

                                    <p>
                                        📞 <?php echo $provider["phone"]; ?>
                                    </p>

                                    <p>
                                        ✉ <?php echo $provider["email"]; ?>
                                    </p>

                                </div>

                            <?php } ?>

                        <?php } else { ?>

                            <p style="opacity: 0.6;">
                                No providers are interested yet.
                            </p>

                        <?php } ?>

                    </div>

                <?php } ?>

            <?php } else { ?>

                <div class="skill-card">

                    <div class="skill-card-icon">
                        📭
                    </div>

                    <h3>No Requests Yet</h3>

                    <p>
                        You haven't created any requests yet.
                    </p>

                    <a
                        href="pages/add-request.php"
                        class="btn btn-primary">
                        CREATE YOUR FIRST REQUEST
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>

<?php } ?>

</body>

</html>