<?php
include "select.php";
include "inc_head.php";

$review_id = intval($_GET['id']);

// 리뷰 상세 조회 쿼리
$sql = "SELECT *, 
               DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as formatted_date FROM reviews WHERE id = ?";

$stmt = $db_conn->prepare($sql);
$stmt->bind_param("i", $review_id);  // 파라미터 바인딩 추가
$stmt->execute();
$result = $stmt->get_result();
$review = $result->fetch_assoc();  // 특정 리뷰 가져오기

// 리뷰 존재 확인
if ($result->num_rows == 0) {
    echo "<script>alert('존재하지 않는 리뷰입니다.'); history.back();</script>";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Detail</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="rev_det_style.css">

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

    <div class="review-detail-container">
        <div class="review-header">
            <h1 class="review-title"><?php echo htmlspecialchars($review['title']); ?></h1>
            <div class="review-meta">
                <span>영화: <?php echo htmlspecialchars($review['movie']); ?></span>
                <span>|</span>
                <span>작성자: <?php echo htmlspecialchars($review['user_name']); ?></span>
                <span>|</span>
                <span>작성일: <?php echo $review['formatted_date']; ?></span>
            </div>
        </div>

        <div class="review-content">
            <?php echo nl2br(htmlspecialchars($review['content'])); ?>
        </div>

        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
            <div class="review-actions">
                <a href="edit_review.php?id=<?php echo $review['id']; ?>" class="btn btn-edit">수정</a>
                <a href="delete_review.php?id=<?php echo $review['id']; ?>" 
                   class="btn btn-delete" 
                   onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
            </div>
        <?php endif; ?>

        <div class="review-navigation">
            <a href="review.php">목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$db_conn->close();
?>