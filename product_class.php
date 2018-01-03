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

    $sql = "SELECT * FROM `product` WHERE `cid2` = :cid2 ORDER BY `pid` ASC";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':cid2', $_GET['cid2']);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);


    $sql = "SELECT * FROM `cid2` ORDER BY `order` ASC";
    $statement2 = $conn->prepare($sql);
    $statement2->execute();
    $cid2s = $statement2->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM `cid1` ORDER BY `order` ASC";
    $statement3 = $conn->prepare($sql);
    $statement3->execute();
    $cid1s = $statement3->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/product.css">
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
                <li class="breadcrumb-item" aria-current="page">
                        <?php foreach ($cid2s as $key => $cid2) {
                            if($_GET['cid2']==$cid2['cid2']) {
                                $cid2_name = $cid2['name'];
                                foreach ($cid1s as $key => $cid1){
                                    if($cid2['cid1']==$cid1['cid1']){
                                        echo $cid1['name'];
                                    }
                                }
                            }
                        }?>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="./product_class.php?cid2=<?= $_GET['cid2'] ?>">
                        <?= $cid2_name ?>
                    </a>
                </li>
            </ol>
        </nav>
        <h1>產品介紹</h1>

        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div id="exampleAccordion" data-children=".item">
                        <?php foreach($cid1s as $key => $cid1) : ?>
                            <div class="item">
                                <a data-toggle="collapse" data-parent="#exampleAccordion" href="#<?= $cid1['cid1'] ?>" aria-expanded="true" aria-controls="exampleAccordion1">
                                    <?= $cid1['name'] ?>
                                </a>
                                <div id="<?= $cid1['cid1'] ?>" class="collapse" role="tabpanel">
                                    <p class="mb-3">
                                        <ul>
                                            <?php foreach ($cid2s as $key => $cid2) : 
                                                if($cid2['cid1'] == $cid1['cid1']){
                                            ?>
                                                <li><a href="./product_class.php?cid2=<?= $cid2['cid2'] ?>"><?= $cid2['name'] ?></a></li>
                                            <?php } endforeach ; ?>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach ; ?>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="products-area">
                        <div class="row">
                            <?php foreach ($products as $key => $product) : ?>
                                <div class="col-md-4 col-sm-6 products">
                                    <div class="card text-center">
                                        <img class="card-img-top product_img" src="<?= $product['image_path'] ?>" alt="產品照片">
                                        <div class="card-body">
                                            <h4 class="card-title"><?= $product['name'] ?></h4>
                                            <p class="card-text">$<?= $product['price'] ?> </p>
                                            <a href="./product_detail.php?pid=<?= $product['pid'] ?>" class="btn btn-primary">我要購買</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block"><br/></div>
    </div>
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
                Copyright © 冠軍五金 All Rights Reserved. │ 網頁設計：李慈恩
            </small>
        </nav>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>
    <script src="./js/config.js"></script>
    <script src="./js/index.js"></script>
</body>
</html>