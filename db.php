<?php
	define("host_name",  "localhost");
	define("db_user",  "root");
	define("db_password",  "");
	define("db_name",  "test_zubko_artem");
	define("table_name",  "people");

	$conn=Mysqli_connect(host_name, db_user, db_password, db_name) or die("Не удалось подключиться к базе данных");
	mysqli_query ($conn, "ST NAMES UTF8");
	session_start();
	mysqli_query ($conn, "CREATE TABLE IF NOT EXISTS ".table_name." (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100), second_name VARCHAR(100), mail VARCHAR(100))");



?>