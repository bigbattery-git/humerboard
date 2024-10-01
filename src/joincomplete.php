<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/joincomplete.css">
  
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <div class="main-container">
      <div class="main-title">
        <h1 class="main-title-text">회원가입 완료!</h1>
      </div>
      <div class="main-content">
        <p class="main-content-text">당신도 이젠 선택받은 아이입니다! 첫 게시글을 남겨보세요!<br>
        회원가입 후 로그인을 해주시기 바랍니다.</p>
      </div>
      <a href="/login.php" class="main-button-area"><button type="button" class="main-button">로그인으로</button></a>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>