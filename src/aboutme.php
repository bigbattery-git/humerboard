<?php

  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  session_start();

?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/aboutme.css">
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <div class="image_area">
      <div class="image_area-img"></div>
    </div>
    <div class="text_area">
      <div class="text_area-title">
        <h1 class="text_area-title-text">선택받은 친구들 어서와!</h1>
      </div>
      <div class="text_area-content">
        <p class="text_area-content-text">          
          "선택받은 아이들" 유머 게시판에 온 걸 환영해! 이곳은 누구나 자유롭게 가입해서 '선택받은 아이들'이라는 주제로 유머와 이야기를 나눌 수 있는 공간이야. 독특한 주제로 모인 만큼, 다 같이 웃고 공감할 수 있는 다양한 이야기를 기대해도 좋아. 가볍게 웃을 수 있는 글부터 생각할 거리를 던져주는 유머까지, 뭐든지 자유롭게 올릴 수 있어. 다만, 글을 쓸 땐 네티켓을 지키는 게 중요해. 다른 사람들에 대한 배려를 잊지 말고, 서로 존중하는 분위기에서 재밌는 시간을 만들어 가자. 다 같이 웃고 떠들면서 이곳에서 좋은 추억을 쌓아보자!
        </p>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>