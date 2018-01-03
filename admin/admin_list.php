<?php 
    include_once "../controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM `admin` ORDER BY `id` ASC";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $admins = $statement->fetchAll(PDO::FETCH_ASSOC);

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
        <h1 class="text-center">管理員管理</h1>
        <div class="mt-3"></div>
        <div class="mx-auto col-sm-8">
            <table class="table table-hover table-bordered table-sm text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">刪除</th>
                        <th scope="col">編號</th>
                        <th scope="col">email</th>
                        <th scope="col">姓名</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $key => $admin) : ?>
                        <tr data-id="<?= $admin['id'] ?>">
                            <td>
                                <button type="button" class="delete_admin btn btn-danger">x</button>
                            </td>
                            <th scope="row"><?= $admin['id'] ?></th>
                            <td><?= $admin['email'] ?></td>
                            <td><?= $admin['name'] ?> </td>
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
    <script src="./js/member.js"></script>
</body>
</html>