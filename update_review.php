<?php
include "select.php";
include "inc_head.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_id = $_POST['id'];
    $title = $_POST['title'];
    $movie = $_POST['movie'];
    $content = $_POST['content'];

    // 사용자 정보 가져오기
    $user_id = $_SESSION['user_id'];

    // 필수 입력값 확인
    if (empty($title) || empty($movie) || empty($content)) {
        echo "<script>alert('모든 필드를 입력해주세요.'); history.back();</script>";
        exit();
    }

    // 현재 로그인한 사람과 작성자가 일치한지 확인
    $sql_check = "SELECT * FROM reviews WHERE id = ? AND user_id = ?";
    $stmt_check = $db_conn->prepare($sql_check);
    $stmt_check->bind_param("is", $review_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        echo "<script>alert('본인의 리뷰만 수정할 수 있습니다.'); location.href='review.php';</script>";
        exit();
    }

    //업데이트 실행
    $sql = "UPDATE reviews SET title = ?, content = ?, movie = ?, updated_at = NOW() WHERE id = ? AND user_id = ?";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("sssis", $title, $content, $movie, $review_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('리뷰가 수정되었습니다.'); location.href='review.php';</script>";
    } else {
        echo "<script>alert('오류가 발생했습니다.');</script>";
    }

    $stmt->close();
}
?>
