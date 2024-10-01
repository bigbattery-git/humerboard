<?php

  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  try{
    if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST"){
      $id = isset($_POST["id"]) ? $_POST["id"] : "";
      $password = isset($_POST["pw"]) ? $_POST["pw"] : "";
      $conn = my_db_conn();
  
      if(!is_already_account($conn, $id, $password)){
        throw new Exception("계정이 옳지 않습니다.".$id."\n".$password."\n");
      }
  
      session_start();
  
      $_SESSION["id"] = $id;
      $_SESSION["password"] = $password;
      
      header("Location: /index.php");
    }      
  }
  catch(Throwable $th){
    echo $th -> getMessage();
    exit;
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/logins.css">
  <script src="https://kit.fontawesome.com/351a912326.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <div class="main-container">
      <div class="main-title">
        <h1 class="main-title-text">
          로그인
        </h1>
      </div>
      <hr>
      <form action="" method="post">
        <div class="main-form form-id">
          <label for="id" class="main-form-label">
            <div class="main-form-label-icon">
              <i class="fa-solid fa-user"></i>
            </div>
          </label>
          <input type="text" name="id" id="id" placeholder="아이디" required>
        </div>
        <div class="main-form form-password">
          <label for="pw" class="main-form-label">
            <div class="main-form-label-icon">
              <i class="fa-solid fa-lock"></i>
            </div>
          </label>
          <input type="password" name="pw" id="pw" placeholder="비밀번호" required>
        </div>
        <button type="submit">로그인</button>
      </form>
      <div class="main-link_login">
        <p class="main-link_login-text">
          선택받길 원하신다면 <a href="#">회원가입</a>
        </p>
      </div>
      <div class="main-link_login">
        <p class="main-link_login-text">
          선택받은 비밀번호를 잃어버리셨다면 <a href="#">비밀번호 찾기</a>
        </p>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>