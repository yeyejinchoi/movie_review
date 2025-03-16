<?php
  include "select.php";
  include "inc_head.php";

  // 기본 SQL 문
  $sql = "SELECT *, DATE_FORMAT(created_at, '%Y-%m-%d') as formatted_date
          FROM reviews
          WHERE status = 'active'";

  // 검색어 처리
  $searchParams = [];
  $paramTypes = '';
  if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
      $searchWords = explode(" ", trim($_GET['search']));  // 공백 기준으로 검색어 나누기
      $searchConditions = [];

      // 각 단어에 대해 title, movie, user_name 검색
      foreach ($searchWords as $word) {
          // LIKE 조건에 %%를 추가하여 부분 포함 검색 강화
          $searchConditions[] = "(title LIKE CONCAT('%', ?, '%')
                                  OR movie LIKE CONCAT('%', ?, '%')
                                  OR user_name LIKE CONCAT('%', ?, '%'))";
          array_push($searchParams, $word, $word, $word);
          $paramTypes .= 'sss';
      }

      // 검색 조건 추가
      $sql .= " AND (" . implode(" OR ", $searchConditions) . ")";
  }

  $sql .= " ORDER BY created_at DESC";

  // Prepared Statement 생성
  $stmt = $db_conn->prepare($sql);

  // 파라미터가 있을 때만 바인딩
  if (!empty($searchParams)) {
      $stmt->bind_param($paramTypes, ...$searchParams);
  }

  $stmt->execute();
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Review List</title>
    <link rel="stylesheet" href="rev_style.css">
</head>
<body>
  <header>
    <div class="nav-left">
        T3
        <form action="" method="GET" class="search-form">
            <input type="text" name="search" placeholder="검색어를 입력하세요"
                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="search-button">검색</button>
        </form>
    </div>
    <div class="nav-right">
        <span>Welcome, <?= $_SESSION['user_name'] ?></span>
        <button onclick="location.href='logout.php'">LOG OUT</button>
        <button onclick="location.href='create.php'">리뷰 작성</button>
        <?php if ($_SESSION['user_id'] === 'owner'): ?>
            <button onclick="location.href='hidden_review.php'">숨겨진 리뷰 보기</button>
        <?php endif; ?>
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
                      <span><?php echo htmlspecialchars($review['movie']); ?></span>
                      <span>|</span>
                      <span><?php echo htmlspecialchars($review['user_name']); ?></span>
                      <span>|</span>
                      <span><?php echo $review['formatted_date']; ?></span>

                      <?php if ($_SESSION['user_id'] === 'owner'): ?>
                          <form action="trash.php" method="POST" class="delete-form">
                              <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                              <button type="submit" class="delete-button">🗑️</button>
                          </form>
                      <?php endif; ?>
                  </div>
              </div>
          <?php endwhile; ?>
      <?php else: ?>
          <p>등록된 리뷰가 없습니다.</p>
      <?php endif; ?>
  </main>
</body>
</html>

<?php
$stmt->close();
$db_conn->close();
?>
