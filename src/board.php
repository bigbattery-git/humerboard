<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  $conn = null;
  try{
    $conn = my_db_conn();
    $offset = 0;

    $arr_prepare = [
      "offset" => $offset 
    ];

    $result = get_board_list($conn, $arr_prepare);

    
  }
  catch(Throwable $th){

    $th->getMessage();
    exit;

  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/board.css">
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
      <div class="board_area">
        <form action="#" method="get">
          <div class="search_area">
            <label for="search">
              <i class="fa-solid fa-magnifying-glass"></i>
            </label>
            <input type="search" name="search" id="search">
          </div>
          <button type="submit">검색</button>
        </form>
        <div class="board">
          <ul class="board-ul">
            <li class="board-ul-li id">글 번호</li>
            <li class="board-ul-li intro-title">제목</li>
            <li class="board-ul-li user_name">작성자</li>
            <li class="board-ul-li created_at">작성일</li>
            <li class="board-ul-li views">조회수</li>
          </ul>
        </div>
        <hr>
        <?php foreach($result as $value) { ?> 
          <div class="board">
            <ul class="board-ul">
              <li class="board-ul-li id"><?php echo $value["board_id"]; ?></li>
              <li class="board-ul-li title"><a href="detail.php?<?php echo $value["board_id"]; ?>"><?php echo $value["title"]; ?></a></li>
              <li class="board-ul-li user_name"><?php echo $value["user_name"]; ?></li>
              <li class="board-ul-li created_at"><?php echo get_date_formet($value["created_at"]); ?></li>
              <li class="board-ul-li views"><?php echo $value["views"]; ?></li>
            </ul>
          </div>
        <?php } ?>
      </div>
      <div class="utility">
        <a href="#"><button class="utility-button">글 작성</button></a>
        <ul class="utility-board_list_num-ul">
          <li class="utility-board_list_num-li"><a href="">이전</a></li>
          <li class="utility-board_list_num-li"><a href="">1</a></li>
          <li class="utility-board_list_num-li"><a href="">2</a></li>
          <li class="utility-board_list_num-li"><a href="">3</a></li>
          <li class="utility-board_list_num-li"><a href="">4</a></li>
          <li class="utility-board_list_num-li"><a href="">5</a></li>
          <li class="utility-board_list_num-li"><a href="">6</a></li>
          <li class="utility-board_list_num-li"><a href="">7</a></li>
          <li class="utility-board_list_num-li"><a href="">8</a></li>
          <li class="utility-board_list_num-li"><a href="">9</a></li>
          <li class="utility-board_list_num-li"><a href="">다음</a></li>
        </ul>
      </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>