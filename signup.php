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
    $query = "INSERT INTO member (id, password, name) VALUES ('$id', '$pw', '$name')";
    if (mysqli_query($conn, $query)) {
        // 회원가입 성공 시 review.html로 리다이렉션
        echo "<script>
                alert('회원가입이 성공적으로 완료되었습니다.');
                location.href = 'index.html';
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
    <link rel="stylesheet" href="../css/style.css">
    <title>회원가입</title>
</head>
<body>
    <div id="signup_wrap" class="wrap" style="text-align: center; padding: 20px;">
        <h1 style="margin-bottom: 20px;">Sign up</h1>
        <form action="signup.php" method="post" id="signup_form" class="form" style="max-width: 400px; margin: 0 auto; text-align: left;">
            <label for="name" style="font-weight: bold; margin-top: 10px;">Name</label>
            <input type="text" name="name" id="name" placeholder="Input Field" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;" value="<?= isset($name) ? $name : '' ?>">

            <label for="id" style="font-weight: bold; margin-top: 10px;">ID</label>
            <input type="text" name="id" id="id" placeholder="Input Field" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;" value="<?= isset($id) ? $id : '' ?>">

            <label for="password" style="font-weight: bold; margin-top: 10px;">비밀번호</label>
            <input type="password" name="pw" id="password" placeholder="Input Field" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="password_check" style="font-weight: bold; margin-top: 10px;">비밀번호 확인</label>
            <input type="password" name="pw_ch" id="password_check" placeholder="Input Field" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">

            <button type="submit" style="width: 100%; padding: 15px; background-color: #333; color: white; border: none; border-radius: 5px; cursor: pointer;">회원가입</button>
        </form>
    </div>
</body>
</html>
