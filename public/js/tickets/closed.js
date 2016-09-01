$(document).ready(function(){

	$('#myTable').tablesorter();
	$(document).on('click', '.category', function(e)
	{	//get id of the element is being clicked
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		console.log(id);
		$("#"+id+"").dialog({
			  modal: true, title: 'Changing category', zIndex: 10000, autoOpen: true,
		      width: 'auto', resizable: false,
		      buttons: {
		          Change: function () {
		              doFunctionForRefer(id);
		              $(this).dialog("close");
		          },
		          Cancel: function () {
		              $(this).dialog("close");
		          }
		      }
		});
	});
	function doFunctionForRefer(id)
	{
		// console.log(option);	
		var id = $('#'+id+'').attr('id');
		var option = $('#'+id+'');
		var option = option.find('option:selected').text();
		var employee = $('#employee').attr('value');
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/changeCategoryTo'+option+'By'+employee+'/'+id+'',
        	type: 'POST',
        	data: {
        		id: id,
	            option: option,
	            employee: employee
        	},
        	success: function( data ){
        		window.location = window.location.href;
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});	
	}
}());