<?php
include "select.php";
include "inc_head.php";

// GET 요청으로 전달된 review_id 확인
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $review_id = $_GET['id'];

    // 숨겨진 리뷰도 조회할 수 있도록 status 조건 제거
    $sql = "SELECT title, movie, user_name, created_at, content, status FROM reviews WHERE id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($title, $movie, $review_author, $created_at, $content, $status);
        $stmt->fetch();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo htmlspecialchars($title); ?></title>
            <link rel="stylesheet" href="rev_style.css">
            <link rel="stylesheet" href="rev_det_style.css">

            <script>
              function confirmDelete() {
                if (confirm("이 리뷰를 삭제하시겠습니까?")) {
                  document.getElementById("deleteForm").submit();
                }
              }
            </script>
        </head>
        <body>
            <header>
                <div class="nav-left">T3</div>
                <div class="nav-right">
                    <button onclick="location.href='review.php'">목록으로</button>
                </div>
            </header>
            <main>
                <h1><?php echo htmlspecialchars($title); ?></h1>
                <p><strong>영화:</strong> <?php echo htmlspecialchars($movie); ?></p>
                <p><strong>작성자:</strong> <?php echo htmlspecialchars($review_author); ?></p>
                <p><strong>작성일:</strong> <?php echo $created_at; ?></p>
                <hr>
            <div class="review-content">
                <?php echo nl2br(htmlspecialchars($content)); ?>
            </div>
                <!-- 삭제된 리뷰 표시 -->
                <?php if ($status === 'deleted'): ?>
                    <p style="color: red; font-weight: bold;">이 리뷰는 삭제된 상태입니다.</p>
                <?php endif; ?>

                <!-- 수정 및 삭제 버튼 -->
                <div class="buttons">
                    <!-- 작성자이거나 관리자일 때만 수정 및 삭제 가능 -->
                    <?php if ($_SESSION['user_name'] === $review_author || $_SESSION['user_id'] === 'owner'): ?>
                        <form action="edit_review.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $review_id; ?>">
                            <button type="submit">수정</button>
                        </form>
                        <form id="deleteForm" action="delete_review.php" method="POST" style="display:inline;">
                            <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
                            <button type="button" onclick="confirmDelete()">삭제</button>
                        </form>
                    <?php endif; ?>
                </div>
            </main>
        </body>
        </html>
        <?php
    } else {
        echo "<script>
                alert('존재하지 않는 리뷰입니다.');
                window.location.href = 'review.php';
              </script>";
    }

    $stmt->close();
    $db_conn->close();
} else {
    echo "<script>
            alert('잘못된 접근입니다.');
            window.location.href = 'review.php';
          </script>";
}
?>
