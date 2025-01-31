<?php
include "select.php";
include "inc_head.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $movie = $_POST['movie'];
    $content = $_POST['content'];
    
    // 세션에서 사용자 정보 가져오기
    $id = $_SESSION['user_id'];
    $name = $_SESSION['user_name'];

    // 필수 입력값 확인
    if (empty($title) || empty($movie) || empty($content)) {
        echo "<script>alert('모든 필드를 입력해주세요.'); history.back();</script>";
        exit();
    }
    
    $sql = "INSERT INTO reviews (title, content, movie, user_id, user_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db_conn->prepare($sql);
    $stmt->bind_param("sssss", $title, $content, $movie, $id, $name);
    
    if ($stmt->execute()) {
        echo "<script>alert('리뷰가 등록되었습니다.'); location.href='review.php';</script>";
    } else {
        echo "<script>alert('오류가 발생했습니다.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Review</title>
    <link rel="stylesheet" href="create_style.css">
    <link rel="stylesheet" href="style.css">

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
    <main>
      <h1>Movie Review</h1>
    </main>
      <div class="write-container">
        <h2>리뷰 작성</h2>
        <form method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="title">영화 제목</label>
                <input type="text" id="movie" name="movie" required>
            </div>
            
            <div class="form-group">
                <label for="content">내용</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            
            <div class="buttons">
                <button type="submit" class="btn btn-submit">등록하기</button>
                <a href="review.php" class="btn btn-cancel">취소</a>
            </div>
        </form>
    </div>

    <script>
    function validateForm() {
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;
        
        if (title.trim() === '') {
            alert('제목을 입력해주세요.');
            return false;
        }
        
        if (content.trim() === '') {
            alert('내용을 입력해주세요.');
            return false;
        }
        
        return true;
    }
    </script>
    
  </body>
</html>
