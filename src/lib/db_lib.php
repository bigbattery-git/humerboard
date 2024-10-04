<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/config.php");

/**
 * PDO 클래스 받아오기
 */
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
  " AND boards.deleted_at IS NULL  ".
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

function get_board_list_search(PDO $conn, array $arr_param){

  $sql = 
  " SELECT                                     ".
  " boards.board_id                            ".
  " ,boards.title                              ".
  " ,users.user_name                           ".
  " ,boards.created_at                         ".
  " ,boards.views                              ".
  " FROM boards                                ".
  " JOIN users                                 ".
  " ON boards.user_id = users.user_id          ".
  " AND boards.deleted_at IS NULL              ".
  " WHERE                                      ". 
  " boards.title LIKE CONCAT('%', :search,'%') ".
  " ORDER BY boards.board_id DESC              ".
  " LIMIT :limit                               ".
  " OFFSET :offset                             ".
  " ;                                          "
  ;

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);

  if(!$result_flg){
    throw new Exception("Error - Query failed : get_board_list_search");
  }

  $result = $stmt -> fetchAll();

  return $result;
}

function get_board_list_mostview(PDO $conn){
  $sql =
  " SELECT ". 
  " board_id ".
  " ,title ".
  " ,views ".
  " FROM ".
  " boards ".
  " ORDER BY views DESC ".
  " LIMIT 5 ".
  " ; "
  ;

  $stmt = $conn -> query($sql);

  $result = $stmt -> fetchAll();

  return $result;
}

/**
 * boards 테이블 레코드 수 받아오기
 */

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

/**
 * 계정이 있는지 없는지 확인하기
 * @param $user_name = 아이디 입력 정보
 * @param $user_password = 비밀번호 입력 정보 
 */

function is_already_account(PDO $conn, string $user_name, string $user_password, int &$user_id = -1){

  // 아이디 있는지 확인, 비밀번호 있는지 확인
  
  if(!is_already_user_name($conn, $user_name)){
    throw new Exception("아이디가 존재하지 않습니다.");
    return false;
  }

  $sql = 
  " SELECT ".
  " user_id ".
  " ,CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) AS pw ".
  " FROM users ".
  " WHERE user_name = :user_name ".
  " AND CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) = :pw ".
  " ; "
  ;

  $arr_prepare = [
    "user_name" => $user_name,
    "pw" => $user_password
  ];

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_prepare);

  if(!$result_flg){
    throw new Exception("Error - Query failed : is_already_account");
  }

  $result = $stmt -> fetch();

  if($result["pw"] !== $user_password){
    throw new Exception("계정이 없거나 비밀번호가 맞지 않습니다.");
    return false;
  }

  $user_id = $result["user_id"];

  return true;
}

/**
 * 아이디 있는지 확인하기 
 * @param $user_name = 유저 이름 정보
 */

function is_already_user_name(PDO $conn, string $user_name){

  $sql =
  " SELECT                 ".
  " user_name as id        ".
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

  if($result["id"] !== $user_name){
    return false;
  }

  return true;
}

/**
 * 회원가입 하기
 * @param $user_name = 회원가입 시 아이디 정보 
 * @param $user_password = 회원가입 시 비밀번호 정보
 */

function join_membership(PDO $conn, string $user_name, string $user_password){

  if(is_already_user_name($conn, $user_name)){
    throw new Exception("이미 존재하는 아이디입니다.");
  }

  $sql =
  " INSERT INTO users( ".
  " user_name,         ".
  " password           ".
  " )                  ".
  " VALUES(            ".
  " :user_name         ".
  " ,HEX(AES_ENCRYPT(:user_password,'testkey'))".
  " ); "
  ;

  $arr_prepare = [
    "user_name" => $user_name,
    "user_password" => $user_password
  ];

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt->execute($arr_prepare);
  $result_cnt = $stmt->rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : join_membership");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : join_membership");
  }
}

/**
 * 게시판에서 게시글 볼 때 정보 받아오기
 * 
 * @param $board_id = 게시글 번호
 */

