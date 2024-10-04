Create Database humorous;

USE humorous;

CREATE TABLE boards(
	board_id  	 BIGINT(30) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT
	,user_id  	 BIGINT(30) UNSIGNED 				NOT NULL 
	, title 		 VARCHAR(100) 		  					NOT NULL
	, content 	 LONGTEXT 			  					NOT NULL
	, views 		 BIGINT(30) 			  				NOT NULL
	, created_at TIMESTAMP 			  					NOT NULL DEFAULT CURRENT_TIMESTAMP()
	, updated_at TIMESTAMP 			  					NOT NULL DEFAULT CURRENT_TIMESTAMP()
	, deleted_at TIMESTAMP
);

CREATE TABLE users(
	user_id 		 BIGINT(30) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT
	,user_name 	 VARCHAR(12) 						   NOT NULL 
	,PASSWORD 	 VARCHAR(100) 						   NOT null
	, created_at TIMESTAMP 			  					NOT NULL DEFAULT CURRENT_TIMESTAMP()
	, updated_at TIMESTAMP 			  					NOT NULL DEFAULT CURRENT_TIMESTAMP()
	, deleted_at TIMESTAMP
);

ALTER TABLE boards ADD CONSTRAINT fk_boards_user_id 
FOREIGN KEY (user_id) REFERENCES users(user_id);


INSERT INTO users(
	user_name
	,PASSWORD
)
VALUES(
	'testname1'
	,HEX(AES_ENCRYPT('123456789','testkey'))
),
(
	'testname2'
	,HEX(AES_ENCRYPT('13579','testkey'))
),
(
	'testname3'
	,HEX(AES_ENCRYPT('24680','testkey'))
),
(
	'testname4'
	,HEX(AES_ENCRYPT('13456','testkey'))
),
(
	'testname5'
	,HEX(AES_ENCRYPT('12345','testkey'))
),
(
	'testname6'
	,HEX(AES_ENCRYPT('18888','testkey'))
),
(
	'testname7'
	,HEX(AES_ENCRYPT('17987','testkey'))
),
(
	'testname8'
	,HEX(AES_ENCRYPT('123123','testkey'))
),
(
	'testname9'
	,HEX(AES_ENCRYPT('88524','testkey'))
),
(
	'testname10'
	,HEX(AES_ENCRYPT('16848','testkey'))
);


SELECT CONVERT(AES_DECRYPT(UNHEX(PASSWORD),'testkey') USING UTF8)
FROM users
;

INSERT INTO boards(
	user_id
	,title
	,content
	,views
)
VALUES(
	10
	,'아무거나1'
	,'아무거나 입력했습니다1'
	,1
),
(
	2
	,'아무거나2'
	,'아무거나 입력했습니다1'
	,1
),
(
	3
	,'아무거나3'
	,'아무거나 입력했습니다1'
	,1
),
(
	4
	,'아무거나4'
	,'아무거나 입력했습니다1'
	,1
),
(
	5
	,'아무거나5'
	,'아무거나 입력했습니다1'
	,1
),
(
	6
	,'아무거나6'
	,'아무거나 입력했습니다1'
	,1
),
(
	7
	,'아무거나7'
	,'아무거나 입력했습니다1'
	,1
),
(
	8
	,'아무거나8'
	,'아무거나 입력했습니다1'
	,1
),
(
	9
	,'아무거나9'
	,'아무거나 입력했습니다1'
	,1
),
(
	10
	,'아무거나10'
	,'아무거나 입력했습니다1'
	,1
),
(
	11
	,'아무거나11'
	,'아무거나 입력했습니다1'
	,1
);

SELECT boards.board_id, boards.title, users.user_name, boards.created_at, boards.views
FROM boards
	JOIN users
	ON boards.user_id = users.user_id
ORDER BY boards.board_id DESC
LIMIT 10
OFFSET 0
;

SELECT COUNT(*)
FROM boards
WHERE deleted_at IS NULL
;

SELECT
user_name
FROM 
users
WHERE 
user_name = :user_name
;

