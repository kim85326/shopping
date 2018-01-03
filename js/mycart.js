$(document).ready(function() {

    // 清除購物車 
    $("#clear_cart").click(function() {
        var pid = $("#pid").val();
        var quantity = $("#quantity").val();
        $.ajax({
            type: 'POST',
            url: './controller/cart.php',
            data: {
                "method" : "clear_cart",
            },
            dataType: 'json'
        }).done(function(data) {
            if(data.result=="no_login"){
                alert("請先登入會員");
                window.location.href="./login.php";
            }else if(data.result=="success_clear"){
                alert("已成功清除購物車");
                location.reload(); 
        	}
        }).fail(function(data) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(data);
        });            
    });

    // 繼續購物 
    $("#continue_buy").click(function() {
        window.location.href="./product.php";                 
    });

    // 下一步 
    $("#next_step").click(function() {
        window.location.href="./order_step1.php"
    });


    // 刪除購物車商品
    $("tbody").on("click", ".delete_item" , function(){
        var result = confirm("確定刪除嗎？");
        var tr = this.closest('tr');

        if(result){
            var key = $(tr).attr('data-key');
            $.ajax({
                type: 'POST',
                url: './controller/cart.php',
                data: {
                    "method" : "delete_cart",
                    "key" : key
                },
                dataType: 'json'
            }).done(function(data) {
                if(data.result=="success_delete"){
                    // 重新計算數量和總價
                    count = $("#count").html();
                    count -= 1;
                    $("#count").html(count);
                    small_total = $(`tr[data-key=${key}] .small_total`);
                    pre_small_total = small_total.html();
                    total = $("#total").html() - pre_small_total;
                    $("#total").html(total);
                    // 移除該筆商品
                    $(tr).remove();
                }
            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(data);
            });
        }
    });

    // 更改購物車數量
    $("tbody").on("change", ".quantity" , function(){
        var quantity = $(this).val();
        // console.log(quantity);
        var key = $(this.closest('tr')).attr('data-key');
        // console.log(key);

        $.ajax({
            type: 'POST',
            url: './controller/cart.php',
            data: {
                "method" : "change_quantity",
                "key" : key,
                "quantity" : quantity
            },
            dataType: 'json'
        }).done(function(data) {
            if(data.result=="success_change"){
                // 成功就更改小計和總價
                price = $(`tr[data-key=${key}] .price`).html();
                small_total = $(`tr[data-key=${key}] .small_total`);
                pre_small_total = small_total.html();
                new_small_total = quantity * price;
                small_total.html(new_small_total);
                total = $("#total").html() - pre_small_total + new_small_total;
                $("#total").html(total);
            }
        }).fail(function(data) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(data);
        });
        
    });



});