<?php
$conn = mysqli_connect("localhost", "root", "", "siss");

// 연결 확인
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// 폼이 제출되었을 때
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 폼 값 받기
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $pw_ch = $_POST['pw_ch']; // 비밀번호 확인 필드 추가
    $name = $_POST['name'];

    // 데이터  검사
    if (empty($id) || empty($pw) || empty($name) || empty($pw_ch)) {
        echo "<script>
                alert('모든 필드를 입력해주세요.');
                history.back();
              </script>";
        exit();
    }

    // 비밀번호 길이 체크
    if (strlen($pw) < 4 || strlen($pw) > 15) {
        echo "<script>
                alert('비밀번호는 4자 이상 15자 이하로 입력해주세요.');
                history.back();
              </script>";
        exit();
    }

    // 비밀번호 확인 체크
    if ($pw !== $pw_ch) {
        echo "<script>
                alert('비밀번호가 일치하지 않습니다.');
                history.back();
              </script>";
        exit();
    }

    // 회원가입 데이터 삽입 쿼리
    $query = "INSERT INTO member (user_id, user_pw, user_name) VALUES ('$id', '$pw', '$name')";
    if (mysqli_query($conn, $query)) {
        // 회원가입 성공 시 review.html로 리다이렉션
        echo "<script>
                alert('회원가입이 성공적으로 완료되었습니다.');
                location.href = 'index.php';
              </script>";
    } else {
        // 오류 처리
        echo "<script>
                alert('회원가입 중 오류가 발생했습니다: " . mysqli_error($conn) . "');
                history.back();
              </script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>회원가입</title>
</head>
<body>
    <div id="signup_wrap" class="wrap">
        <h1>Sign up</h1>
        <form action="signup.php" method="post" id="signup_form" class="form">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Input Field" value="<?= isset($name) ? $name : '' ?>">

            <label for="id">ID</label>
            <input type="text" name="id" id="id" placeholder="Input Field" value="<?= isset($id) ? $id : '' ?>">

            <label for="password">비밀번호</label>
            <input type="password" name="pw" id="password" placeholder="Input Field">

            <label for="password_check">비밀번호 확인</label>
            <input type="password" name="pw_ch" id="password_check" placeholder="Input Field">

            <button type="submit">회원가입</button>
        </form>
    </div>
</body>
</html>