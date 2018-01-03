$(document).ready(function() {
    $("#login").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        if (email == "") {
            alert("請輸入 email");
        } else if (password == ""){
            alert("請輸入 密碼");
        }else{
        	$.post('./controller/config.php', { method : 'login' , email : email , password : password }, function(data, textStatus, xhr) {
          		console.log(data);
          		if(data.result=="success"){
          			alert("登入成功");
                history.go(-1);
          		}else{
          			alert("帳號密碼錯誤");
          		}
        	});        	
        }
    });
});