<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<nav>

    <div class="container">

        <a href="../index.php" class="nav-logo">
            Skill<span>Barter</span>
        </a>

        <div class="nav-links">

            <a href="../index.php#search">
                Browse
            </a>

            <a href="/index.php#how">
                How It Works
            </a>


           <?php if (isset($_SESSION["user_id"])) { ?>

                <a href="/dashboard.php">
                    <?php echo $_SESSION["first_name"]; ?>'s Dashboard
                </a>
            
                <a href="/pages/logout.php" class="nav-btn">
                    Logout
                </a>
            
            <?php } else { ?>
            
                <a href="/index.php#register">
                    Register
                </a>
            
                <a href="/pages/login.php" class="nav-btn">
                    Login
                </a>
            
            <?php } ?>

        </div>

    </div>

</nav>