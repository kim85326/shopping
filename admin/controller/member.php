<?php 
	include_once "../../controller/database.php";
	header("Content-Type: application/json; charset=utf-8");

	try {
		// 建立資料庫連線並設定編碼
		global $servername;
		global $username;
		global $password;
		global $dbname;
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    switch ($_POST['method']) {
			case "delete_member":
				delete_member();
				break;
			case "delete_admin":
				delete_admin();
				break;
			case "insert_admin":
				insert_admin();
				break;
			default:
				break;
		}
		// 結束與資料庫連線
		$conn = null;
	}
	catch(PDOException $e){
	    // die("Connection failed: " . $e->getMessage());
	    echo json_encode(['result' => 'fail' , 'reason' => $e->getMessage()]);
	}

	

	function delete_member(){
		global $conn;
		$sql = "DELETE FROM `member` WHERE `id` = :id ";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':id', $_POST['id']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success_delete']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	}

	function delete_admin(){
		global $conn;
		$sql = "DELETE FROM `admin` WHERE `id` = :id ";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':id', $_POST['id']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success_delete']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	}

	function insert_admin(){
			global $conn;
		    //去資料庫找此 email 有沒有辦過帳號
			$sql = "SELECT * FROM `admin` WHERE `email` = :email";
			$statement = $conn->prepare($sql);
			$statement->bindValue(':email', $_POST['email']);
			$statement->execute();
			$row = $statement->fetch(PDO::FETCH_ASSOC);

			//如果沒有找到的話，就可以註冊
			if($row === false){
		
				$sql = "INSERT INTO `admin` (`email`,`password`,`name`) VALUES (:email, :password, :name)";
				$statement2 = $conn->prepare($sql);
				$statement2->bindValue(':email', $_POST['email']);
				$statement2->bindValue(':password', $_POST['password']);
				$statement2->bindValue(':name', $_POST['name']);
				$result = $statement2->execute();
				// 結束與資料庫連線
				$id = $conn->lastInsertId();
		    	$conn = null;
				if($result){
					session_start();
					$_SESSION['id'] = $id;
			    	echo json_encode(['result' => 'success']);
				} else{
			    	echo json_encode(['result' => 'fail']);
				}
			}else{
				// 結束與資料庫連線
			    $conn = null;
				//如果有找到的話，回傳登入email已經註冊過了
		    	echo json_encode(['result' => 'email']);
			}
	}

?>