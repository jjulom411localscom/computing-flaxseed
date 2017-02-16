$(document).ready(function(){
	/*Ajax Functions*/
	$(document).on('click','.ingred-load-btn', function(){
		
		var that = $(this);
		var page = $(this).data('page');
		var newPage = page+1;
		var ajaxurl = that.data('url');
		
		$.ajax({
			
			url : ajaxurl,
			type : 'post',
			data : {
				
				page : page,
				action: 'behealthy_load_more'
				
			},
			error : function( response ){
				console.log(response);
			},
			success : function( response ){
				
				that.data('page', newPage);
				$('.behealthy-posts-container').append( response );
				
			}
			
		});
		
	});

})