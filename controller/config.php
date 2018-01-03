<?php 
	include_once "./database.php";
	header("Content-Type: application/json; charset=utf-8");

	switch ($_POST['method']) {
		case "login":
			login();
			break;
		case "signup":
			signup();
			break;
		case "logout":
			logout();
			break;
		default:
			break;
	}

	function login(){
		try {
			// 建立資料庫連線並設定編碼
			global $servername;
			global $username;
			global $password;
			global $dbname;
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //去資料庫找有沒有符合帳號密碼的資料
			$sql = "SELECT * FROM `member` WHERE `email` = :email AND `password` = :password";
			$statement = $conn->prepare($sql);
			$statement->bindValue(':email', $_POST['email']);
		    $statement->bindValue(':password', $_POST['password']);
			$statement->execute();
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			//如果沒有找到的話，回傳登入失敗
			if($row == ""){
		    	echo json_encode(['result' => 'fail']);
			}else{
			//如果有找到的話，給他一個session，並且回傳登入成功
				session_start();
				$_SESSION['id'] = $row['id'];
		    	echo json_encode(['result' => 'success', 'id' => $row['id']]);
			}

		    // 結束與資料庫連線
		    $conn = null; 
		}
		catch(PDOException $e){
		    die("Connection failed: " . $e->getMessage());
		}
	} 

	function signup(){
		try {
			// 建立資料庫連線並設定編碼
			global $servername;
			global $username;
			global $password;
			global $dbname;
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    //去資料庫找此 email 有沒有辦過帳號
			$sql = "SELECT * FROM `member` WHERE `email` = :email";
			$statement = $conn->prepare($sql);
			$statement->bindValue(':email', $_POST['email']);
			$statement->execute();
			$row = $statement->fetch(PDO::FETCH_ASSOC);

			//如果沒有找到的話，就可以註冊
			if($row === false){
			
				$sql = "INSERT INTO `member` (`email`,`password`,`name`,`phone`,`address`) VALUES (:email, :password, :name, :phone, :address)";
				$statement2 = $conn->prepare($sql);
				$statement2->bindValue(':email', $_POST['email']);
				$statement2->bindValue(':password', $_POST['password']);
				$statement2->bindValue(':name', $_POST['name']);
				$statement2->bindValue(':phone', $_POST['phone']);
				$statement2->bindValue(':address', $_POST['address']);
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
		catch(PDOException $e){
		    die("Connection failed: " . $e->getMessage());
		}
	} 

	function logout(){
		session_start();
		if(isset($_SESSION['id'])){
			session_unset();
			echo json_encode(['result' => 'success']);
		} else{
			echo json_encode(['result' => 'fail']);
		}
	} 

?>