SELECT PASSWORD
FROM users
WHERE CONVERT(AES_DECRYPT(UNHEX(PASSWORD),'testkey') USING UTF8) = '13456'
;

INSERT INTO users(
	user_name,
	password
)
VALUES(
	'dbdnjstkd369',
	HEX(AES_ENCRYPT('Wkwkdaus12!@','testkey'))
);

SELECT *
FROM users
WHERE user_name = 'dbdnjstkd369'
;

SELECT 
CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) AS pw
FROM users
WHERE user_name = 'dbdnjstkd369'
AND CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) = 'Wkwkdaus12!@'
;

INSERT INTO users(
	user_name
	,PASSWORD
)
VALUES(
	:user_name
	,:password
);

INSERT INTO boards(
		
)
VALUES(

);

SELECT boards.board_id, boards.title, users.user_name, boards.created_at, boards.views, boards.content
FROM boards
	JOIN users
	ON boards.user_id = users.user_id
	AND boards.board_id = 3
;

UPDATE boards
SET updated_at = NOW()
	,views = 2
WHERE board_id = 3
;

SELECT boards.board_id, boards.title, users.user_name, boards.created_at, boards.views, boards.content
FROM boards
	JOIN users
	ON boards.user_id = users.user_id
	AND boards.board_id = 3
;

INSERT INTO boards(
	user_id,
	title,
	content,
	views
)
VALUES(
	(SELECT user_id FROM users WHERE user_name = 'dbdnjstkd369')
	,'사랑합니다'
	,'오랑합니다'
	,1
)

UPDATE boards
SET 
title = :title
,content = :content
WHERE 
board_id = :board_id
;

SELECT 
board_id 
,title
,views
FROM
boards
ORDER BY views DESC
LIMIT 5
;

UPDATE 
boards
SET 
updated_at = NOW()
,deleted_at = NOW()
WHERE
board.id = :board.id
;

SELECT boards.board_id, boards.title, users.user_name, boards.created_at, boards.views
FROM boards
	JOIN users
	ON boards.user_id = users.user_id
	AND boards.deleted_at IS NULL
WHERE boards.title LIKE CONCAT('%', '가사','%')
ORDER BY boards.board_id DESC
LIMIT 10
OFFSET 0
;

SELECT 
CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) AS pw
FROM users
WHERE user_name = '노노노'
AND CONVERT(AES_DECRYPT(UNHEX(PASSWORD), 'testkey') USING UTF8) = 'Wkwkdaus12!@'
;

CREATE TABLE comments (
	comment_id BIGINT(30) UNSIGNED PRIMARY KEY AUTO_INCREMENT 
	,user_id BIGINT(30) UNSIGNED NOT NULL
	,board_id BIGINT(30) UNSIGNED NOT NULL
	,content VARCHAR(1000) NOT NULL
	,created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,deleted_at TIMESTAMP NULL
);

ALTER TABLE comments ADD CONSTRAINT fk_comments_user_id 
FOREIGN KEY (user_id) REFERENCES users(user_id);

ALTER TABLE comments ADD CONSTRAINT fk_comments_board_id 
FOREIGN KEY (board_id) REFERENCES boards(board_id);

SELECT 
comments.comment_id
,users.user_name
,comments.content
FROM 
comments
JOIN users
ON comments.user_id = users.user_id
JOIN boards
ON comments.user_id = boards.user_id
AND boards.board_id = 1
;

INSERT INTO comments(
	user_id
	,board_id
	,content
)
VALUES(
	:user_id
	,:board_id
	,:content
);

UPDATE 
comments
SET
updated_at = NOW()
,deleted_at = NOW()
WHERE
user_id = :user_id
;

SELECT boards.board_id, comments.comment_id, comments.user_id, comments.content, (SELECT users.user_name FROM users WHERE users.user_id = comments.user_id) AS user_name
FROM comments
JOIN boards
ON comments.board_id = boards.board_id
AND boards.board_id = 19
JOIN users
ON boards.user_id = users.user_id
ORDER BY comments.comment_id DESC
;