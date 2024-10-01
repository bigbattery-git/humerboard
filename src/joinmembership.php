<?php

  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  $conn = null;
  try{
    if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST"){
      $conn = my_db_conn();
      $user_name = isset($_POST["id"]) ? $_POST["id"] : "";
      $password = isset($_POST["pw"]) ? $_POST["pw"] : "";

      $conn -> beginTransaction();

      join_membership($conn, $user_name, $password);
  
      $conn -> commit();

      header("Location: /joincomplete.php");
    }
  }
  catch(Throwable $th){
    if(!is_null($conn) && $conn -> inTransaction()){
      $conn -> rollBack();
    }

    echo $th -> getMessage();

    exit;
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/logins.css">
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
          회원가입
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
        <button type="submit">가입하기</button>
      </form>
      <div class="main-link_login">
        <p class="main-link_login-text">
          계정을 갖고 계신다면 <a href="#">로그인</a>
        </p>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>