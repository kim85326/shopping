$(document).ready(function() {
    $("#signup").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        var password_again = $("#password-again").val();
        var name = $("#name").val();
        var phone = $("#phone").val();
        var address = $("#address").val();

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
        } else if (phone == "") {
            alert("請輸入聯絡電話");
        } else if (address == "") {
            alert("請輸入地址");
        } else {
            $.post('./controller/config.php', { method: 'signup', email: email, password: password , name : name , phone : phone , address :address }, function(data, textStatus, xhr) {
                console.log(data);
                if (data.result == "success") {
                    alert("註冊成功");
                    window.location.href="./index.php";
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