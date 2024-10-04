<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);
  session_start();

  $conn;
  $user_name;
  try{
    if(isset($_SESSION["id"])){
      $user_name = $_SESSION["id"];
    }
    else{
      $user_name = "";
    }
    
    $conn = my_db_conn();
    $arr_prepare_newboard=[
      "limit" => 5,
      "offset"=> 0
    ];

    $result_newboard = get_board_list($conn, $arr_prepare_newboard);

    $result_hotboard = get_board_list_mostview($conn);
  }
  catch(Throwable $th){
    
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/index.css">
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
          <?php foreach($result_newboard as $value) { ?>
            <ul class="board-list-ul">
              <a href="/detail.php?<?php echo "board_id=".$value["board_id"]."&page=1"; ?>">
                <li class="board-list-li-title"><?php echo get_title_formet($value["title"], 12); ?></li>
              </a>
              <li class="board-list-li-created_at"><?php echo get_date_formet($value["created_at"]); ?></li>
            </ul>
          <?php } ?>
        </div>
      </div>

      <div class="board-hotboard">
        <div class="board-title">
          <p class="board-title-text">인기 게시글</p>
        </div>
        <div class="board-list">
          <?php foreach($result_hotboard as $value) { ?>
            <ul class="board-list-ul">
              <a href="/detail.php?<?php echo "board_id=".$value["board_id"]."&page=1"; ?>">
                <li class="board-list-li-title"><?php echo get_title_formet($value["title"], 12); ?></li>
              </a>
              <li class="board-list-li-created_at"><?php echo $value["views"]; ?></li>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="introduce-content-left" style="background-color: aqua;">
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            선택받은 이야기
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            특별한 아이들의 이야기를 나눠요.
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <a href="/aboutme.php"><button type="button">알아보기</button></a>
        </div>
      </div>
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img"></div>
      </div>
    </div>

    <div class="introduce-content-right">
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img" style="background-image: url('https://i.pinimg.com/564x/92/eb/10/92eb103d8f04c5c11b1acdf6e3e5b64d.jpg');"></div>
      </div>
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            운명적 만남터
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            선택받은 자들의 다양한 이야기
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <a href="/board.php"><button type="button">알아보기</button></a>
        </div>
      </div>
    </div>

    <div class="introduce-content-left" style="background-color: aquamarine;">
      <div class="introduce-content-textarea">
        <div class="introduce-content-textarea-title">
          <p class="introduce-content-textarea-title-text">
            선택의 문으로
          </p>
        </div>
        <div class="introduce-content-textarea-content">
          <p class="introduce-content-textarea-content-text">
            선택받은 자들의 세계로 입장하세요
          </p>
        </div>
        <div class="introduce-content-textarea-button">
          <?php if(!isset($_SESSION["id"])) { ?>
            <a href="/login.php"><button type="button">알아보기</button></a>
          <?php } ?>
        </div>
      </div>
      <div class="introduce-content-img_area">
        <div class="introduce-content-img_area-img" style="background-image: url('https://i.pinimg.com/564x/91/7e/4c/917e4c07c97f2f55c33666c21b8660fe.jpg');"></div>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>