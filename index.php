<?php
  include "inc_head.php";
  include "select.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Review</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header>
      <div class="nav-left">T3</div>
      <div class="nav-right">
        <?php if (isset($_SESSION['user_name'])): ?>

          <span>Welcome, <?= $_SESSION['user_name'] ?></span>
          <button onclick="location.href='logout.php'">LOG OUT</button>
        <?php else: ?>

          <button onclick="location.href='login.php'">LOG IN</button>
          <button onclick="location.href='signup.php'">SIGN UP</button>
        <?php endif; ?>
      </div>
    </header>
    <main>
      <h1>Movie Review</h1>
      <p>Welcome!</p>
      <div class="buttons">
        <a href="login.php">login</a>
        <a href="signup.php">sign up</a>
      </div>
    </main>
  </body>
</html>
