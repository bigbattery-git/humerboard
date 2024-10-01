<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);

  session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/insert.css">
  <script src="https://kit.fontawesome.com/351a912326.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <a href="#">
      <div class="main-title_area">
        <h1 class="main-title_area-text">게시판</h1>
      </div>
    </a>
    
    <form action="#" method="$_POST" class="main-details">
      <div class="main-board_title_area">
        <input type="text" name="text" id="text" class="main-board_title_area-text" placeholder="제목을 입력하세요">
      </div>

      <div class="main-content_area">
        <textarea name="content" id="content" placeholder="내용을 입력하세요"></textarea>
      </div>

      <div class="utility">
        <div class="utility-buttons">
          <a href="#" class="utility-a">
            <button class="utility-button">게시글 추가</button>
          </a>
        </div>
        <a href="#" class="utility-a">
          <div class="utility-back">
            <i class="fa-solid fa-rotate-left"></i>
          </div>
        </a>
      </div>
    </form>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>