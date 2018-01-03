<?php 
    session_start();
    if( isset($_SESSION['id']) ){
        header("location: ./index.php");
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
    <link rel="stylesheet" href="./css/login.css">
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
                        <a class="nav-link" href="./login.php">會員登入</a>
                    </li>
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
                <li class="breadcrumb-item active" aria-current="page">會員註冊</li>
            </ol>
        </nav>
        <div class="content">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="text-center">會員註冊</h1>
                    <hr/>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <form>
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
                                <div class="form-group">
                                    <label for="phone">聯絡手機</label>
                                    <input type="text" class="form-control" id="phone" placeholder="0911456789" value="">
                                </div>
                                <div class="form-group">
                                    <label for="address">地址</label>
                                    <input type="text" class="form-control" id="address" placeholder="台北市大安區基隆路四段43號" value="">
                                </div>
                                <div class="others">
                                    我已經有帳號想<a href="./login.php">登入</a>
                                </div>
                                <button id="signup" type="button" class="btn btn-primary">註冊</button>
                            </form>
                        </div>
                    </div>
                </div>
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
                Copyright © 冠軍五金 All Rights Reserved. │ 網頁設計：李慈恩
            </small>
        </nav>
    </footer>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/signup.js"></script>
</body>

</html>