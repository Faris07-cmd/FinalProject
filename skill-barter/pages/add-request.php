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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Create Request - SkillBarter</title>

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

<section id="register">

    <div class="container">

        <div class="register-grid">

            <div class="register-left">

                <h2>
                    Request<br>
                    Help
                </h2>

                <p>
                    Tell the community what kind of help
                    you need. Someone with the right skill
                    may be able to help you.
                </p>

            </div>


            <div class="register-form">

                <h3>Create Request</h3>

                <form action="save-request.php" method="POST">

                    <div class="form-group">

                        <label for="title">
                            What do you need?
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="e.g. Laptop Repair"
                            required>

                    </div>


                    <div class="form-group">

                        <label for="description">
                            Describe what you need
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Explain what kind of help you need..."
                            required></textarea>

                    </div>


                    <button
                        type="submit"
                        class="form-submit">

                        CREATE REQUEST →

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?php include "../includes/footer.php"; ?>

</body>

</html>