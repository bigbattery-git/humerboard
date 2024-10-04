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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Document</title>

  
  <script>
const $url = '<?php echo "/lib/comment.php"; ?>'

function insert_comment(){
  const $content = $('#comment').val();

  $.ajax({
    url: $url
    ,type:'POST'
    ,data: {
      action : 'insert'
      ,user_id : <?php echo $user_id; ?>
      ,board_id : <?php echo $board_id; ?>
      ,content : $content
    }
    ,success : function(data){
      alert("작성 성공");
    }
    ,error : function(error){
      alert(error);
    }
  })

  location.reload(true);
}

function delete_comment(comment_id){
  $.ajax({
    url: $url
    ,type: 'POST'
    ,data:{
      action: 'delete'
      ,comment_id : Number(comment_id)
    }
    ,success : function(data){
      alert('삭제 완료');
    }
    ,error : function(error){
      alert('삭제 실패: '+error );
    }
  })

  location.reload(true);
}

function delete_comment_event(comment_id){
  if(confirm("정말로 댓글을 삭제하시겠습니까?")){
    console.log(comment_id);
    delete_comment(comment_id);
  }
  else{
    return;
  }
}

const $detailContent = document.getElementById('content');
autoResize($detailContent);

</script>
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
          <textarea name="content" id="content" readonly rows="<?php echo mb_substr_count($result["content"], "\n"); ?>"><?php echo $result["content"]; ?></textarea>
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
          <form method="post" id="comment_form">
            <ul class="comment_area_ul">
              <li class="comment_area_li comment_name"><?php echo $value["user_name"]; ?></li>
              <li class="comment_area_li comment_comment"><?php echo $value["content"]; ?></li>
              <?php if($value["user_id"] === $user_id) { ?>
                <li class="comment_area_li comment_delete"><button type="button" onclick="delete_comment_event(<?php echo $value['comment_id'] ?>);">삭제</button></li>
              <?php }?>
              <input type="hidden" name="comment_id" value="<?php echo $value["user_id"]; ?>">
            </ul>
          </form>
        <?php } ?>
      </div>
      <?php if(!is_null($user_id)) { ?>
        <form  method="post" class="comment_form_area" id="form">
          <textarea name="comment" id="comment" oninput="autoResize(this)"></textarea>
          <script>
            function autoResize(textarea) {
              textarea.style.height = 'auto' // 높이를 자동으로 초기화
              textarea.style.height = textarea.scrollHeight + 'px' // 스크롤 높이에 맞게 높이 설정
            }
          </script>
          <button type="button" onclick="insert_comment();"><i class="fa-solid fa-arrow-right-to-bracket"></i></button>
        </form>
      <?php } ?>

    </div>
  </main>
  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>