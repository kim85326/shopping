$(document).ready(function() {
    $("#logout").click(function(e) {
    	e.preventDefault();
    	console.log("prevent");
    	$.post('./controller/config.php', { method : 'logout' }, function(data, textStatus, xhr) {
      		console.log(data);
      		if(data.result=="success"){
      			alert("登出成功");
      			window.location.href="./index.php";
      		}else{
      			alert("登出失敗");
      		}
      });
	});
});