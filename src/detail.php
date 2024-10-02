<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  session_start();

  try{
    $conn = my_db_conn();
    $board_id = isset($_GET["board_id"]) ? (int)$_GET["board_id"] : 0;
    $user_name = isset($_SESSION["id"]) ?  $_SESSION["id"] : "";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $result = get_board_detail($conn, $board_id);

    $is_myboard = $result["user_name"] === $user_name ? true : false; 

    $conn -> beginTransaction();

    add_views($conn, $result["board_id"], $result["views"] + 1);

    $conn -> commit();

    $result = get_board_detail($conn, $board_id);
  }
  catch(Throwable $th){
    if(!is_null($conn) && $conn->inTransaction()){
      $conn -> rollBack();
    }

    echo $th -> getMessage();
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/detail.css">
  <script src="https://kit.fontawesome.com/351a912326.js" crossorigin="anonymous"></script>
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>
  <main>
      <a href="/board.php">
        <div class="main-title_area">
          <h1 class="main-title_area-text">게시판</h1>
        </div>
      </a>
      
      <div class="main-details">
        <div class="main-board_title_area">
          <p class="main-board_title_area-text"><?php echo get_title_formet($result["title"], 25); ?></p>
        </div>
  
        <ul class="main-intro-ul">
          <li class="main-intro-li user_name"><?php echo $result["user_name"]; ?></li>
          <li class="main-intro-li created_at"><?php echo get_date_formet($result["created_at"]); ?></li>
          <li class="main-intro-li views"><?php echo $result["views"]; ?></li>
        </ul>
  
        <div class="main-content_area">
          <textarea name="content" id="content" readonly rows="<?php echo mb_substr_count($result["content"], "\n"); ?>" ><?php echo $result["content"]; ?></textarea>
        </div>
  
        <div class="utility">
          <div class="utility-buttons">
            <?php if($is_myboard) { ?>
            <a href="/update.php?<?php echo "board_id=".$board_id."&page=".$page ?>" class="utility-a">
              <button class="utility-button">게시글 수정</button>
            </a>
            <a href="/delete.php?<?php echo "board_id=".$board_id."&page=".$page ?>" class="utility-a">
              <button class="utility-button delete">게시글 삭제</button>
            </a>
            <?php } ?>
          </div>
          <a href="./board.php?page=<?php echo $page; ?>" class="utility-a">
            <div class="utility-back">
              <i class="fa-solid fa-rotate-left"></i>
            </div>
          </a>
      </div>
      </div>
  </main>
  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>