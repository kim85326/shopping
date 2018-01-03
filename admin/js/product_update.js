$(document).ready(function() {



    // 新增產品
    $("#update").click(function() {
        var name = $("#name").val();
        var pid = $("#pid").val();
        var price = $("#price").val();
        var unit = $("#unit").val();
        var cid2 = $("#cid2 option:selected").attr('data-cid2');
        var hot = $("input[name=hot]:checked").val();
        // 取得圖片路徑
        var image_path = $("#image_path").val();
        //取得即寫即編的內容
        var detail = tinymce.get('detail').getContent();
        console.log(detail);


        // 取得規格並把他們丟進陣列sizes_name
        var size = $("#size").find("li");
        var sizes_name = new Array();
        $(size).each(function(index, size) {
            var size_name = $(size).attr("data-name");
            sizes_name.push(size_name);
        });
        // console.log(sizes_name);

        // 取得顏色並把他們丟進陣列colors_name
        var colors = $("#color").find("li");
        var colors_name = new Array();
        $(colors).each(function(index, color) {
            var color_name = $(color).attr("data-name");
            colors_name.push(color_name);
        });
        // console.log(colors_name);

        if (name == "") {
            alert("請輸入產品名稱");
        } else if (pid == "") {
            alert("請輸入產品編號");
        } else if (price == "") {
            alert("請輸入價錢");
        } else if (unit == "") {
            alert("請輸入單位");
        } else if (cid2 == "") {
            alert("請選擇產品分類");
        } else if (image_path == "") {
            alert("請上傳產品圖片");
        } else {
            $.ajax({
                type: 'POST',
                url: './controller/product.php',
                data: {
                    "method" : "update_product",
                    "name" : name,
                    "pid" : pid,
                    "price" : price,
                    "unit" : unit,
                    "cid2" : cid2,
                    "hot" : hot,
                    "image_path" : image_path ,
                    "detail" : detail
                },
                dataType: 'json'
            }).done(function(data) {
            	if(data.result=="success_update"){
                    $.ajax({
                        type: 'POST',
                        url: './controller/product.php',
                        data: {
                            "method" : "update_product_size_and_color",
                            "pid" : pid,
                            "colors_name" : colors_name,  
                            "sizes_name" : sizes_name,  
                        },
                        dataType: 'json'
                    }).done(function(data) {
                        if(data.result=="success_update_size_and_color"){
                            alert("更新產品成功");
                            window.location.href="./product_list.php";
                        }
                    }).fail(function(data) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(data);
                    });
            	}
            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(data);
            });
        }


    });

});