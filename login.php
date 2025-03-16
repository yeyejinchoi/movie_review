<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login.css" />
  <title>로그인</title>

  <script type="text/javascript">
    function login_check(event) {

      event.preventDefault();

      var userid = document.getElementById("id");
      var userpw = document.getElementById("pw");

      document.querySelector(".err_id").textContent = "";
      document.querySelector(".err_pw").textContent = "";

      if (userid.value.trim() === "") {
        var id_txt = document.querySelector(".err_id");
        id_txt.textContent = "아이디를 입력하세요.";
        userid.focus();
        return false;
      }

      if (userpw.value.trim() === "") {
        var pw_txt = document.querySelector(".err_pw");
        pw_txt.textContent = "비밀번호를 입력하세요.";
        userpw.focus();
        return false;
      }

      document.getElementById("login_form").submit();
    }
  </script>
</head>

<body>
  <?php
  session_start();

//이미 로그인되어있다면 오류라고 출력
  if (isset($_SESSION['user_name'])) {
    echo "<script>
            alert('이미 로그인 하셨습니다.');
            location.href = 'review.php';
          </script>";
    exit();
  }
  ?>

  <div id="login_wrap" class="wrap">
    <div>
      <h1>Login</h1>
      <form action="login_proc.php" method="post" name="loginform" id="login_form" class="form" onsubmit="login_check(event)">

        <p><input type="text" name="id" id="id" placeholder="ID"></p>
        <span class="err_id"></span>

        <p><input type="password" name="pw" id="pw" placeholder="Password"></p>
        <span class="err_pw"></span>

        <p><input type="submit" value="로그인" class="form_btn"></p>

  
        <p class="pre_btn"><a href="signup.php">회원가입</a></p>
      </form>
    </div>
  </div>
</body>

</html>
