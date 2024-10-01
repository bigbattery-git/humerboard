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

