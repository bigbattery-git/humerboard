<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
  require_once(MY_ROOT_DB_LIB);
  require_once(MY_ROOT_UTILITY);

  session_start();

  try{
    $conn = my_db_conn();
    $board_id = isset($_GET["board_id"]) ? (int)$_GET["board_id"] : 0;
    $user_id = isset($_SESSION["id"]) ?  $_SESSION["id"] : null;
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $arr_prepare = [
      "board_id" => $board_id
    ];

    $result = get_board_detail($conn, $arr_prepare);

    $is_myboard = $result["user_id"] === $user_id ? true : false; 

    $conn -> beginTransaction();

    add_views($conn, $result["board_id"], $result["views"] + 1);

    $conn -> commit();



    $result = get_board_detail($conn, $arr_prepare);

    $result_comment = get_board_comment($conn, $arr_prepare);

    if(strtoupper($_SERVER["REQUEST_METHOD"]) === "POST"){

    }
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

      <div class="comment_area">
        <ul class="comment_area_ul">
          <li class="comment_area_li comment_name">이름</li>
          <li class="comment_area_li comment_comment">댓글</li>
        </ul>
        <hr>
        <?php foreach($result_comment as $value) { ?>
          <form action="/detail.php" method="post">
            <ul class="comment_area_ul">
              <li class="comment_area_li comment_name"><?php echo $value["user_name"]; ?></li>
              <li class="comment_area_li comment_comment"><?php echo $value["content"]; ?></li>
              <?php if($value["user_id"] === $user_id) { ?>
                <li class="comment_area_li comment_delete"><button type="button" onclick="delete_comment();">삭제</button></li>
                <script>
                  function delete_comment(){
                    if(confirm("정말로 댓글을 삭제하시겠습니까?")){
                      alert("삭제완료");
                    }
                    else{
                      return;
                    }
                  }
                </script>
              <?php }?>
              <input type="hidden" name="comment_id" value="<?php echo $value["user_id"]; ?>">
            </ul>
          </form>
        <?php } ?>
      </div>
      <?php if(!is_null($user_id)) { ?>
        <form action="/detail.php?<?php echo "board_id=".$board_id."&page=".$page; ?>" method="post" class="comment_form_area">
          <textarea name="comment" id="comment" oninput="autoResize(this)"></textarea>
          <script>
            function autoResize(textarea) {
              textarea.style.height = 'auto' // 높이를 자동으로 초기화
              textarea.style.height = textarea.scrollHeight + 'px' // 스크롤 높이에 맞게 높이 설정
            }
          </script>
          <button type="submit"><i class="fa-solid fa-arrow-right-to-bracket"></i></button>
        </form>
      <?php } ?>

    </div>
  </main>
  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>