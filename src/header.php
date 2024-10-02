<?php
  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");
?>
  
<header>
  <nav>
    <div class="leftside">
      <a href="/index.php"><div class="logo"></div></a>
    </div>
    <div class="rightside">
      <ul class="rightside-ul">
        <a href="/aboutme.php"><li class="rightside-ul-li">디지털 세계 안내</li></a>
        <a href="/board.php"><li class="rightside-ul-li">세계 게시판</li></a>
        <?php if(isset($_SESSION["id"])) {?>
          <a href="/logout.php"><li class="rightside-ul-li li-member">로그아웃</li></a>
        <?php } else { ?>
          <a href="/login.php"><li class="rightside-ul-li li-member">로그인</li></a>
          <a href="/joinmembership.php"><li class="rightside-ul-li li-member">회원가입</li></a>
        <?php } ?>
      </ul>
    </div>
  </nav>
</header>