<?php

session_start();

require "../includes/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["first_name"] = $user["first_name"];
            $_SESSION["role"] = $user["role"];

            header("Location: ../dashboard.php");
            exit;

        } else {

            $error = "Incorrect password.";

        }

    } else {

        $error = "User not found.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SkillBarter</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include "../includes/navbar.php"; ?>

<section id="register">

    <div class="container">

        <div class="register-grid">

            <div class="register-left">

                <h2>Welcome<br>Back</h2>

                <p>
                    Log in to manage your SkillBarter account
                    and access your dashboard.
                </p>

            </div>


            <div class="register-form">

                <h3>Login</h3>

                <?php if (isset($error)) { ?>

                    <p style="color:red;">
                        <?php echo $error; ?>
                    </p>

                <?php } ?>

                <form method="POST">

                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            required>

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            required>

                    </div>


                    <button
                        type="submit"
                        class="form-submit">

                        LOGIN →

                    </button>

                </form>

            </div>

        </div>

    </div>

</section>

<?php include "../includes/footer.php"; ?>

</body>
</html>