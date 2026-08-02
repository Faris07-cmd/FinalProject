<?php

session_start();

require "../includes/database.php";

// Only logged-in providers can access this page
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] != "provider") {
    header("Location: ../dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Skill - SkillBarter</title>

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<?php include "../includes/navbar.php"; ?>

<section id="register">

    <div class="container">

        <div class="register-grid">

            <div class="register-left">

                <h2>
                    Add A<br>
                    New Skill
                </h2>

                <p>
                    Share something you can do and let others
                    discover your skill on SkillBarter.
                </p>

            </div>


            <div class="register-form">

                <h3>Create Skill</h3>

                <form action="save-skill.php" method="POST">

                    <div class="form-group">

                        <label for="title">
                            Skill Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="e.g. Football Coach"
                            required>

                    </div>


                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Describe what you can offer..."
                            required></textarea>

                    </div>


                    <button
                        type="submit"
                        class="form-submit">

                        CREATE SKILL →

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?php include "../includes/footer.php"; ?>

</body>
</html>