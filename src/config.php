<?php

define("MY_HOST", "localhost");
define("MY_PORT", "3306");
define("MY_USER", "root");
define("MY_PASSWORD", "php504");
define("MY_DB_NAME", "humorous");
define("MY_CHARSET", "utf8mb4");

define("MY_DSN", "mysql:host=".MY_HOST.";port=".MY_PORT.";dbname=".MY_DB_NAME.";charset=".MY_CHARSET);

define("MY_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");

define("MY_ROOT_DB_LIB", MY_ROOT."lib/db_lib.php");
define("MY_ROOT_UTILITY", MY_ROOT."lib/utility.php");

define("MY_ROOT_HEADER", MY_ROOT."header.php");
define("MY_ROOT_FOOTER", MY_ROOT."footer.php");