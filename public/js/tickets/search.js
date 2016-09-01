$(document).ready(function(){
	//delete icon
	$(document).on('click', '.glyphicon-remove', function(){

	});
	//筛选 category
	$('#categ').on('click', function(){
		$('.addTag').dialog({
			  title: 'Search Category',
              autoOpen: true,
              modal: true,
              buttons:{
                  "search": searchCategory,
                  Cancel: function(){
                      $(this).dialog("close");
                  }
              }
          });
	});
	function searchCategory()
	{
		var categoryType = ['wifi', 'qb', 'phone', 'rem/pc', 'excel', 'website', 'email', 'monitor', 'printer', 'others'];
		var cate = $('.addText').val();
		// alert($.inArray(input, categoryType));	
		var type = '<input type="text" name="" class="types" value="'+cate+'" style="display: inline; font-size: 16px; width:66px;" disabled/><span style="font-size: 16px;" class="glyphicon glyphicon-remove"></span>';
		$('.search').append(type);
		var array = '';
		$('.types').each(function(){
			array += '+'+$(this).val()+' ';
		});
		// alert(array);
		//if string is in array	
		if($.inArray(cate, categoryType) > -1){

			$.ajaxSetup({
			  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
			$.ajax({
				url:'/tickets/cArraySearch/'+array+'',
	        	type: 'GET',
	        	data: {
	        		array: array
	        	},
	        	success: function( data ){
	        		// $('.addTag').dialog('close');
	        		window.location = '/tickets/cArraySearch/'+array+'';
	        		// console.log('yes');
		        },
		        error: function (xhr, b, c) {
		            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
		        }
			});	
		} else{
			alert('Not a valid category!');
		}
	}
});