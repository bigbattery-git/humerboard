<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);

  session_start();

  $conn = null;
  $user_name = null;
  try{

    if(isset($_SESSION["id"])){
      $user_name = $_SESSION["id"];
    }
    else{
      throw new Exception("잘못된 접근입니다. : 로그인 필요");
    }

    if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST"){
      $conn = my_db_conn();
      $title = isset($_POST["title"]) ? $_POST["title"] : "";
      $content = isset($_POST["content"]) ? $_POST["content"] : "";

      $arr_prepare = [
        "user_name" => $user_name,
        "title" => $title,
        "content" => $content
      ];

      $conn -> beginTransaction();

      $board_id = insert_board($conn, $arr_prepare);

      $conn -> commit();

      header("Location: /detail.php?board_id=".$board_id);

      exit;
    }
  } catch(Throwable $th) {

    if(!is_null($conn) && $conn -> inTransaction() ){
      $conn -> rollBack();
    }

    $th -> getMessage();

    exit;
  }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/insert.css">
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
    
    <form action="/insert.php" method="POST" class="main-details">
      <div class="main-board_title_area">
        <input type="text" name="title" id="title" class="main-board_title_area-text" placeholder="제목을 입력하세요" required>
      </div>

      <div class="main-content_area">
        <textarea name="content" id="content" placeholder="내용을 입력하세요" required></textarea>
      </div>

      <div class="utility">
        <div class="utility-buttons">
          <button type="submit" class="utility-button">게시글 추가</button>
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