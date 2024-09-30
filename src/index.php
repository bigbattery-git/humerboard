<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/index.css">
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <div class="board">
      <div class="board-newboard">
        <div class="board-title">
          <p class="board-title-text">신규 게시글</p>
        </div>
        <div class="board-list">
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
        </div>
      </div>

      <div class="board-hotboard">
        <div class="board-title">
          <p class="board-title-text">인기 게시글</p>
        </div>
        <div class="board-list">
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
          <ul class="board-list-ul">
            <a href="#"><li class="board-list-li-title">제목</li></a>
            <li class="board-list-li-created_at">24-09-30</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="introduce-content-left" style="background-color: aqua;">
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            반갑습니다!
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            여러분들은 모두 디지털 세계의 선택받은 분들이 될 수 있습니다!
            <br>
            이 세계가 궁금하다면?
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <a href="#"><button type="button">알아보기</button></a>
        </div>
      </div>
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img"></div>
      </div>
    </div>

    <div class="introduce-content-right">
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img"></div>
      </div>
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            반갑습니다 여러분!
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            여러분들은 모두 디지털 세계의 선택받은 분들이 될 수 있습니다!
            <br>
            이 세계가 궁금하다면?
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <a href="#"><button type="button">알아보기</button></a>
        </div>
      </div>
    </div>

    <div class="introduce-content-left" style="background-color: aquamarine;">
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            반갑습니다 여러분!
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            여러분들은 모두 디지털 세계의 선택받은 분들이 될 수 있습니다!
            <br>
            이 세계가 궁금하다면?
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <a href="#"><button type="button">알아보기</button></a>
        </div>
      </div>
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img"></div>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>