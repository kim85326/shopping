<?php 
    session_start();

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

    $sql = "SELECT * FROM `cid2` ORDER BY `order` ASC";
    $statement2 = $conn->prepare($sql);
    $statement2->execute();
    $cid2s = $statement2->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="css/class_list.css">
    <title>冠軍五金</title>
</head>

<body>
    <div class="mt-5"></div>
    <div class="container">
        <a href="./admin.php">返回管理員介面</a>
        <h1 class="text-center">分類管理</h1>
        <div class="mt-3"></div>
        <div id="class" class="mx-auto">
            <div class="column">
                <?php foreach ($cid1s as $key => $cid1) : ?>
                    <div class="portlet" data-cid1="<?= $cid1['cid1'] ?>">
                        <div class="portlet-header">
                            <span class="delete_cid1">x</span>
                            <span class="cid1_name">
                                <?= $cid1['name'] ?>
                            </span>                         
                        </div>
                        <div class="portlet-content">
                            <ul class="sortable">
                                <?php foreach ($cid2s as $key => $cid2) : 
                                    if($cid2['cid1'] == $cid1['cid1']){
                                ?>
                                    <li class="clearfix ui-state-default" data-cid2="<?= $cid2['cid2'] ?>">
                                        <span class="delete_cid2">x</span>
                                        <span class="cid2_name">
                                            <?= $cid2['name'] ?>
                                        </span>
                                    </li>
                                <?php } endforeach ;?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach ;?>
            </div> 
        </div>
    </div>
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="js/class_list.js"></script>
</body>
</html>