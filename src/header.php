<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");

  $is_logined = isset($_SESSION["id"]) ? true : false;
?>
  
<header>
  <nav>
    <div class="leftside">
      <a href="/index.php"><div class="logo"></div></a>
    </div>
    <div class="rightside">
      <ul class="rightside-ul">
        <a href="#"><li class="rightside-ul-li">디지털 세계 안내</li></a>
        <a href="/board.php"><li class="rightside-ul-li">세계 게시판</li></a>
        <?php if($is_logined) {?>
          <a href="/login.php"><li class="rightside-ul-li li-member">로그아웃</li></a>
        <?php } else { ?>
          <a href="/login.php"><li class="rightside-ul-li li-member">로그인</li></a>
          <a href="#"><li class="rightside-ul-li li-member">회원가입</li></a>
        <?php } ?>
      </ul>
    </div>
  </nav>
</header>