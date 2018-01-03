$(document).ready(function() {

    //選完cid1，要顯示cid1底下的cid2
    $("#cid1").change(function() {
        var cid1 = $("#cid1 option:selected").attr('data-cid1');
        // console.log(cid1);
        $("#cid2").html("");
        var result;
        $.post('./controller/class.php', { method: 'find_cid2', cid1: cid1 }, function(data, textStatus, xhr) {
            if (data.result == "success") {
                $(data.cid2).each(function(index, value) {
                    result = `<option data-cid2=${value.cid2}>${value.name}</option>`;
                    $("#cid2").append(result);
                });
            } else {
                result = `<option>-</option>`;
                $("#cid2").append(result);
            }
        });
    });

    // 新增規格的選項
    $("#add_size").click(function() {
    	if($("#new_size").val()!=""){
    		var new_size = $("#new_size").val();
	        $("#new_size").val("");
	        var temp = `<li data-name="${new_size}"> ${new_size} <a class="delete_option" href="#">x</a></li>`;
	        $("#size").append(temp);
    	}
    });

    // 新增顏色的選項
    $("#add_color").click(function() {
    	if($("#new_color").val()!=""){
			var new_color = $("#new_color").val();
        	$("#new_color").val("");
        	var temp = `<li data-name="${new_color}"> ${new_color} <a class="delete_option" href="#">x</a></li>`;
        	$("#color").append(temp);
    	}
	});

    // 刪除規格、顏色的選項
    $(".options").on("click", ".delete_option", function(event) {
        event.preventDefault();
        var result = confirm("確定刪除嗎？");
        if (result) {
            this.closest('li').remove();
        }
    });

    // 上傳產品圖片
    // 上傳圖片的input更動的時候
    $("#upload_image").on("change", function() {
        //產生 FormData 物件
        var file_data = new FormData(),
            file_name = $(this)[0].files[0]['name'],
            save_path = "files/product/";

        //在圖片區塊，顯示loading
        $("#show_image").html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

        //FormData 新增剛剛選擇的檔案
        file_data.append("method", "upload_product_img");
        file_data.append("file", $(this)[0].files[0]);
        file_data.append("save_path", save_path);
        //透過ajax傳資料
        $.ajax({
            type: 'POST',
            url: './controller/file.php',
            data: file_data,
            cache: false, //因為只有上傳檔案，所以不要暫存
            processData: false, //因為只有上傳檔案，所以不要處理表單資訊
            contentType: false, //送過去的內容，由 FormData 產生了，所以設定false
            dataType: 'html'
        }).done(function(data) {
            console.log(data);
            //上傳成功
            if (data == "success_upload") {
                //將檔案插入
                $("#show_image").html(`<img src='../${save_path}${file_name}'><a class='delete_option' href="javascript:void(0);"> x </a>`);
                //給予 #image_path 值，等等存檔時會用
                $("#image_path").val(save_path + file_name);
                $("#upload_image").hide();
            } else {
                //警告回傳的訊息
                alert(data);
            }
        }).fail(function(data) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
        });
    });

    // 刪除上傳的產品圖片
    $("#show_image").on("click", ".delete_option", function(event) {
        var result = confirm("確定刪除嗎？");
        if (result) {
            //如果有圖片路徑，就刪除該檔案
            if ($("#image_path").val() != '') {
                //透過ajax刪除
                $.ajax({
                    type: 'POST',
                    url: './controller/file.php',
                    data: {
                        "method": "delete_product_img",
                        "file": $("#image_path").val()
                    },
                    dataType: 'html'
                }).done(function(data) {
                    console.log(data);
                    //刪除上傳成功
                    if (data == "success_delete") {
                        $("#show_image").html("");
                        $("#image_path").val("");
                        $("#upload_image").val("");
                        $("#upload_image").show();
                    } else {
                        //警告回傳的訊息
                        alert(data);
                    }
                }).fail(function(data) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            } else {
                alert("無檔案可以刪除");
            }
        }
    });

   

});