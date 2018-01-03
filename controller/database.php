<?php
	$servername = "localhost";
	$username = "root";
	$password = "1234";
	$dbname = "champion";

	// try {
	// 	// 建立資料庫連線並設定編碼
	//     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	   
	//     $sql = "INSERT INTO `member` (`email`,`password`,`name`,`phone`,`address`) VALUES (:email, :password, :name, :phone, :address)";
	//     $statement = $conn->prepare($sql);
	//     $statement->bindValue(':email', '2@gmail.com');
	//     $statement->bindValue(':password', '1234');
	//     $statement->bindValue(':name', '肥仔');
	//     $statement->bindValue(':phone', '04111111');
	//     $statement->bindValue(':address', '豐原啊');
	//     $statement->execute();

	// 	$sql = "SELECT * FROM `member`";
	// 	$statement = $conn->prepare($sql);
	// 	$statement->execute();
	//     while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
	//     	echo $row['name'] . "<br/>";
	//     }

	    

	//     // 結束與資料庫連線
	//     $conn = null; 
	// }
	// catch(PDOException $e){
	//     die("Connection failed: " . $e->getMessage());
	// }
?>