<?php
include "select.php";
include "inc_head.php";

// 리뷰 ID 가져오기
if (!isset($_GET['id'])) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='review.php';</script>";
    exit();
}

$review_id = $_GET['id'];

// 리뷰 데이터 가져오기
$sql = "SELECT * FROM reviews WHERE id = ?";
$stmt = $db_conn->prepare($sql);
$stmt->bind_param("i", $review_id);
$stmt->execute();
$result = $stmt->get_result();
$review = $result->fetch_assoc();

// 해당 ID의 리뷰가 없을 때
if (!$review) {
    echo "<script>alert('존재하지 않는 리뷰입니다.'); location.href='review.php';</script>";
    exit();
}

// 세션 사용자와 리뷰 작성자가 불일치 시 수정 불가
if ($_SESSION['user_id'] != $review['user_id']) {
    echo "<script>alert('본인의 리뷰만 수정할 수 있습니다.'); location.href='review.php';</script>";
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>리뷰 수정</title>
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
        <h1>리뷰 수정</h1>
    </main>
    <div class="write-container">
        <h2>리뷰 수정</h2>
        <form method="POST" action="update_review.php" onsubmit="return validateForm()">
            <input type="hidden" name="id" value="<?= $review['id'] ?>">

            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($review['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="movie">영화 제목</label>
                <input type="text" id="movie" name="movie" value="<?= htmlspecialchars($review['movie']) ?>" required>
            </div>

            <div class="form-group">
                <label for="content">내용</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($review['content']) ?></textarea>
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-submit">수정하기</button>
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
