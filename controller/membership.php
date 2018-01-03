<?php 
	include_once "./database.php";
	header("Content-Type: application/json; charset=utf-8");

	switch ($_POST['method']) {
		case "update_password":
			update_password();
			break;
		case "update_profile":
			update_profile();
			break;
		default:
			break;
	}

	function update_password(){
		try {
			// 建立資料庫連線並設定編碼
			global $servername;
			global $username;
			global $password;
			global $dbname;
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //更新密碼
			$sql = "UPDATE `member` SET `password` = :password WHERE `email` = :email";
			$statement = $conn->prepare($sql);
			$statement->bindValue(':email', $_POST['email']);
		    $statement->bindValue(':password', $_POST['password']);
			$result = $statement->execute();
			//更新失敗
			if($result == ""){
		    	echo json_encode(['result' => 'fail']);
			}else{
			//更新成功
		    	echo json_encode(['result' => 'success']);
			}
		    // 結束與資料庫連線
		    $conn = null; 
		}
		catch(PDOException $e){
		    die("Connection failed: " . $e->getMessage());
		}
	} 

	function update_profile(){
		try {
			// 建立資料庫連線並設定編碼
			global $servername;
			global $username;
			global $password;
			global $dbname;
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `member` SET `name` = :name , `phone` = :phone , `address` = :address WHERE `email` = :email ";
			$statement2 = $conn->prepare($sql);
			$statement2->bindValue(':email', $_POST['email']);
			$statement2->bindValue(':name', $_POST['name']);
			$statement2->bindValue(':phone', $_POST['phone']);
			$statement2->bindValue(':address', $_POST['address']);
			$result = $statement2->execute();
			// 結束與資料庫連線
	    	$conn = null;
			if($result){
		    	echo json_encode(['result' => 'success']);
			} else{
		    	echo json_encode(['result' => 'fail']);
			}
		}
		catch(PDOException $e){
		    die("Connection failed: " . $e->getMessage());
		}
	} 

?>