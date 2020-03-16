$(document).ready(function(){
	
	$('body').on("click", '.rating_action_link', function(){
	
		var type_action = '1',
			id_element = $(this).closest('.wrap_item_element_rating').attr('data-id-element');
		
		if($(this).hasClass('down')){type_action = '0';}
		
		$.ajax({
			type: "POST",
			url: window.location.href,
			data: {ID_ELEMENT : id_element, TYPE_ACTION:type_action},
			success: function(data){
			
				var block_vote = $(data).find('[data-id-element = '+id_element+']').html();
				$('[data-id-element = '+id_element+']').html(block_vote);

				var block_vote4 = $(data).find('.test').html();
				
				console.log(block_vote4);
			}
		});
		
	});

	function update_raiting(){
		
		$.ajax({
			type: "POST",
			url: window.location.href,
			success: function(data){
			
				$(data).find('.list_elelments .wrap_item_element_rating').each(function(indx, element){
	  
				  var 	id_element = $(this).attr('data-id-element'),
						content_vote = $(this).html();
				  
				  $('[data-id-element = '+id_element+']').html(content_vote);
				  
				});

			}
		});	
		
	}
	
	setInterval(update_raiting, 20000)
	
});