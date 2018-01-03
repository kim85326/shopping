$(document).ready(function() {


    // 新增至購物車 
    $("#add_cart").click(function() {
        var pid = $("#pid").val();
        var quantity = $("#quantity").val();
        
        $.ajax({
            type: 'POST',
            url: './controller/cart.php',
            data: {
                "method" : "add_cart",
                "pid" : pid,
                "quantity" : quantity
            },
            dataType: 'json'
        }).done(function(data) {
            if(data.result=="no_login"){
                alert("請先登入會員");
                window.location.href="./login.php";
            }else if(data.result=="exist"){
                alert("此商品已經存在購物車");
                window.location.href="./mycart.php";
            }else if(data.result=="success_add"){
                alert("已成功加入購物車");
                history.back();
        	}
        }).fail(function(data) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(data);
        });            
    });

});