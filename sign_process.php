<?php
$id = $_POST['id'];
$pw = trim($_POST['password']);
$name = $_POST['name'];

// 데이터 유효성 검사
if (empty($id) || empty($pw) || empty($name)) {
    echo "<script>
            alert('모든 필드를 입력해주세요.');
            history.back();
          </script>";
    exit();
}

if (empty($pw)) {
    echo "<script>alert('Password가 입력되지 않았습니다.');</script>";
    exit();
}

// 회원가입 데이터 삽입
$sql = "INSERT INTO member (id, password, name) VALUES ('$id', '$pw', '$name')";
if (mysqli_query($db_conn, $sql)) {
    // 회원가입 성공 시 index.html로 리다이렉션
    echo "<script>
            alert('회원가입이 성공적으로 완료되었습니다.');
            location.href = 'index.html';
          </script>";
} else {
    // 오류 처리
    echo "<script>
            alert('회원가입 중 오류가 발생했습니다: " . mysqli_error($db_conn) . "');
            history.back();
          </script>";
}


mysqli_close($db_conn);
?>
