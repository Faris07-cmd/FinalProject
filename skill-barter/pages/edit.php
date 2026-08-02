<?php

session_start();

require "../includes/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    die("Skill ID is missing.");
}

$id = $_GET["id"];

$result = mysqli_query(
    $conn,
    "SELECT * FROM skills WHERE id = $id"
);

if (mysqli_num_rows($result) != 1) {
    echo "Skill not found.";
    exit;
}

$skill = mysqli_fetch_assoc($result);

if ($skill["user_id"] != $_SESSION["user_id"]) {
    echo "You are not allowed to edit this skill.";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Skill</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "../includes/navbar.php"; ?>

<section id="register">
    <div class="container">

        <div class="register-grid">

            <div class="register-left">

                <h2>Edit Your<br>Skill</h2>

                <p>
                    Update your personal information or the skill you offer.
                    Once you save, the changes will immediately appear on the homepage.
                </p>

            </div>

            <div class="register-form">

                <h3>Edit Skill</h3>

                <form action="update.php" method="POST">

                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $id; ?>"
                    >

                    <div class="form-group">

                        <label for="title">
                            Skill Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?php echo $skill["title"]; ?>"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            required
                        ><?php echo $skill["description"]; ?></textarea>

                    </div>


                    <button
                        type="submit"
                        class="form-submit">

                        UPDATE SKILL →

                    </button>

                </form>

            </div>

        </div>

    </div>
</section>

<?php include "../includes/footer.php"; ?>

</body>
</html>