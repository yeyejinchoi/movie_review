<?php
include "select.php";
include "inc_head.php";

// GET 요청으로 전달된 review_id 확인
if (isset($_GET['id'])) {
    $review_id = $_GET['id'];
    
    try {
        // status를 'deleted'로 업데이트하는 쿼리
        $sql = "UPDATE reviews SET status = 'deleted' WHERE id = ?";
        $stmt = $db_conn->prepare($sql);
        $stmt->execute([$review_id]);
        
        // 업데이트가 성공적으로 이루어졌는지 확인
        if ($stmt->execute([$review_id])) {
            // JavaScript를 사용하여 알림 표시 후 목록 페이지로 리다이렉트
            echo "<script>
                    alert('삭제되었습니다.');
                    window.location.href = 'review.php';
                  </script>";
        } else {
            echo "<script>
                    alert('삭제할 리뷰를 찾을 수 없습니다.');
                    window.location.href = 'review.php';
                  </script>";
        }
        
    } catch (PDOException $e) {
        // 데이터베이스 오류류 발생 시 처리
        echo "<script>
                alert('오류가 발생했습니다: " . $e->getMessage() . "');
                window.location.href = 'review.php';
              </script>";
    }
    
} else {
    // review_id가 제공되지 않은 경우
    echo "<script>
            alert('잘못된 접근입니다.');
            window.location.href = 'review.php';
          </script>";
}

// 데이터베이스 연결 종료
$conn = null;
?>
