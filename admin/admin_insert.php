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
        <h1 class="text-center">新增管理員</h1>
        <div class="mt-3"></div>
        <div class="mx-auto col-md-4">
            <div class="form-group">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="a123456@gmail.com" aria-describedby="emailHelpBlock">
                    <small id="emailHelpBlock" class="form-text text-muted">
                        您的email即為日後您登入所需的帳號
                    </small>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" id="password" placeholder="******" aria-describedby="passwordHelpBlock">
                    <small id="passwordHelpBlock" class="form-text text-muted" value="111111">
                        密碼長度位於6~12位
                    </small>
                </div>
                <div class="form-group">
                    <label for="password_again">確認密碼</label>
                    <input type="password" class="form-control" id="password-again" placeholder="******" aria-describedby="password-againHelpBlock">
                    <small id="password-againHelpBlock" class="form-text text-muted" value="">
                        再次輸入您的密碼
                    </small>
                </div>
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" id="name" placeholder="王小明" value="">
                </div>
                <button id="insert_admin" type="button" class="btn btn-primary">新增管理員</button>
            </div>              
        </div>
    </div>
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/member.js"></script>
</body>
</html>