<?php
  include "select.php";
  include "inc_head.php";

  //리뷰 목록 조회
  $sql = "SELECT *,
    DATE_FORMAT(created_at, '%Y-%m-%d') as formatted_date FROM reviews 
    ORDER BY created_at DESC";

  $result = $db_conn->query($sql);
  ?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Review List</title>
    <link rel="stylesheet" href="review_style.css">
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    <header>
      <div class="nav-left">T3</div>
        <div class="nav-right">
          <span>Welcome, <?= $_SESSION['user_name'] ?></span>
          <button onclick="location.href='logout.php'">LOG OUT</button>
          <button onclick="location.href='create.php'">리뷰 작성</button>

        </div>
    </header>
    <main>
      <h1>Movie Review List</h1>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($review = $result->fetch_assoc()): ?>
          <div class="review-item">
            <a href="review_detail.php?id=<?php echo $review['id']; ?>" class="review-title">
              <?php echo htmlspecialchars($review['title']); ?>
            </a>
            <div class="review-info">
              <span> </span>
              <span>|</span>
              <span><?php echo htmlspecialchars($review['movie']); ?></span>
              <span>|</span>
              <span><?php echo htmlspecialchars($review['user_name']); ?></span>
              <span>|</span>
              <span><?php echo $review['formatted_date']; ?></span>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>등록된 리뷰가 없습니다.</p>
      <?php endif; ?>
    </main>
  </body>
</html>