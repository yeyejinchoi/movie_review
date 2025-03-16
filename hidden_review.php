<?php
  include "select.php";
  include "inc_head.php";

  // 숨겨진 리뷰 조회
  $sql = "SELECT *, DATE_FORMAT(created_at, '%Y-%m-%d') as formatted_date
          FROM reviews
          WHERE status = 'deleted'
          ORDER BY created_at DESC";

  $result = $db_conn->query($sql);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>숨겨진 리뷰 목록</title>
    <link rel="stylesheet" href="rev_style.css">
    <style>
      /* 쓰레기통 아이콘 스타일 */
      .delete-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #f44336; /* 빨간색 */
        font-size: 20px;
      }

      .delete-button:hover {
        color: #d32f2f; /* 마우스를 올렸을 때 색 변화 */
      }
    </style>
  </head>
  <body>
    <header>
      <div class="nav-left">T3</div>
      <div class="nav-right">
        <button onclick="location.href='review.php'">돌아가기</button>
      </div>
    </header>
    <main>
      <h1>숨겨진 리뷰 목록</h1>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($review = $result->fetch_assoc()): ?>
          <div class="review-item">
            <a href="review_detail.php?id=<?php echo $review['id']; ?>" class="review-title">
              <?php echo htmlspecialchars($review['title']); ?>
            </a>
            <div class="review-info">
              <span><?php echo htmlspecialchars($review['movie']); ?></span>
              <span>|</span>
              <span><?php echo htmlspecialchars($review['user_name']); ?></span>
              <span>|</span>
              <span><?php echo $review['formatted_date']; ?></span>
            </div>

            <!-- 삭제 버튼 (쓰레기통 아이콘) -->
            <form action="trash.php" method="POST" class="delete-form">
              <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
              <button type="submit" class="delete-button" title="삭제">🗑️</button>
            </form>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>숨겨진 리뷰가 없습니다.</p>
      <?php endif; ?>
    </main>
  </body>
</html>
