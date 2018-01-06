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
                <li class="breadcrumb-item active" aria-current="page"><a href="./mycart.php">購物車</a></li>
            </ol>
        </nav>
        <h1>購物車</h1>

        <div class="container">
           <div class="mt-3"></div>
            <div class="mx-auto">
                <table class="table table-hover table-bordered table-sm text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">刪除</th>
                            <th scope="col">編號</th>
                            <th scope="col">圖片</th>
                            <th scope="col">名稱</th>
                            <th scope="col">單位</th>
                            <th scope="col">單價</th>
                            <th scope="col">數量</th>
                            <th scope="col">小計</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // 如果購物車裡有東西
                            if(isset($_SESSION['item']['item_pid'])){
                                $count = 0;
                                $total = 0;
                                //巡迴購物車內的每個商品
                                foreach ($_SESSION['item']['item_pid'] as $key => $product) : 
                                $sql = "SELECT * FROM `product` WHERE `pid` = :pid ";
                                $statement = $conn->prepare($sql);
                                $statement->bindValue(':pid', $_SESSION['item']['item_pid'][$key]);
                                $statement->execute();
                                $product = $statement->fetch(PDO::FETCH_ASSOC);
                                ?>
                                    <tr data-key="<?= $key ?>">
                                        <td><button class="delete_item btn btn-danger">x</button></td>
                                        <td><?= $product['pid'] ?></td>
                                        <td><img class="product_img" src="<?= $product['image_path'] ?>" alt="圖片"></td>
                                        <td><?= $product['name'] ?></td>
                                        <td><?= $product['unit'] ?></td>
                                        <td class="price text-right"><?= $product['price'] ?></td>
                                        <td><input class="quantity form-control text-right" type="number" value="<?= $_SESSION['item']['quantity'][$key] ?>" min="1"></td>
                                        <td class="small_total text-right"><?php $small_total =  $_SESSION['item']['quantity'][$key]*$product['price'];
                                            $count += 1; 
                                            $total += $small_total;
                                            echo $small_total?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="text-right">
                                    <td colspan="8">共<span id="count"><?= $count ?></span>樣商品</td>
                                </tr>
                                <tr class="text-right">
                                    <td colspan="7">總計</td>
                                    <td id="total" colspan="1"><?= $total ?></td>
                                </tr>
                            <? } else { ?>
                                     <tr date-pid="null">
                                         <td colspan="8">購物車內尚無商品</td>
                                     </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button id="continue_buy" class="btn btn-primary">繼續購物</button>
                <button id="clear_cart" class="btn btn-primary">清空購物車</button>
                <button id="next_step" class="btn btn-primary">確定購買</button>
            </div>
        </div>
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
                網頁設計：李慈恩
            </small>
        </nav>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/config.js"></script>
    <script src="./js/mycart.js"></script>
</body>
</html>