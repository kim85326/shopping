<?php 
    session_start();	
    include_once "./controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/mycart.css">
    <title>冠軍五金</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./mycart.php">購物車</a>
                    </li>
                    <?php 
                        if( !isset($_SESSION['id']) ){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">會員登入</a>
                    </li>
                    <?php } else { ?>
                    <li class="nav-item">
                        <a id="logout" class="nav-link" href="#">登出</a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <div class="logo">
            <a href="./index.php">
                <div>假設有一間冠軍五金的logo</div>
                <img src="img/logo.png" width="200" height="200" alt="">
            </a>
        </div>
        <nav class="nav nav-pills nav-fill main-nav">
            <a class="nav-item nav-link" href="./about.php">關於我們</a>
            <a class="nav-item nav-link" href="./product.php">商品介紹</a>
            <a class="nav-item nav-link" href="./membership.php">會員中心</a>
        </nav>
    </header>
    
    <div class="container">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">首頁</a></li>
                <li class="breadcrumb-item active" aria-current="page">訂單成立完成</li>
            </ol>
        </nav>
        <div class="content text-center">
	        <h1>您的訂單已經成立</h1>
        	<div class="m-2"><br></div>
	        <p>
	        	感謝您在本店購物！您的訂單已經提交成功!
	        </p>
	        現在您可以選擇 <a href="./product.php">選擇繼續購物</a> ｜ <a href="./membership.php">會員中心</a>
    	</div>
    </div>
    <div class="m-9"><br></div>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./about.php">關於我們</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./product.php">商品介紹</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./membership.php">會員中心</a>
                </li>
            </ul>
            <small class="navbar-text">
                網頁設計：李慈恩
            </small>
        </nav>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/config.js"></script>
    <script src="./js/order_step1.js"></script>
</body>
</html>