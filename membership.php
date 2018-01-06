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

    $sql = "SELECT * FROM `member` WHERE `id` = :id ";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $_SESSION['id']);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);


    $sql = "SELECT * FROM `order_list` WHERE `email` = :email ";
    $statement2 = $conn->prepare($sql);
    $statement2->bindValue(':email', $user['email']);
    $statement2->execute();
    $order_lists = $statement2->fetchAll(PDO::FETCH_ASSOC);
    $rowCount = count($order_lists);
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
                <li class="breadcrumb-item active" aria-current="page">會員中心</li>
            </ol>
        </nav>
        <div class="content">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">會員中心</a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">修改個人資料</a>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">訂單查詢</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <h3><?= $user['name']?> 會員你好</h3>
                            <p>
                                歡迎來到 會員中心<br/>
                                在此您可以進行 修改個人資料/查詢訂單 等等功能<br/>
                                如有任何問題歡迎<br/>
                                寄電子郵件至 123@gmail.com<br/>
                                或是來電查詢 09123123123<br/>
                                本公司感謝您<br/>
                            </p>
                        </div>
                        <div class="tab-pane fade col-md-8" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <h3>修改個人資料</h3>
                            <div class="card m-3">
                                <div class="card-header">
                                    修改密碼
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="password">請輸入舊密碼</label>
                                            <input type="password" class="form-control" id="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">請輸入新密碼</label>
                                            <input type="password" class="form-control" id="new_password" aria-describedby="passwordHelpBlock">
                                            <small id="passwordHelpBlock" class="form-text text-muted">
                                                密碼長度位於6~12位
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password_again">請再次確認新密碼</label>
                                            <input type="password" class="form-control" id="new_password_again" aria-describedby="password-againHelpBlock">
                                            <small id="password-againHelpBlock" class="form-text text-muted">
                                                再次輸入您的密碼
                                            </small>
                                        </div>
                                        <button id="update_password" type="button" class="btn btn-primary">更改密碼</button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card m-3">
                                <div class="card-header">
                                    修改個人資料
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" disabled value="<?= $user['email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">姓名</label>
                                            <input type="text" class="form-control" id="name" value="<?= $user['name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">聯絡手機</label>
                                            <input type="text" class="form-control" id="phone" value="<?= $user['phone'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">地址</label>
                                            <input type="text" class="form-control" id="address" value="<?= $user['address'] ?>">
                                        </div>
                                        <button id="update_profile" type="button" class="btn btn-primary">修改</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <h3>訂單查詢</h3>        
                                                        
                
                            <table class="table table-hover table-bordered table-sm text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">訂單編號</th>
                                        <th scope="col">訂單時間</th>
                                        <th scope="col">總金額</th>
                                        <th scope="col">運送方式</th>
                                        <th scope="col">詳細資料</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        // 如果有訂單 就顯示
                                        if($rowCount > 0){
                                            foreach ($order_lists as $key => $order_list) : ?>
                                                <tr data-oid="<?= $order_list['oid'] ?>">
                                                    <td><?= $order_list['oid'] ?></td>
                                                    <td><?= $order_list['datetime'] ?></td>
                                                    <td><?= $order_list['total'] ?></td>
                                                    <td><?= $order_list['shipping_method'] ?></td>
                                                    <td><a href="./order_detail.php?oid=<?= $order_list['oid'] ?>" class="btn btn-primary">詳細資料</a></td>
                                                </tr>
                                            <?php endforeach; 
                                        } else {?>
                                             <tr date-pid="null">
                                                 <td colspan="5">尚無訂單資料</td>
                                             </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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