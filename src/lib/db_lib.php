<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");

function my_db_conn(){
  //  PDO 옵션 설정
  $my_otp = [
    // Prepared Statement. 쿼리문을 준비할 때, PHP와 DB 어디에서 에뮬레이션을 할 것인가
    PDO::ATTR_EMULATE_PREPARES    => false, // DB에서 하겠다는 뜻

    // PDO에서 예외를 처리하는 방법 (에러 등을 어떻게 처리할 것인가)
    PDO::ATTR_ERRMODE             => PDO::ERRMODE_EXCEPTION,

    // DB 정보를 가져와서 fetch하는 방법
    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC
  ];

  // DB 접속
  return new PDO(MY_DSN, MY_USER, MY_PASSWORD, $my_otp);
}

/**
 * 게시판 리스트 받아오기
 * @param $conn = PDO Class
 * @param $arr_param = limit, offset
 */
function get_board_list(PDO $conn, array $arr_param){
  
  $sql = 
  " SELECT ".
  " boards.board_id,               ".
  " boards.title,                  ". 
  " users.user_name,               ". 
  " boards.created_at,             ".
  " boards.views                   ".
  " FROM boards                    ".
	" JOIN users                     ".
	" ON                             ". 
  " boards.user_id = users.user_id ".
  " ORDER BY boards.board_id DESC  ".
  " LIMIT :limit                   ".
  " OFFSET :offset                 ";

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);

  if(!$result_flg){
    throw new Exception("Error - Query failed : get_board_list");
  }

  $result = $stmt -> fetchAll();

  return $result;
}

function get_board_count(PDO $conn){
  $sql=
  " SELECT COUNT(*) AS 'count'".
  " FROM boards ".
  " WHERE deleted_at IS NULL "
  ;

  $stmt = $conn -> query($sql);

  $result = $stmt -> fetch();
  return $result["count"];
}

function is_already_account(PDO $conn, string $user_name, string $user_password){

  // 아이디 있는지 확인, 비밀번호 있는지 확인
  
  if(!is_already_user_name($conn, $user_name)){
    return false;
  }

  $sql = 
  " SELECT PASSWORD ".
  " FROM ".
  " users ".
  " WHERE ". 
  " CONVERT(AES_DECRYPT(UNHEX(PASSWORD),'testkey') USING UTF8) = :pw ".
  " ; "
  ;

  $arr_prepare = [
    "pw" => $user_password
  ];

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_prepare);

  if(!$result_flg){
    throw new Exception("Error - Query failed : is_already_account");
  }

  $result = $stmt -> fetch();

  if(!is_null($result) || !isset($result)){
    return false;
  }

  return true;
}

function is_already_user_name(PDO $conn, string $user_name){

  $sql =
  " SELECT                 ".
  " user_name              ".
  " FROM                   ".
  " users                  ".
  " WHERE                  ". 
  " user_name = :user_name ".
  " ; ";

  $arr_prepare = [
    "user_name" => $user_name
  ];

  $stmt = $conn -> prepare($sql);

  $result_flg = $stmt->execute($arr_prepare);

  $result = $stmt->fetch();

  if(!$result_flg){
    throw new Exception("Error - Query failed : is_already_user_name");
  }

  if(!is_null($result) || !isset($result)){
    return false;
  }

  return true;
}