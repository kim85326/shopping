$(document).ready(function() {
	
	$("tbody").on("click", ".delete_member" , function(){
		var result = confirm("確定刪除嗎？");
		var tr = this.closest('tr');
		if(result){
			var id = $(tr).attr('data-id');
			$.ajax({
                type: 'POST',
                url: './controller/member.php',
                data: {
                    "method" : "delete_member",
                    "id" : id
                },
                dataType: 'json'
            }).done(function(data) {
            	if(data.result=="success_delete"){
                	alert("刪除會員成功");
					$(tr).remove();
            	}
            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(data);
            });
		}
	});


    $("tbody").on("click", ".delete_admin" , function(){
        var result = confirm("確定刪除嗎？");
        var tr = this.closest('tr');
        if(result){
            var id = $(tr).attr('data-id');
            $.ajax({
                type: 'POST',
                url: './controller/member.php',
                data: {
                    "method" : "delete_admin",
                    "id" : id
                },
                dataType: 'json'
            }).done(function(data) {
                if(data.result=="success_delete"){
                    alert("刪除管理員成功");
                    $(tr).remove();
                }
            }).fail(function(data) {
                //失敗的時候
                alert("有錯誤產生，請看 console log");
                console.log(data);
            });
        }
    });







    $("#insert_admin").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        var password_again = $("#password-again").val();
        var name = $("#name").val();
        
        if (email == "") {
            alert("請輸入 email");
        } else if (password.length < 6) {
            alert("密碼長度必須大於6");
        } else if (password_again == "") {
            alert("請再次輸入密碼");
        } else if (password !== password_again) {
            alert("再次確認密碼錯誤");
        } else if (name == "") {
            alert("請輸入姓名");
        } else {
            $.post('./controller/member.php', { method: 'insert_admin', email: email, password: password , name : name }, function(data, textStatus, xhr) {
                console.log(data);
                if (data.result == "success") {
                    alert("新增管理員成功");
                    window.location.href="./admin.php";
                }else if (data.result == "email"){
                    alert("此 email 已經註冊過了");
                    $("#email").val("");
                } else {
                    alert("註冊失敗");
                    location.reload();       
                }
            });
        }
    });

});