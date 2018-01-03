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
    <link rel="stylesheet" href="./css/product_edit.css">
    <!-- 匯入並初始化即寫即編tinymce -->
    <script src="./js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            language:'zh_TW',
            selector:'#detail',
            height:'460',
            plugins: [
            "jbimages advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools"
            ],
            toolbar1: "insertfile undo redo | formatselect fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table hr pagebreak blockquote",
            toolbar2: "bold italic underline strikethrough subscript superscript | forecolor backcolor charmap emoticons | link unlink media | cut copy paste | insertdatetime fullscreen code | jbimages",
            menubar: false,
            image_advtab: true,
        });
    </script>
    <title>冠軍五金</title>
</head>

<body>
    <div class="mt-5"></div>
    <div class="container">
        <a href="./admin.php">返回管理員介面</a>
        <h1 class="text-center">新增產品</h1>
        <div class="mt-3"></div>
        <div class="mx-auto">
                <form action="./controller/product.php" method="post">                
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">產品名稱</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pid">產品編號</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pid">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price">價格</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="price">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="unit">單位</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="unit">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">產品分類</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="cid1">
                            <?php foreach ($cid1s as $key => $cid1) : 
                                if($key == 0){
                                    $parent_cid1 = $cid1['cid1'];
                                }
                            ?>
                            <option data-cid1="<?= $cid1['cid1'] ?>"> 
                                <?= $cid1['name'] ?> 
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="cid2">
                            <?php 
                                $sql = "SELECT * FROM `cid2` WHERE `cid1` = :cid1 ORDER BY `order` ASC";
                                $statement2 = $conn->prepare($sql);
                                $statement2->bindValue(':cid1', $parent_cid1);
                                $statement2->execute();
                                $cid2s = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($cid2s as $key => $cid2) : 
                            ?>
                            <option data-cid2="<?= $cid2['cid2'] ?>"> 
                                <?= $cid2['name'] ?> 
                            </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-legend col-sm-2">是否為熱門商品</legend>
                        <div class="col-sm-10 row">
                            <div class="form-check col-sm-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="hot" value="1" checked>
                                    是
                                </label>
                            </div>
                            <div class="form-check col-sm-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="hot" value="0">
                                    否
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-4 row">
                        <ul id="color" class="list-group options">
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="upload_image">產品圖片</label>
                    <div class="col-sm-4">
                        <input id="upload_image" type="file" accept="image/gif, image/jpeg, image/png">
                        <input id="image_path" type="hidden" value="">                        
                        <div id="show_image"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="detail">詳細內容</label>
                    <textarea id="detail"></textarea>
                </div>
                <button id="insert" type="button" class="btn btn-primary">新增</button>
            </form>
        </div>
        <!-- <form action="./controller/product.php" method="post">
                    　<textarea name="detail" id="detail"></textarea>
                    <button type="submit">送出</button>
        </form> --> 
    </div>
    

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="./js/product_edit.js"></script>
    <script src="./js/product_insert.js"></script>
</body>
</html>