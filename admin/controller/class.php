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
			case "insert_cid1":
				insert_cid1();
				break;
			case "insert_cid2":
				insert_cid2();
				break;
			case "update_cid1":
				update_cid1();
				break;
			case "update_cid2":
				update_cid2();
				break;
			case "delete_cid1":
				delete_cid1();
				break;
			case "delete_cid2":
				delete_cid2();
				break;	
			case "find_cid2":
				find_cid2();
				break;
			case "sort_cid1":
				sort_cid1();
				break;
			case "sort_cid2":
				sort_cid2();
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

	function insert_cid1(){
		global $conn;

		$sql = "SELECT count(*) FROM `cid1`";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $rowCount = $statement->fetchColumn();

		$sql = "INSERT INTO `cid1` (`name`,`order`) VALUES (:name, :order)";
		$statement2 = $conn->prepare($sql);
		$statement2->bindValue(':name', $_POST['name']);
		$statement2->bindValue(':order', $rowCount + 1);
		$result = $statement2->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 


	function insert_cid2(){
		global $conn;

		$sql = "SELECT count(*) FROM `cid2` WHERE `cid1` = :cid1";
        $statement = $conn->prepare($sql);
		$statement->bindValue(':cid1', $_POST['cid1']);
        $statement->execute();
        $rowCount = $statement->fetchColumn();

		$sql = "INSERT INTO `cid2` (`name`, `cid1`, `order`) VALUES (:name, :cid1, :order)";
		$statement2 = $conn->prepare($sql);
		$statement2->bindValue(':name', $_POST['name']);
		$statement2->bindValue(':cid1', $_POST['cid1']);
		$statement2->bindValue(':order', $rowCount + 1);
		$result = $statement2->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

	function update_cid1(){
	    global $conn;
		$sql = "UPDATE `cid1` SET `name` = :name WHERE `cid1` = :cid1";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':name', $_POST['new_name']);
		$statement->bindValue(':cid1', $_POST['cid1']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	}

	function update_cid2(){
	    global $conn;
		$sql = "UPDATE `cid2` SET `name` = :name WHERE `cid2` = :cid2";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':name', $_POST['new_name']);
		$statement->bindValue(':cid2', $_POST['cid2']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

	function delete_cid1(){
	    global $conn;
		$sql = "DELETE FROM `cid1` WHERE `cid1` = :cid1";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':cid1', $_POST['cid1']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

	function delete_cid2(){
	    global $conn;
		$sql = "DELETE FROM `cid2` WHERE `cid2` = :cid2 ";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':cid2', $_POST['cid2']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

	function find_cid2(){
		global $conn;
		$sql = "SELECT * FROM `cid2` WHERE `cid1` = :cid1 ORDER BY `order` ASC";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':cid1', $_POST['cid1']);
        $statement->execute();
        $cid2s = $statement->fetchAll(PDO::FETCH_ASSOC);

		if($cid2s){
	    	echo json_encode(['result' => 'success' , 'cid2' => $cid2s ]);
		} else{
	    	echo json_encode(['result' => 'null']);
	    }
	}

	function sort_cid1(){
	    global $conn;
		$sql = "UPDATE `cid1` SET `order` = :order WHERE `cid1` = :cid1";
		$statement = $conn->prepare($sql);

		foreach ($_POST['orderPair'] as $key => $orderPair) {
			$statement->bindValue(':order', $orderPair['order']);
			$statement->bindValue(':cid1', $orderPair['cid1']);
			$result = $statement->execute();
		}
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

	function sort_cid2(){
	    global $conn;
		$sql = "UPDATE `cid2` SET `order` = :order WHERE `cid2` = :cid2";
		$statement = $conn->prepare($sql);

		foreach ($_POST['orderPair'] as $key => $orderPair) {
			$statement->bindValue(':order', $orderPair['order']);
			$statement->bindValue(':cid2', $orderPair['cid2']);
			$result = $statement->execute();
		}
		if($result){
	    	echo json_encode(['result' => 'success']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	} 

?>