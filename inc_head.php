<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        $login = TRUE;
    }
    else{
        $login = FALSE;
    }
?>

<!-- include 하여 로그인 상태 유지 -->