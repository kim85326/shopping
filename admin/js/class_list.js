$(document).ready(function(){
	$( ".column" ).sortable({
		connectWith: ".column",
		handle: ".portlet-header",
		cancel: ".portlet-toggle",
		placeholder: "portlet-placeholder ui-corner-all",
		stop: function(){
			var orderPair = [];
    		$("#class").find(".portlet").each(function(index, li) {
    			orderPair.push({
    				cid1 : $(li).data("cid1"),
    				order : index +1
    			});
    		});
    		$.post('./controller/class.php', { method : 'sort_cid1', orderPair : orderPair }, function(data, textStatus, xhr) {
				console.log(data);
				if(data.result=="success"){
					alert("排序成功");
				}
			});
    	},
    });
 
    $( ".portlet" )
      .addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");
 
    $( ".portlet-toggle" ).on( "click", function() {
      var icon = $( this );
      icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
      icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
    });


    $("#class").find( ".sortable" ).sortable({
		placeholder: "ui-state-highlight",
		// 第二層分類排序
		stop: function(){
			var orderPair = [];
    		$("#class").find("li").each(function(index, li) {
    			orderPair.push({
    				cid2 : $(li).data("cid2"),
    				order : index +1
    			});
    		});
    		$.post('./controller/class.php', { method : 'sort_cid2', orderPair : orderPair }, function(data, textStatus, xhr) {
				console.log(data);
				if(data.result=="success"){
					alert("排序成功");
				}
			});
    	},
    });
    $( "#sortable" ).disableSelection();



	// 更新cid1的名字
    $("#class")
	    .on("dblclick" , ".cid1_name" , function(e){
	    	$(this).prop('contenteditable' , 'true').focus();
	    })
	    .on("blur" , ".cid1_name" , function(e){

	    	var cid1 = $(this).closest('.portlet').data('cid1');
			var new_name = $(this).text();
	    	$.post('./controller/class.php', { method : 'update_cid1', cid1 : cid1 , new_name : new_name }, function(data, textStatus, xhr) {
				console.log(data);
				if(data.result=="success"){
					alert("更新成功");
				}
			});

	    	$(this).prop('contenteditable' , 'false');
	    })
	    // 刪除cid1
	    .on("click" , ".delete_cid1" , function(e){
	    	var result = confirm("確定刪除嗎？");
	    	if(result){
	    		var cid1 = $(this).closest('.portlet').data('cid1');
		    	$.post('./controller/class.php', { method : 'delete_cid1', cid1 : cid1 }, function(data, textStatus, xhr) {
					console.log(data);
					if(data.result=="success"){
						alert("刪除成功");
						$(e.currentTarget).closest('.portlet').remove();
					}
				});
	    	}
	    });

    // 更新cid2的名字
    $("#class")
	    .on("dblclick" , ".cid2_name" , function(e){
	    	$(this).prop('contenteditable' , 'true').focus();
	    })
	    .on("blur" , ".cid2_name" , function(e){
	    	var cid2 = $(this).closest("li").data("cid2");
			var new_name = $(this).text();
	    	$.post('./controller/class.php', { method : 'update_cid2', cid2 : cid2 , new_name : new_name }, function(data, textStatus, xhr) {
				console.log(data);
				if(data.result=="success"){
					alert("更新成功");
				}
			});
	    	$(this).prop('contenteditable' , 'false');
	    })
	    // 刪除cid2
	    .on("click" , ".delete_cid2" , function(e){
	    	var result = confirm("確定刪除嗎？");
	    	if(result){
	    		var cid2 = $(this).closest("li").data("cid2");
		    	$.post('./controller/class.php', { method : 'delete_cid2', cid2 : cid2 }, function(data, textStatus, xhr) {
					console.log(data);
					if(data.result=="success"){
						alert("刪除成功");
						$(e.currentTarget).closest("li").remove();
					}
				});
	    	}
	    });

});