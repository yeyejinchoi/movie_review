<?php
session_start();

session_unset();
session_destroy();

// 로그아웃 후 index페이지로 감
echo "<script>
        alert('로그아웃 되었습니다.');
        location.href = 'index.html';
      </script>";
exit();
?>
