/*
	JQuery Scripts Pilink -> Access Denied here !
*/

// Funcion de busqueda

	function SearchProcedureFn(SearchBoxContentVar, SearchContentProcedure){
		$.post("ps/function_level.php", { SearchContentProcedure: SearchContentProcedure, SearchBoxContentVar: SearchBoxContentVar }, function(data){
			$(".SearchContentSection").html(data);
		});
	}
	function ShowPilink(Pilink){
		$.post("ps/function_level.php", { Pilink: Pilink }, function(data){
			$(".SearchContentSection").html(data);
		});
	}
	// 7DTD
	$('.AddItemToList').click(function(){
		var ItemName = $('.ItemName').val();
		$.post("ps/function_level.php", { ItemName: ItemName }, function(data){
			$(".SearchContentSection").html(data);
		});
	});
	//
	$('.SearchBox').keyup(function(e) {
		if(e.keyCode == 13) {
			var lolx = $(this).val();
			var loly = "Search";
			SearchProcedureFn(lolx,loly);
		}
	});
	/*$('.SelectablePilink').click(function(){
		
	});*/
	$(document).on('click', '.SelectablePilink', function(e) {
        ShowPilink($(this).attr('pilink'));
    });
	$('.HomeSection').click(function(){
		window.location = "/";
	});
	$('.inputlinkcounter').click(function(){
		$(this).blur();
		$(this).prop( "disabled", true );
		var counter = 5;
		var interval = setInterval(function() {
			counter--;
			$('.inputlinkcounter').val(counter);
			if (counter == 0) {
				clearInterval(interval);
				var LinkCount = $('.linkaccess').val();
				$.post("../ps/function_level.php", { LinkCount: LinkCount }, function(data){
					$(".resultcounter").val(data);
				});
			}
		}, 1000);
	});