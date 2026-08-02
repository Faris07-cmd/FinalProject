<?php

session_start();

require "includes/database.php";

// Count registered users
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$row = mysqli_fetch_assoc($result);
$totalUsers = $row["total"];

// Search skills
if (isset($_GET["search"]) && $_GET["search"] != "") {

    $search = $_GET["search"];

    $skills = mysqli_query(
        $conn,
        "SELECT
            skills.*,
            users.first_name,
            users.last_name
         FROM skills
         JOIN users
         ON skills.user_id = users.id
         WHERE
            skills.title LIKE '%$search%'
            OR skills.description LIKE '%$search%'
            OR users.first_name LIKE '%$search%'
            OR users.last_name LIKE '%$search%'
         ORDER BY skills.created_at DESC"
    );

} else {

    $skills = mysqli_query(
        $conn,
        "SELECT
            skills.*,
            users.first_name,
            users.last_name
         FROM skills
         JOIN users
         ON skills.user_id = users.id
         ORDER BY skills.created_at DESC"
    );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Skill Barter</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/style.css">
  <script src="assets/js/app.js" defer></script>
  
</head>
<body>
  <?php if(isset($_GET['success'])): ?>
    <div class="success-box" style="background:#22c55e;color:white;padding:15px;text-align:center;font-weight:bold;">
        Account created successfully!
    </div>
  <?php endif; ?>

<?php include "includes/navbar.php"; ?>


<!-- ── HERO ── -->
<section id="hero">
  <div class="container">
    <div class="hero-grid">
      <div>
        <span class="hero-eyebrow">No Money Needed · Just Skills</span>
        <h1 class="hero-title">
          HOW CAN<br>
          WE HELP<br>
          <span>WITH?</span>
        </h1>
        <p class="hero-desc">
          A platform that connects people with needs to people with skills.
          Exchange services, build experience, and support each other — no money required.
        </p>
        <div class="hero-cta">
          <?php if (isset($_SESSION["user_id"])) { ?>

              <a
                  href="dashboard.php"
                  class="btn btn-secondary">
                  Go to Dashboard
              </a>

          <?php } else { ?>

              <a
                  href="#register"
                  class="btn btn-secondary">
                  Offer a Skill
              </a>

          <?php } ?>
        </div>
      </div>

      <!-- CSS Robot Illustration -->
      <div class="hero-illustration">
        <div class="robot">
          <div class="robot-head">
            <div class="robot-eyes">
              <div class="robot-eye" style="width:18px;height:18px;border-radius:4px;"></div>
              <div class="robot-eye" style="width:18px;height:18px;border-radius:4px;"></div>
            </div>
            <div class="robot-mouth"></div>
          </div>
          <div class="robot-body" style="width:60px;height:52px;">
            <div class="robot-arm left"></div>
            <div class="robot-arm right">
              <div class="robot-book"></div>
            </div>
          </div>
          <div class="robot-legs">
            <div class="robot-leg"></div>
            <div class="robot-leg"></div>
          </div>
        </div>
        <div class="robot" style="animation-delay:-1.5s; margin-bottom:20px;">
          <div class="robot-head" style="width:54px;height:54px;border-radius:14px;">
            <div class="robot-eyes">
              <div class="robot-eye"></div>
              <div class="robot-eye"></div>
            </div>
            <div class="robot-mouth" style="width:20px;"></div>
          </div>
          <div class="robot-body" style="width:46px;height:42px;">
            <div class="robot-arm left"></div>
            <div class="robot-arm right"></div>
          </div>
          <div class="robot-legs">
            <div class="robot-leg"></div>
            <div class="robot-leg"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── STATS STRIP ── -->
<div class="stats-strip">
  <div class="container">
    <div class="stats-inner">
      <div class="stat-item">
        <div class="stat-num">500+</div>
        <div class="stat-label">Skills Listed</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">1.2k</div>
        <div class="stat-label">Exchanges Done</div>
      </div>
      <div class="stat-item">
        <div class="stat-num"><?php echo $totalUsers; ?></div>
        <div class="stat-label">Active Members</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">4.8★</div>
        <div class="stat-label">Avg. Rating</div>
      </div>
    </div>
  </div>
</div>

<!-- ── SEARCH & BROWSE ── -->
<section id="search">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">// Browse Skills</div>
      <h2 class="section-title">Search What You Need</h2>
      <p class="section-sub">Find someone with the skill you need, or list what you can offer to others.</p>
    </div>

    <form class="search-bar" method="GET" action="index.php">

      <input
        type="text"
        name="search"
        placeholder="e.g. Phone Repair, Web Design, Tutoring..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

        <button type="submit">SEARCH</button>

    </form>

 <!-- skill cards  -->
<div class="skill-cards">

    <?php if (mysqli_num_rows($skills) > 0) { ?>

        <?php while ($skill = mysqli_fetch_assoc($skills)) { ?>

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
                        <strong>By:</strong>
                        <?php
                        echo $skill["first_name"] . " " . $skill["last_name"];
                        ?>
                    </li>

                </ul>

                <a
                    href="pages/skill.php?id=<?php echo $skill["id"]; ?>"
                    class="btn btn-primary">

                    VIEW DETAILS

                </a>

            </div>

        <?php } ?>

    <?php } else { ?>

        <div class="skill-card">

            <div class="skill-card-icon">
                🔍
            </div>

            <h3>No Skills Found</h3>

            <p>
                We couldn't find a skill matching your search.
            </p>

        </div>

    <?php } ?>

</div>
</section>

<!-- ── HOW IT WORKS ── -->
<section id="how">
  <div class="container">
    <div class="section-header">
      <div class="section-tag">// The Process</div>
      <h2 class="section-title">How It Works</h2>
      <p class="section-sub">From sign-up to exchange — a simple 4-step process designed for everyone.</p>
    </div>

    <div class="steps-grid">
      <div class="step-card">
        <div class="step-icon">👤</div>
        <div class="step-num">01</div>
        <h3>Register & Profile</h3>
        <p>Sign up with your name, phone, and email. List your skills and what you need.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">📋</div>
        <div class="step-num">02</div>
        <h3>List or Request</h3>
        <p>Post what skill you can offer or submit a request for a service you need.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">🔍</div>
        <div class="step-num">03</div>
        <h3>Discover & Match</h3>
        <p>The platform matches you automatically based on skills, needs, and location.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">💬</div>
        <div class="step-num">04</div>
        <h3>Communicate & Agree</h3>
        <p>Use built-in messaging to discuss the exchange and schedule the service.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">✅</div>
        <div class="step-num">05</div>
        <h3>Complete Exchange</h3>
        <p>The provider delivers the service and both parties confirm completion.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">⭐</div>
        <div class="step-num">06</div>
        <h3>Rate & Review</h3>
        <p>Both users rate each other. Good ratings build your trusted reputation.</p>
      </div>
      <div class="step-card">
        <div class="step-icon">🏆</div>
        <div class="step-num">07</div>
        <h3>Build Portfolio</h3>
        <p>Completed exchanges build your digital work history and experience certificate.</p>
      </div>
      <div class="step-card" style="opacity:0.3; pointer-events:none;">
        <div class="step-num" style="font-size:14px; opacity:1; color:rgba(255,255,255,0.2); margin-bottom:0;">MORE<br>COMING</div>
      </div>
    </div>
  </div>
</section>

<!-- ── REGISTER ── -->
 <form action="pages/register.php" method="POST">
  <?php if (!isset($_SESSION["user_id"])) { ?>
   <section id="register">
     <div class="container">
       <div class="register-grid">
         <div class="register-left">
           <h2>Join Skill<br>Barter Today</h2>
           <p>
             Whether you have a skill to share or a need to fill — everyone has
             something to offer. Sign up and start making meaningful exchanges
             in your community.
           </p>
           <br>
           <p style="font-family:'Space Mono',monospace; font-size:12px; opacity:0.7;">
             ✓ Free to join &nbsp;&nbsp; ✓ No money needed<br>
             ✓ Build experience &nbsp;&nbsp; ✓ Earn certificates
           </p>
         </div>
   
         <div class="register-form">
           <h3>Create Your Account</h3>
   
            <div style="margin-bottom:20px;">
              <div class="form-group">
                  <label>Why are you here?</label>
              </div>

              <div class="role-select">

                  <input
                      type="radio"
                      name="role"
                      id="role-seek"
                      value="seeker"
                      class="role-option"
                      checked>

                  <label for="role-seek" class="role-label">
                      Seek Help
                  </label>


                  <input
                      type="radio"
                      name="role"
                      id="role-offer"
                      value="provider"
                      class="role-option">

                  <label for="role-offer" class="role-label">
                      Offer Skill
                  </label>

              </div>
            </div>
   
           <div class="form-row">
             <div class="form-group">
               <label for="fname">First Name</label>
               <input type="text" id="fname" name="first_name" placeholder="Natan" required/>
             </div>
             <div class="form-group">
               <label for="lname">Last Name</label>
               <input type="text" id="lname" name ="last_name" placeholder="Tewodros" required/>
             </div>
           </div>
   
           <div class="form-group">
             <label for="phone">Phone Number</label>
             <input type="tel" id="phone" name ="phone" placeholder="+251 9XX XXX XXX" required/>
           </div>
   
           <div class="form-group">
             <label for="email">Email Address</label>
             <input type="email" id="email" name ="email" placeholder="you@example.com" />
           </div>

           <div class="form-group">
             <label for="password">Password</label>
             <input type="password" id="password" name ="password" />
           </div>
   
           <button class="form-submit" type="submit">CREATE ACCOUNT →</button>
         </div>
       </div>
     </div>
   </section>
   <?php } ?>
 </form>

<?php include "includes/footer.php"; ?>


</body>
</html>
