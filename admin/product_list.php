<?php 
    include_once "../controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `product` ORDER BY `pid` ASC";
    $statement = $conn->prepare($sql);
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
    <link rel="stylesheet" href="css/product_list.css">
    <title>冠軍五金</title>
</head>

<body>
    <div class="mt-5"></div>
    <div class="container">
        <a href="./admin.php">返回管理員介面</a>
        <h1 class="text-center">產品管理</h1>
        <div class="mt-3"></div>
        <div class="mx-auto">
            <table class="table table-hover table-bordered table-sm text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">編號</th>
                        <th scope="col">照片</th>
                        <th scope="col">名稱</th>
                        <th scope="col">價錢</th>
                        <th scope="col">單位</th>
                        <th scope="col">分類</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $key => $product) : ?>
                    <tr data-pid="<?= $product['pid'] ?>">
                        <th scope="row"><?= $product['pid'] ?></th>
                        <td><img class="product_img" src="../<?= $product['image_path'] ?>" alt="產品照片"></td>
                        <td><?= $product['name'] ?></td>
                        <td>$<?= $product['price'] ?> </td>
                        <td><?= $product['unit'] ?></td>
    
                        <?php foreach ($cid2s as $key => $cid2) : 
                            if($cid2['cid2']==$product['cid2']){
                        ?>
                            <td><?= $cid2['name'] ?></td>
                        <?php } endforeach ?>
                        <td>
                            <button type="button" class="update btn btn-warning">更新</button>
                            <button type="button" class="delete btn btn-danger">刪除</button>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/product_list.js"></script>
</body>
</html>