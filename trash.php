<?php
include "select.php";
include "inc_head.php";

// 임시 테스트용 (필요 시 제거)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 'owner';
}

// POST 또는 GET 요청으로 review_id 확인 및 검증
$review_id = null;
if (isset($_POST['review_id']) && is_numeric($_POST['review_id'])) {
    $review_id = intval($_POST['review_id']);
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $review_id = intval($_GET['id']);
} else {
    echo "<script>
            alert('잘못된 접근입니다.');
            window.location.href = 'hidden_review.php';
          </script>";
    exit();
}

// 관리자 권한 확인
if ($_SESSION['user_id'] === 'owner') {
    try {
        // 리뷰 영구 삭제 쿼리
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("i", $review_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // 삭제 후 바로 'hidden_reviews.php'로 리다이렉트
            echo "<script>
                    alert('리뷰가 영구 삭제되었습니다.');
                    window.location.href = 'hidden_review.php';
                  </script>";
        } else {
            echo "<script>
                    alert('삭제할 리뷰를 찾을 수 없습니다.');
                    window.location.href = 'hidden_review.php';
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('오류가 발생했습니다: " . htmlspecialchars($e->getMessage()) . "');
                window.location.href = 'hidden_review.php';
              </script>";
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $db_conn->close();
    }
} else {
    echo "<script>
            alert('관리자만 이 작업을 수행할 수 있습니다.');
            window.location.href = 'hidden_review.php';
          </script>";
}
?>
