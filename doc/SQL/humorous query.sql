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
	'testname'
	,HEX(AES_ENCRYPT('123456789','testkey'))
);

SELECT CONVERT(AES_DECRYPT(UNHEX(PASSWORD),'testkey') USING UTF8)
FROM users
;