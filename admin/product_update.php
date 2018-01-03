<?php 
    include_once "../controller/database.php";
    // 建立資料庫連線並設定編碼
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 根據$_GET['pid']查詢該產品的相關資料
    $sql = "SELECT * FROM `product` WHERE `pid` = :pid";
	$statement = $conn->prepare($sql);
	$statement->bindValue(':pid', $_GET['pid']);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    // 從資料庫取出的即寫即編需要做處理才能顯示
    $detail = html_entity_decode(htmlspecialchars_decode($product['detail']));

    // 根據該筆資料的cid2去找cid1是誰，以便之後填選項
    $sql = "SELECT * FROM `cid2` WHERE `cid2` = :cid2";
    $statement2 = $conn->prepare($sql);
    $statement2->bindValue(':cid2', $product['cid2']);
    $statement2->execute();
    $product_cid2 = $statement2->fetch(PDO::FETCH_ASSOC);

    // 根據該筆資料的cid2去找規格，以便之後填選項
    $sql = "SELECT * FROM `product_size` WHERE `pid` = :pid";
    $statement3 = $conn->prepare($sql);
    $statement3->bindValue(':pid', $product['pid']);
    $statement3->execute();
    $product_sizes = $statement3->fetchAll(PDO::FETCH_ASSOC);

	// 根據該筆資料的cid2去找顏色，以便之後填選項
    $sql = "SELECT * FROM `product_color` WHERE `pid` = :pid";
    $statement4 = $conn->prepare($sql);
    $statement4->bindValue(':pid', $product['pid']);
    $statement4->execute();
    $product_colors = $statement4->fetchAll(PDO::FETCH_ASSOC);
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
        <a href="./product_list.php">返回產品列表介面</a>
        <h1 class="text-center">更新產品</h1>
        <div class="mt-3"></div>
        <div class="mx-auto">
                <form action="./controller/product.php" method="post">                
                    <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">產品名稱</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" value="<?= $product['name']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pid">產品編號</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="pid" value="<?= $product['pid']?>" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price">價格</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="price" value="<?= $product['price']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="unit">單位</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="unit" value="<?= $product['unit']?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">產品分類</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="cid1">
                        	<?php 
                            $sql = "SELECT * FROM `cid1` ORDER BY `order` ASC";
						    $statement5 = $conn->prepare($sql);
						    $statement5->execute();
						    $cid1s = $statement5->fetchAll(PDO::FETCH_ASSOC);
                        	foreach ($cid1s as $key => $cid1) : 
                                if($cid1['cid1'] == $product_cid2['cid1']){ ?>
                                    <option selected data-cid1="<?= $cid1['cid1'] ?>"> 
		                                <?= $cid1['name'] ?> 
		                            </option>
                                <?php } else { ?>
								<option data-cid1="<?= $cid1['cid1'] ?>"> 
                           	    	<?= $cid1['name'] ?> 
                            	</option>
                        	<?php } endforeach ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="cid2">
                            <?php 
                            $sql = "SELECT * FROM `cid2` ORDER BY `order` ASC";
					    	$statement6 = $conn->prepare($sql);
					    	$statement6->execute();
					    	$cid2s = $statement6->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($cid2s as $key => $cid2) : 
                                if($cid2['cid2'] == $product_cid2['cid2']){ ?>
                                    <option selected data-cid2="<?= $cid2['cid2'] ?>"> 
		                                <?= $cid2['name'] ?> 
		                            </option>
                                <?php } else { ?>
								<option data-cid1="<?= $cid2['cid2'] ?>"> 
                           	    	<?= $cid2['name'] ?> 
                            	</option>
                        	<?php } endforeach ?>
                        </select>
                    </div>
                </div>
                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-legend col-sm-2">是否為熱門商品</legend>
                        <div class="col-sm-10 row">
                            <div class="form-check col-sm-1">
                                <label class="form-check-label">
                                	<?php if($product['hot'] == 1){ ?>
                                    	<input class="form-check-input" type="radio" name="hot" value="1" checked>
                                    <?php } else { ?>
										<input class="form-check-input" type="radio" name="hot" value="1">
                                    <?php } ?>
                                    是
                                </label>
                            </div>
                            <div class="form-check col-sm-1">
                                <label class="form-check-label">
                                	<?php if($product['hot'] == 0){ ?>
                                    	<input class="form-check-input" type="radio" name="hot" value="0" checked>
                                    <?php } else { ?>
										<input class="form-check-input" type="radio" name="hot" value="0">
                                    <?php } ?>
                                    否
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="new_size">規格</label>
                    <div class="col-sm-4 row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="new_size">
                        </div>
                        <div class="col-sm-4">
                            <button id="add_size" type="button" class="btn btn-primary">新增規格選項</button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-4 row">
                        <ul id="size" class="list-group options">
                        	<?php foreach ($product_sizes as $key => $product_size) : ?>
                        		<li data-name="<?= $product_size['size'] ?>"> <?= $product_size['size'] ?> <a class="delete_option" href="#">x</a></li>
                        	<?php endforeach?>
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="new_color">顏色</label>
                    <div class="col-sm-4 row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="new_color">
                        </div>
                        <div class="col-sm-4">
                            <button id="add_color" type="button" class="btn btn-primary">新增顏色選項</button>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-4 row">
                        <ul id="color" class="list-group options">
                        	<?php foreach ($product_colors as $key => $product_color) : ?>
                        		<li data-name="<?= $product_color['color'] ?>"> <?= $product_color['color'] ?> <a class="delete_option" href="#">x</a></li>
                        	<?php endforeach?>
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="upload_image">產品圖片</label>
                    <div class="col-sm-4">
                        <input id="upload_image" class="update_image" type="file" accept="image/gif, image/jpeg, image/png">
                        <input id="image_path" type="hidden" value="<?= $product['image_path']?>">                        
                        <div id="show_image">
                        	<img src="../<?= $product['image_path']?>" alt="產品圖片">
                        	<a class='delete_option' href="javascript:void(0);"> x </a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="detail">詳細內容</label>
                    <textarea id="detail"><?= $detail?></textarea>
                </div>
                <button id="update" type="button" class="btn btn-primary">更新</button>
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
    <script src="./js/product_update.js"></script>
</body>
</html>