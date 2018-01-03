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
			case "insert_product":
				insert_product();
				break;
			case "update_product":
				update_product();
				break;
			case "update_product_size_and_color":
				update_product_size_and_color();
				break;
			case "delete_product":
				delete_product();
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

	function insert_product(){
		// 存進去的即寫即編需要做處理，不然遇到html的字會有問題
		$detail = htmlentities(htmlspecialchars($_POST['detail']));
		global $conn;
		$sql = "INSERT INTO `product` (`name`,`pid`, `price`, `unit`, `cid2`, `hot`, `image_path`, `detail` ) VALUES (:name, :pid, :price, :unit, :cid2, :hot, :image_path, :detail)";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':name', $_POST['name']);
		$statement->bindValue(':pid', $_POST['pid']);
		$statement->bindValue(':price', $_POST['price']);
		$statement->bindValue(':unit', $_POST['unit']);
		$statement->bindValue(':cid2', $_POST['cid2']);
		$statement->bindValue(':hot', $_POST['hot']);
		$statement->bindValue(':image_path', $_POST['image_path']);
		$statement->bindValue(':detail', $detail);

		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success_insert']);
		} else{
	    	echo json_encode(['result' => 'fail' ]);
	    }
	} 


	function update_product(){
		// 存進去的即寫即編需要做處理，不然遇到html的字會有問題
		$detail = htmlentities(htmlspecialchars($_POST['detail']));
		global $conn;
		$sql = "UPDATE `product` 
				SET `name` = :name,
					`price` = :price, 
					`unit` = :unit, 
					`cid2` = :cid2, 
					`hot` = :hot, 
					`image_path` = :image_path, 
					`detail` = :detail 
				WHERE `pid` = :pid";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':name', $_POST['name']);
		$statement->bindValue(':pid', $_POST['pid']);
		$statement->bindValue(':price', $_POST['price']);
		$statement->bindValue(':unit', $_POST['unit']);
		$statement->bindValue(':cid2', $_POST['cid2']);
		$statement->bindValue(':hot', $_POST['hot']);
		$statement->bindValue(':image_path', $_POST['image_path']);
		$statement->bindValue(':detail', $detail);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success_update']);
		} else{
	    	echo json_encode(['result' => 'fail' ]);
	    }
	}

	function delete_product(){

		global $conn;
		$sql = "DELETE FROM `product` WHERE `pid` = :pid ";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':pid', $_POST['pid']);
		$result = $statement->execute();
		if($result){
	    	echo json_encode(['result' => 'success_delete']);
		} else{
	    	echo json_encode(['result' => 'fail']);
	    }
	}


	function update_product_size_and_color(){

		global $conn;
		// 把此產品的原本的規格都清空
		$sql = "DELETE FROM `product_size` WHERE `pid` = :pid ";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':pid', $_POST['pid']);
		$statement->execute();

		// 把此產品的原本的顏色都清空
		$sql = "DELETE FROM `product_color` WHERE `pid` = :pid ";
		$statement2 = $conn->prepare($sql);
		$statement2->bindValue(':pid', $_POST['pid']);
		$statement2->execute();

		// 把此產品的規格一一新增進去資料庫		
		$sql = "INSERT INTO `product_size` (`pid` , `size`) VALUES ( :pid , :size)";
		$statement3 = $conn->prepare($sql);
		$statement3->bindValue(':pid', $_POST['pid']);

		foreach ($_POST['sizes_name'] as $key => $value) {
			$statement3->bindValue(':size', $value);
			$result = $statement3->execute();	
		}

		// 把此產品的顏色一一新增進去資料庫		
		$sql = "INSERT INTO `product_color` (`pid` , `color`) VALUES ( :pid , :color)";
		$statement4 = $conn->prepare($sql);
		$statement4->bindValue(':pid', $_POST['pid']);

		foreach ($_POST['colors_name'] as $key => $value) {
			$statement4->bindValue(':color', $value);
			$result = $statement4->execute();	
		}

		
		if($result){
	    	echo json_encode(['result' => 'success_update_size_and_color']);
		} else{
	    	echo json_encode(['result' => 'fail' ]);
	    }
	} 

?>