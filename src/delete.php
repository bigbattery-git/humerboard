<?php
  
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  session_start();
  $conn;
  try{
    $user_name = isset($_SESSION["id"])? $_SESSION : throw_error();
    $conn = my_db_conn();
    if(strtoupper($_SERVER["REQUEST_METHOD"]) === "GET"){
      $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
      $board_id = isset($_GET["board_id"]) ? (int)$_GET["board_id"] : throw_error();

      $result = get_board_detail($conn, $board_id);
    }

    else{
      $page = isset($_POST["page"]) ? (int)$_POST["page"] : 1;
      $board_id = isset($_POST["board_id"]) ? (int)$_POST["board_id"] : throw_error();

      $conn -> beginTransaction();

      delete_board($conn, $board_id);

      $conn -> commit();

      header("Location: /board.php?page=".$page);

      exit;
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
    <form action="/delete.php" method="post">
      <input type="hidden" name="page" value="<?php echo $page ?>">
      <input type="hidden" name="board_id" value="<?php echo $board_id ?>">
      <a href="/board.php">
        <div class="main-title_area">
          <h1 class="main-title_area-text">게시판</h1>
        </div>
      </a>
      
      <div class="main-details">
        <div class="main-board_title_area">
          <p class="main-board_title_area-text"><?php echo get_title_formet($result["title"], 25); ?></p>
        </div>
    
        <div class="main-content_area">
          <textarea name="content" id="content" placeholder="내용을 입력하세요" readonly><?php echo $result["content"]; ?></textarea>
        </div>
    
        <div class="utility">
          <div class="utility-buttons">
            <button type="submit" class="utility-button delete">게시글 삭제</button>
          </div>
          <a href="/detail.php?<?php echo "board_id=".$board_id."&page=".$page; ?>" class="utility-a">
            <div class="utility-back">
              <i class="fa-solid fa-rotate-left"></i>
            </div>
          </a>
        </div>
      </div>
    </form>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>