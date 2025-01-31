<?php
session_start();
include "select.php"; // 데이터베이스 연결 파일 포함

// POST 요청으로 받은 데이터
$id = $_POST['id'];
$pw = $_POST['pw'];

// 아이디 존재 여부 확인
$sql = "SELECT * FROM member WHERE user_id = '$id'";
$result = mysqli_query($db_conn, $sql);
$row = mysqli_fetch_array($result);

if (!$row) {
    // 아이디가 존재하지 않는 경우
    echo "<script>
        alert('일치하는 아이디가 없습니다.');
        history.back();
        </script>";
    exit;
} else {
    // 아이디가 존재하는 경우 비밀번호 확인
    if ($row['user_pw'] !== $pw) {
        // 비밀번호 불일치
        echo "<script>
            alert('비밀번호가 일치하지 않습니다.');
            history.back();
            </script>";
        exit;
    } else {
        // 비밀번호 일치, 세션 변수 생성
        $_SESSION['user_name'] = $row['user_name']; // 사용자 이름 저장
        $_SESSION['user_id'] = $row['user_id'];     // 사용자 ID 저장
        mysqli_close($db_conn);          // 데이터베이스 연결 종료

        // 메인 페이지로 이동
        header("Location: REVIEW.php");
        exit;
    }
}
?>
