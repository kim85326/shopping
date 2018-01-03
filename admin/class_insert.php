<?php 
    include_once "../controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `cid1` ORDER BY `order` ASC";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $cid1s = $statement->fetchAll(PDO::FETCH_ASSOC);

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
        <h1 class="text-center">新增分類</h1>
        <div class="mt-3"></div>
        <div class="mx-auto">
            <h3>第一層分類</h3>
            <div class="form-group row">
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cid1">
                </div>
                <div class="col-sm-4">
                    <button id="insert_cid1" type="button" class="btn btn-primary">新增分類</button>
                </div>
            </div>              
            <hr>
            <h3>第二層分類</h3>
            <div class="form-group row">
                <div class="col-sm-4">
                    <select id="parent-cid1" class="form-control">
                        <?php foreach ($cid1s as $key => $cid1) : ?>
                        <option data-id="<?= $cid1['cid1'] ?>"> 
                            <?= $cid1['name'] ?> 
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="cid2">
                </div>
                <div class="col-sm-4">
                    <button id="insert_cid2" type="button" class="btn btn-primary">新增分類</button>
                </div>
            </div>              
        </div>
    </div>
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/class_insert.js"></script>
</body>
</html>