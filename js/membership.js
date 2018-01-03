$(document).ready(function() {
    
    $("#update_password").click(function() {
        var email = $("#email").val();
        var password = $("#password").val();
        var new_password = $("#new_password").val();
        var new_password_again = $("#new_password_again").val();
    
        if (new_password.length < 6) {
            alert("密碼長度必須大於6");
        } else if (new_password_again == "") {
            alert("請再次輸入密碼");
        } else if (new_password !== new_password_again) {
            alert("再次確認密碼錯誤");
        } else {
            $.post('./controller/config.php', { method: 'login', email: email, password: password }, function(data, textStatus, xhr) {
                if (data.result == "success") {
                    $.post('./controller/membership.php', { method: 'update_password', email: email, password: new_password }, function(data, textStatus, xhr) {
                        if (data.result == "success") {
                            alert("更新密碼成功");
                            location.reload();       
                        } else {
                            alert("更新密碼錯誤");
                        }
                    });
                } else {
                    alert("密碼錯誤");
                }
            });
        }
    });

    $("#update_profile").click(function() {
        var email = $("#email").val();
        var name = $("#name").val();
        var phone = $("#phone").val();
        var address = $("#address").val();

        if (email == "") {
            alert("請輸入 email");
        } else if (name == "") {
            alert("請輸入姓名");
        } else if (phone == "") {
            alert("請輸入聯絡電話");
        } else if (address == "") {
            alert("請輸入地址");
        } else {
            $.post('./controller/membership.php', { method: 'update_profile', email: email, name : name , phone : phone , address :address }, function(data, textStatus, xhr) {
                if (data.result == "success") {
                    alert("更新個人資料成功");
                    location.reload();       
                } else {
                    alert("更新個人資料失敗");
                }
            });
        }
    });

});