function get_board_detail(PDO $conn, array $arr_param){

  $sql = 
  " SELECT                            ".
  " boards.board_id,                  ".
  " boards.title,                     ".
  " boards.user_id,                   ".
  " users.user_name,                  ". 
  " boards.created_at,                ". 
  " boards.views,                     ".
  " boards.content                    ".
  " FROM boards                       ".
	" JOIN users                        ".
	" ON boards.user_id = users.user_id ".
	" AND boards.board_id = :board_id   ".
  " ;                                 "
  ;

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);

  if(!$result_flg){
    throw new Exception("Error - Query failed : get_board_detail");
  }

  return $stmt->fetch();
}

/**
 * 조회수 1씩 증가하기
 * 
 * @param $board_id = 조회수 늘릴 게시글 번호
 * @param $views = 적용할 조회수 (1씩 자동증가 아님)
 */

function add_views(PDO $conn, int $board_id, int $views){

  $sql = 
  " UPDATE boards          ".
  " SET updated_at = NOW() ".
	" ,views = :views        ".
  " WHERE board_id =       ".
  " :board_id              ".
  " ;                      "
  ;

  $arr_prepare = [
    "views"    => $views,
    "board_id" => $board_id
  ];

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_prepare);
  $result_cnt = $stmt -> rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : add_views");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : add_views");
  }
}

/**
 * 게시글 작성하기
 * 
 * @param $arr_param = :user_name, :title, :content
 */

function insert_board(PDO $conn, array $arr_param){

  $sql = 
  " INSERT INTO boards(                                      ".
  " user_id,                                                 ".
  " title,                                                   ".
  " content,                                                 ".
  " views                                                    ".
  " )                                                        ".
  " VALUES(                                                  ".
  " :user_id                                                 ".
  " ,:title                                                  ".
  " ,:content                                                ".
  " ,1                                                       ".
  " )                                                        ".
  " ;                                                        "
  ;

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);
  $result_cnt = $stmt -> rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : insert_board");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : insert_board");
  }

  return $conn -> lastInsertId();
}

/**
 * 게시글 수정하기
 * 
 * @param $arr_param = :title, :content, :board_id
 */

function update_board(PDO $conn, array $arr_param){

  $sql =
  " UPDATE boards        ".
  " SET                  ".
  " title = :title       ".
  " ,content = :content  ".
  " ,updated_at = NOW()  ".
  " WHERE                ". 
  " board_id = :board_id ".
  " ;                    "
  ;

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);
  $result_cnt = $stmt -> rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : update_board");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : update_board");
  }
}

function delete_board(PDO $conn, int $board_id){

  $sql =
  " UPDATE               ".
  " boards               ".
  " SET                  ". 
  " updated_at = NOW()   ".
  " ,deleted_at = NOW()  ".
  " WHERE                ".
  " board_id = :board_id ".
  " ; "
  ;

  $arr_prepare = [
    "board_id" => $board_id
  ];

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_prepare);
  $result_cnt = $stmt -> rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : delete_board");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : delete_board");
  }
} 

function get_board_comment(PDO $conn, array | int $arr_param){

  $sql = 
  " SELECT ".
  " comments.comment_id AS comment_id ".
  " ,users.user_name AS user_name ".
  " ,comments.user_id AS user_id ".
  " ,comments.content AS content ".
  " FROM ".
  " comments ".
  " JOIN users ".
  " ON comments.user_id = users.user_id ".
  " JOIN boards ".
  " ON comments.user_id = boards.user_id ".
  " AND boards.board_id = :board_id ".
  " ORDER BY comments.comment_id desc ".
  " ; "
  ;

  $arr_prepare = null;
  if(gettype($arr_param) === "intiger"){
    $arr_prepare = [
      "board_id" => $arr_param
    ];
  }
  else{
    $arr_prepare = $arr_param;
  }

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_prepare);

  if(!$result_flg){
    throw new Exception("Error - Query failed : get_board_detail");
  }

  return $stmt->fetchAll();
}

function insert_comment(PDO $conn, array $arr_param){
  $sql = 
  " INSERT INTO comments( ".
  " user_id ".
  " ,board_id ".
  " ,content ".
  " ) ".
  " VALUES( ".
  " :user_id ".
  " ,:board_id ".
  " ,:content ".
  " ); "
  ;

  $stmt = $conn -> prepare($sql);
  $result_flg = $stmt -> execute($arr_param);
  $result_cnt = $stmt -> rowCount();

  if(!$result_flg){
    throw new Exception("Error - Query failed : insert_comment");
  }

  if($result_cnt > 1){
    throw new Exception("Error - Query count over : insert_comment");
  }
}