<?php

  require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");

?>


<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/common.css">
  <link rel="stylesheet" href="../css/aboutme.css">
  <title>Document</title>
</head>
<body>
  <?php
    require_once(MY_ROOT_HEADER);
  ?>

  <main>
    <div class="image_area">
      <div class="image_area-img"></div>
    </div>
    <div class="text_area">
      <div class="text_area-title">
        <h1 class="text_area-title-text">반갑다구요!</h1>
      </div>
      <div class="text_area-content">
        <p class="text_area-content-text">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni corrupti beatae reiciendis consequuntur accusamus non voluptate. Culpa dolorem vero non, tempore, consequatur incidunt quos nesciunt voluptatum totam voluptatem dolorum quibusdam.
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus, vitae delectus odit minus ab commodi praesentium ipsum natus? Eum doloremque eius repudiandae eos sequi accusamus hic mollitia dolore provident labore?
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus vel obcaecati et autem aliquid totam sit, quo sapiente aut cumque ut fugiat eligendi quod sequi, dolorem placeat. Dicta, incidunt minima.
          Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae nostrum maxime provident repellat temporibus cupiditate possimus, quod architecto. Ad inventore, cum ab quis qui esse. Totam architecto nesciunt molestias deserunt!
        </p>
      </div>
    </div>
  </main>

  <?php
    require_once(MY_ROOT_FOOTER);
  ?>
</body>
</html>