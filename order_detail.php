<?php 
    session_start();
    if( !isset($_SESSION['id']) ){
        header("location: ./login.php");
    }

    include_once "./controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `order_list` WHERE `oid` = :oid ";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':oid', $_GET['oid']);
    $statement->execute();
    $order_lists = $statement->fetchAll(PDO::FETCH_ASSOC);
    $rowCount = count($order_lists);
    // 如果沒有查到符合訂單oid為網址設置的oid，就代表使用者從錯誤的路徑進入此網頁
    if($rowCount <= 0){
        header("location: ./index.php");
    }else{
        $order_list = $order_lists[0];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/index.css">
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
                    <li class="nav-item">
                        <a id="logout" class="nav-link" href="#">登出</a>
                    </li>
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
                <li class="breadcrumb-item" aria-current="page"><a href="./membership.php">會員中心</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="./membership.php#v-pills-message">訂單查詢</a></li>
                <li class="breadcrumb-item active" aria-current="page">訂單詳細資料</li>
            </ol>
        </nav>
        <div class="content">
            <h3>寄送資訊</h3>
            <div class="row">
                <div class="col-md-4 border border-secondary m-3 p-3">
                    <h4>收件人資訊</h4>
                    <input type="hidden" name="email" value="<?= $_POST['email'] ?>">
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="hidden" name="name" value="<?= $_POST['name'] ?>">
                        <p><?= $order_list['name'] ?></p>
                    </div>
                    <div class="form-group">
                        <label for="phone">聯絡手機</label>
                        <input type="hidden" name="phone" value="<?= $_POST['phone'] ?>">
                        <p><?= $order_list['phone'] ?></p>
                    </div>
                    <div class="form-group">
                        <label for="address">地址</label>
                        <input type="hidden" name="address" value="<?= $_POST['address'] ?>">
                        <p><?= $order_list['address'] ?></p>
                    </div>
                </div>
                <div class="col-md-4 border border-secondary m-3 p-3">
                    <h4>運送方式</h4>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping_method_1" value="1" checked disabled>
                            貨到付款
                        </label>
                    </div>
                </div>
            </div>
            <hr/>
            <h3>訂單項目</h3>
            <div class="mt-3"></div>
            <div class="mx-auto">
                <table class="table table-hover table-bordered table-sm text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">名稱</th>
                            <th scope="col">單位</th>
                            <th scope="col">單價</th>
                            <th scope="col">數量</th>
                            <th scope="col">小計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "SELECT * FROM `order_detail` WHERE `oid` = :oid ";
                            $statement = $conn->prepare($sql);
                            $statement->bindValue(':oid', $_GET['oid']);
                            $statement->execute();
                            $order_details = $statement->fetchAll(PDO::FETCH_ASSOC);
                            //巡迴訂單內的每個商品
                            foreach ($order_details as $key => $order_detail) : ?>
                                <tr data-key="<?= $key ?>">
                                    <td><?= $order_detail['item_name'] ?></td>
                                    <td><?= $order_detail['unit'] ?></td>
                                    <td class="text-right"><?= $order_detail['price'] ?></td>
                                    <td class="text-right"><?= $order_detail['quantity'] ?></td>
                                    <td class="text-right"><?= $order_detail['small_total'] ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="text-right">
                                <td colspan="5">共<span id="count"><?= $key+1 ?></span>樣商品</td>
                            </tr>
                            <tr class="text-right">
                                <td colspan="4">運費</td>
                                <td id="shipping_fee" colspan="1">
                                    <?php $shipping_fee = 100;
                                        echo $shipping_fee; ?>
                                </td>
                            </tr>
                            <tr class="text-right">
                                <td colspan="4">總計</td>
                                <td id="total" colspan="1">
                                    <?php echo $order_list['total'] ?>
                                    <input type="hidden" name="total" value="<?= $total?>">
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
                                            
        <div class="m-9"><br></div>
        <div class="m-9"><br></div>
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
    <script src="./js/membership.js"></script>
</body>
</html>