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

    $sql = "SELECT * FROM `cid2` ORDER BY `order` ASC";
    $statement2 = $conn->prepare($sql);
    $statement2->execute();
    $cid2s = $statement2->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM `cid1` ORDER BY `order` ASC";
    $statement3 = $conn->prepare($sql);
    $statement3->execute();
    $cid1s = $statement3->fetchAll(PDO::FETCH_ASSOC);

    // 根據$_GET['pid']查詢該產品的相關資料
    $sql = "SELECT * FROM `product` WHERE `pid` = :pid";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':pid', $_GET['pid']);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    // 從資料庫取出的即寫即編需要做處理才能顯示
    $detail = html_entity_decode(htmlspecialchars_decode($product['detail']));

    // 根據該筆資料的pid去找規格，以便之後填選項
    $sql = "SELECT * FROM `product_size` WHERE `pid` = :pid";
    $statement3 = $conn->prepare($sql);
    $statement3->bindValue(':pid', $product['pid']);
    $statement3->execute();
    $product_sizes = $statement3->fetchAll(PDO::FETCH_ASSOC);

    // 根據該筆資料的pid去找顏色，以便之後填選項
    $sql = "SELECT * FROM `product_color` WHERE `pid` = :pid";
    $statement4 = $conn->prepare($sql);
    $statement4->bindValue(':pid', $product['pid']);
    $statement4->execute();
    $product_colors = $statement4->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/product_detail.css">
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
                            if($product['cid2']==$cid2['cid2']) {
                                $cid2_name = $cid2['name'];
                                $cid2_cid2 = $cid2['cid2'];
                                foreach ($cid1s as $key => $cid1){
                                    if($cid2['cid1']==$cid1['cid1']){
                                        echo $cid1['name'];
                                    }
                                }
                            }
                        }?>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="./product_class.php?cid2=<?= $cid2_cid2 ?>">
                        <?= $cid2_name ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="./product_detail.php?pid=<?= $product['pid'] ?>">
                        <?= $product['name'] ?>
                    </a>
                </li>
            </ol>
        </nav>
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
                    <input id="pid" type="hidden" value="<?= $_GET['pid']?>">
                    <h1 class="text-left"><?= $product['name']?></h1>
                    <div class="products-area">
                        <div class="row">
                            <div class="col-md-5">
                                <img class="product_img" src="<?= $product['image_path']?>" alt="產品圖片">
                            </div>
                            <div class="col-md-7">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">貨品編號</label>
                                    <div class="col-sm-8">
                                        <?= $product['pid']?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">售價</label>
                                    <div class="col-sm-8">
                                        $<?= $product['price']?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="quantity" class="col-sm-4 col-form-label">購買數量</label>
                                    <div class="col-sm-8">
                                        <input id="quantity" class="form-control" type="number" value="1" min="1" max="10">
                                    </div>
                                </div>
                                <button id="add_cart" class="btn btn-primary mb-5">加入購物車</button>
                            </div>
                        </div>
                        <div class="mt-5"></div>
                        <div>
                            <h4 class="text-center">商品說明</h4>
                            <p>
                                <?= $detail?>
                            </p>
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
    <script src="./js/config.js"></script>
    <script src="./js/product_detail.js"></script>
</body>
</html>