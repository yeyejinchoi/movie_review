<?php
include "select.php";
include "inc_head.php";

if (isset($_POST['review_id']) && is_numeric($_POST['review_id'])) {
    $review_id = intval($_POST['review_id']);

    try {
        // status를 'deleted'로 업데이트하여 숨김 처리
        $sql = "UPDATE reviews SET status = 'deleted' WHERE id = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->bind_param("i", $review_id);
        $success = $stmt->execute();

        if ($success) {
            echo "<script>
                    alert('리뷰가 삭제되었습니다.');
                    window.location.href = 'review.php';
                  </script>";
        } else {
            echo "<script>
                    alert('리뷰를 삭제할 수 없습니다.');
                    window.location.href = 'review.php';
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('오류가 발생했습니다: " . htmlspecialchars($e->getMessage()) . "');
                window.location.href = 'review.php';
              </script>";
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        $db_conn->close();
    }
} else {
    echo "<script>
            alert('잘못된 접근입니다.');
            window.location.href = 'review.php';
          </script>";
}
?>
