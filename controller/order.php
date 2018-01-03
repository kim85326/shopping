<?php 
	if (!isset($_SESSION)) {
 		session_start();
	}
	// 購物車沒有東西不能進入此頁面
	if(!$_SESSION['item']['item_pid']){
        header('location: ./mycart.php');
    }
	include_once "./database.php";

	try {
		//設定地點為台北時區
		date_default_timezone_set('Asia/Taipei');
		//取得年份/月/日 時:分:秒
		$datetime = date("Y-m-d H:i:s");		

		// 建立資料庫連線並設定編碼
		global $servername;
		global $username;
		global $password;
		global $dbname;
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	    // 把該筆訂單加入資料庫	
		$sql = "INSERT INTO `order_list` (`email`,`name`,`phone`,`address`, `shipping_method`,`total`,`datetime`) VALUES (:email, :name, :phone, :address, :shipping_method, :total, :datetime)";
		$statement = $conn->prepare($sql);
		$statement->bindValue(':email', $_POST['email']);
		$statement->bindValue(':name', $_POST['name']);
		$statement->bindValue(':phone', $_POST['phone']);
		$statement->bindValue(':address', $_POST['address']);
		$statement->bindValue(':shipping_method', "貨到付款");
		$statement->bindValue(':total', $_POST['total']);
		$statement->bindParam(':datetime', $datetime );
		$result = $statement->execute();
		$oid = $conn->lastInsertId();
		if($result){
			// 把該筆訂單的商品一一加入資料庫
			foreach ($_SESSION['item']['item_pid'] as $key => $product) {
	            $sql = "SELECT * FROM `product` WHERE `pid` = :pid ";
	            $statement2 = $conn->prepare($sql);
	            $statement2->bindValue(':pid', $_SESSION['item']['item_pid'][$key]);
	            $statement2->execute();
	            $product = $statement2->fetch(PDO::FETCH_ASSOC);
                
				$small_total = $product['price'] * $_SESSION['item']['quantity'][$key];

				$sql = "INSERT INTO `order_detail` (`oid`,`item_name`,`unit`,`price`,`quantity`, `small_total`) VALUES (:oid, :item_name, :unit, :price, :quantity, :small_total)";
				$statement3 = $conn->prepare($sql);
				$statement3->bindValue(':oid', $oid);
				$statement3->bindValue(':item_name', $product['name']);
				$statement3->bindValue(':unit', $product['unit']);
				$statement3->bindValue(':price', $product['price']);
				$statement3->bindValue(':quantity', $_SESSION['item']['quantity'][$key]);
				$statement3->bindValue(':small_total', $small_total);
				$result = $statement3->execute();
			}

			// 清除購物車的session
			//商品編號
			$_SESSION['item']['item_pid']=NULL;
			unset($_SESSION['item']['item_pid']);
			//商品數量
			$_SESSION['item']['quantity']=NULL;
			unset($_SESSION['item']['quantity']);

        	header('location: ../order_step3.php');
		} else{
			echo "<script>alert('訂單成立失敗'); location.href = '../order_step2.php';</script>";		}
	}
	catch(PDOException $e){
	    die("Connection failed: " . $e->getMessage());
	}

?>