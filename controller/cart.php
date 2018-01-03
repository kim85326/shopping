<?php 
	if (!isset($_SESSION)) {
 		session_start();
	}
	include_once "./database.php";
	header("Content-Type: application/json; charset=utf-8");

	//檢查有沒有登入會員
	if(!isset($_SESSION['id'])){
		echo json_encode(['result' => 'no_login']);
	}else {
		switch ($_POST['method']) {
	        case "add_cart":
	            add_cart();
	            break;
	        case "clear_cart":
	            clear_cart();
	            break;
	        case "delete_cart":
	            delete_cart();
	            break;
	        case "change_quantity":
	            change_quantity();
	            break;
	        default:
	            break;
    	}
	}

	function add_cart(){
		//檢查商品是否存在
		$item_exist=FALSE;
		//購物車裡面有商品
		if(isset($_SESSION['item']['item_pid'])){
			//巡迴購物車內的商品
			foreach($_SESSION['item']['item_pid']as $key=>$value){
				//購物車內的商品編號,與加入的商品編號相同
				if($_SESSION['item']['item_pid'][$key]==$_POST['pid']){
					//商品已經存在，不要再加入
					$item_exist=TRUE;
					echo json_encode(['result' => 'exist']);
				}
			}
		}
		//商品還沒存在，加入目前要購買的東西
		if(!$item_exist){
			//商品編號
			$_SESSION['item']['item_pid'][]=$_POST['pid'];
			//商品數量
			$_SESSION['item']['quantity'][]=$_POST['quantity'];
			echo json_encode(['result' => 'success_add']);
		}
	}

	function clear_cart(){
		//商品編號
		$_SESSION['item']['item_pid']=NULL;
		unset($_SESSION['item']['item_pid']);
		//商品數量
		$_SESSION['item']['quantity']=NULL;
		unset($_SESSION['item']['quantity']);
		echo json_encode(['result' => 'success_clear']);
	}

	function delete_cart(){
		//第i個商品被刪除
		$i=$_POST['key'];
		//商品編號
		$_SESSION['item']['item_pid'][$i]=NULL;
		unset($_SESSION['item']['item_pid'][$i]);
		//商品數量
		$_SESSION['item']['quantity'][$i]=NULL;
		unset($_SESSION['item']['quantity'][$i]);
		echo json_encode(['result' => 'success_delete']);
	}


	function change_quantity(){
		//第i個商品被改變
		$i=$_POST['key'];
		//商品數量
		$_SESSION['item']['quantity'][$i]=$_POST['quantity'];
		echo json_encode(['result' => 'success_change']);
	}

?>