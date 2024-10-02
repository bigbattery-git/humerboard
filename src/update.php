<?php

  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  session_start();

  $conn;
  $user_id;
  $board_id;
  $page;

  try{

    if(isset($_SESSION["id"])){
      $user_id = $_SESSION["id"];
    }
    else{
      throw new Exception("비정상적인 접근입니다. 로그인 후 사용하세요.");
    }

    if(strtoupper($_SERVER["REQUEST_METHOD"] === "GET")){
      $board_id = isset($_GET["board_id"]) ? (int)$_GET["board_id"] : throw_error();
      $page = isset($_GET["page"]) ? (int)$_GET["page"] : throw_error();

      $conn = my_db_conn();

      $result = get_board_detail($conn, $board_id);
    }
    else{
      $conn = my_db_conn();

      $board_id = isset($_POST["board_id"]) ? (int)$_POST["board_id"] : throw_error();
      $page = isset($_POST["page"]) ? (int)$_POST["page"] : throw_error();
      $title = isset($_POST["title"]) ? $_POST["title"] : throw_error();
      $content = isset($_POST["content"]) ? $_POST["content"] : throw_error();

      $arr_prepare = [
        "title" => $title,
        "content" => $content,
        "board_id" => $board_id
      ];

      $conn -> beginTransaction();

      update_board($conn, $arr_prepare);

      $conn -> commit();

      header("Location: /detail.php?board_id=".$board_id."&page=".$page."&user_id=".$user_id);
    }
  }

  catch(Throwable $th){
    if(!is_null($conn) && $conn -> inTransaction()){
      $conn -> rollBack();
    }
    echo $th->getMessage();

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
    <a href="/board.php">
      <div class="main-title_area">
        <h1 class="main-title_area-text">게시판</h1>
      </div>
    </a>
    <form action="/update.php" method="post">
    <div class="main-details">
      <div class="main-board_title_area">
        <input type="text" name="title" id="title" class="main-board_title_area-text" placeholder="제목을 입력하세요" value="<?php echo $result["title"]; ?>">
      </div>

      <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
      <input type="hidden" name="page" value="<?php echo $page; ?>">
      <div class="main-content_area">
      <textarea name="content" id="content" placeholder="내용을 입력하세요" rows="<?php echo mb_substr_count($result["content"], "\n"); ?>" 
      required oninput="autoResize(this)"><?php echo $result["content"]; ?></textarea>
        <script>
          function autoResize(textarea) {
            textarea.style.height = 'auto' // 높이를 자동으로 초기화
            textarea.style.height = textarea.scrollHeight + 'px' // 스크롤 높이에 맞게 높이 설정
          }
        </script>
      </div>
    
        <div class="utility">
          <div class="utility-buttons">
            <a href="#" class="utility-a">
              <button class="utility-button">게시글 수정</button>
            </a>
          </div>
          <a href="#" class="utility-a">
            <div class="utility-back">
              <i class="fa-solid fa-rotate-left"></i>
            </div>
          </a>
        </div>
      </form>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>