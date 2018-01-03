$(document).ready(function() {

	$("#insert_cid1").click(function() {
		var name = $("#cid1").val();
		$.post('./controller/class.php', { method : 'insert_cid1', name : name }, function(data, textStatus, xhr) {
			console.log(data);
			if(data.result=="success"){
				alert("新增成功");
				location.reload();
			}
		});
	});

	$("#insert_cid2").click(function() {
		var name = $("#cid2").val();
		var cid1 = $("#parent-cid1 option:selected").attr('data-id');
		console.log(cid1);
		console.log(name);

		$.post('./controller/class.php', { method : 'insert_cid2', name : name, cid1 : cid1 }, function(data, textStatus, xhr) {
			console.log(data);
			if(data.result=="success"){
				alert("新增成功");
				location.reload();
			}
		});
	});



});