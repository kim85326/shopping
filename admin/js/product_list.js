$(document).ready(function() {
	$("tbody").on("click", ".update" , function(){
		console.log(this);
		var tr = this.closest('tr');
		var pid = $(tr).attr('data-pid');
		window.location.href=`./product_update.php?pid=${pid}`;
	});

	$("tbody").on("click", ".delete" , function(){
		var result = confirm("確定刪除嗎？");
		var tr = this.closest('tr');

		if(result){
			var pid = $(tr).attr('data-pid');
			$.ajax({
                type: 'POST',
                url: './controller/product.php',
                data: {
                    "method" : "delete_product",
                    "pid" : pid
                },
                dataType: 'json'
            }).done(function(data) {
            	if(data.result=="success_delete"){
                	alert("刪除產品成功");
					$(tr).remove();
            	}
            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(data);
            });
		}
	});
});