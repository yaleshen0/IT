$(document).ready(function()
{	
	$("#myTable").tablesorter(); 
	//open action
	$(document).on('click', '.Open', function(e)
	{	//time now
		var time = new Date().getTime();
	    var employee = document.getElementById('employee').textContent;
		//get id of the element is being clicked
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/updateOpen'+id+'By'+employee+''+time+'',
        	type: 'POST',
        	data: {
	            id: id,
	            employee: employee,
	            time: time
        	},
        	success: function( data ){
        		// fresh();
        		window.location = window.location.href;
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});
	});
	//hold action 
	$(document).on('click', '.Hold', function(e)
	{	//get id of the element is being clicked
		var time = new Date().toISOString();
		alert(Date.parse(time));
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/updateHold'+id+'',
        	type: 'POST',
        	data: {
	            id: id
        	},
        	success: function( data ){
        		// window.location = window.location.href;
        		// fresh();
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});
	});						
	//unhold action 
	$(document).on('click', '.Unhold', function(e)
	{	//get id of the element is being clicked
		var employee = document.getElementById('employee').textContent;
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/updateUnhold'+id+'By'+employee+'',
        	type: 'POST',
        	data: {
	            id: id,
	            employee:employee
        	},
        	success: function( data ){
        		window.location = window.location.href;
        		// fresh();
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});
	});
	//close action
	$(document).on('click', '.Close', function(e)
	{	//get id of the element is being clicked
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		var employee = document.getElementById('employee').textContent;
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/updateClose'+id+'By'+employee+'',
        	type: 'POST',
        	data: {
	            id: id,
	            employee: employee
        	},
        	success: function( data ){
        		window.location = window.location.href;
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});
	});
	//pop out window
	$('#dialog').dialog({
		autoOpen: false,
		title: 'Basic Dialog'
	});
	//refer action
	$(document).on('click', '.Refer', function(e)
	{	//get id of the element is being clicked
		var id = e.target.id;
		var id =id.substring(id.lastIndexOf("[")+1,id.lastIndexOf("]"));
		$("#"+id+"").dialog({
			  modal: true, title: 'Refer Action', zIndex: 10000, autoOpen: true,
		      width: 'auto', resizable: false,
		      buttons: {
		          Refer: function () {
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
			url:'/tickets/referTo'+option+'By'+employee+'/'+id+'',
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
	//分类－>category
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
		//if string is in array	
		if($.inArray(cate, categoryType) > -1){
			$.ajaxSetup({
			  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
			$.ajax({
				url:'/tickets/c'+cate+'Search',
	        	type: 'GET',
	        	data: {
	        		cate: cate
	        	},
	        	success: function( data ){
	        		$('.addTag').dialog('close');
	        		window.location = '/tickets/c'+cate+'Search';
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
	//分类－>priority
	$('#prior').on('click', function(){
		$('.addTag').dialog({
			  title: 'Search Priority',
              autoOpen: true,
              modal: true,
              buttons:{
                  "search": searchPriority,
                  Cancel: function(){
                      $(this).dialog("close");
                  }
              }
          });
	});
	function searchPriority()
	{
		var priorType = ['high', 'normal', 'low'];
		var prior = $('.addText').val();
		// alert($.inArray(prior, priorType));	
		//if string is in array	
		if($.inArray(prior, priorType) > -1){
			$.ajaxSetup({
			  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
			$.ajax({
				url:'/tickets/p'+prior+'Search',
	        	type: 'GET',
	        	data: {
	        		prior: prior
	        	},
	        	success: function( data ){
	        		$('.addTag').dialog('close');
	        		window.location = '/tickets/p'+prior+'Search';
	        		// console.log('yes');
		        },
		        error: function (xhr, b, c) {
		            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
		        }
			});	
		} else{
			alert('Type in high or normal or low!');
		}
	}
	//轮询
	function fresh()
	{
		$.ajaxSetup({
		  headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
			url:'/tickets/index',
        	type: 'GET',
        	success: function( data ){
        		// window.location = window.location.href;
        		$('#myTable').load('/tickets/index #myTable');
	        },
	        error: function (xhr, b, c) {
	            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
	        }
		});
		setTimeout(function(){ 
			fresh(); 
		}, 10000);
	};
	// fresh();
});