<?php 
    include_once "../controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `order_list` ORDER BY `oid` DESC";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $order_lists = $statement->fetchAll(PDO::FETCH_ASSOC);
    $rowCount = count($order_lists);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <title>冠軍五金</title>
</head>

<body>
    <div class="mt-5"></div>
    <div class="container">
        <a href="./admin.php">返回管理員介面</a>
        <h1 class="text-center">訂單管理</h1>
        <div class="mt-3"></div>
        <div class="col-sm-12 mx-auto">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">訂單編號</th>
                        <th scope="col">訂單時間</th>
                        <th scope="col">會員email</th>
                        <th scope="col">收件人</th>
                        <th scope="col">聯絡電話</th>
                        <th scope="col">收件地址</th>
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
                                    <td><?= $order_list['email'] ?></td>
                                    <td><?= $order_list['name'] ?></td>
                                    <td><?= $order_list['phone'] ?></td>
                                    <td><?= $order_list['address'] ?></td>
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
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>