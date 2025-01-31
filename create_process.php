<?php
include "select.php";
include "inc_head.php";

$filtered = array(
    'title' => mysqli_real_escape_string($db_conn, $_POST['title']),
    'content' => mysqli_real_escape_string($db_conn, $_POST['content']),
    'movie' => mysqli_real_escape_string($db_conn, $_POST['movie']),

);


$sql = "
    INSERT INTO reviews
        (title, content, movie, created_at)
        VALUES(
            '{$filtered['title']}',
            '{$filtered['content']}',
            '{$filtered['movie']}',
            
            NOW()
            )
";

$result = mysqli_query($db_conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다.';
    error_log(mysqli_error($db_conn));
} else{
    echo'성공했습니다.<a href="review.php">돌아가기</a>';
}
?>