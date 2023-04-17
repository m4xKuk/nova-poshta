<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.css" integrity="sha512-5fsy+3xG8N/1PV5MIJz9ZsWpkltijBI48gBzQ/Z2eVATePGHOkMIn+xTDHIfTZFVb9GMpflF2wOWItqxAP2oLQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
	<title>Document</title>
</head>
<body>
	<h1>Nova Poshta</h1>
	<form>
	  <div class="row">
	    <div class="six columns">
	      <label for="sender_city_input">Sender Address</label>
	      <input class="u-full-width" type="text" placeholder="type 3+ simbols" id="sender_city_input">
	      <label class="">
	        <input type="checkbox" name="is_cache" id="is_cache" checked>
	        <span class="label-body">uncheck, if your city is not found (without cach)</span>
	      </label>
	    </div>
	    <div class="six columns">
	      <label for="sender_point_input">Point number</label>
	      <input class="u-full-width" type="text" placeholder="type 3+ simbols" id="sender_point_input">
	    </div>
	  </div>
	  
	  <input class="button-primary" type="submit" value="Submit">
	</form>

	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#sender_city_input').autocomplete({
				// source: 'delivery.php?sender_city=true&api_update=true',
				source: function(request, response) {
					var term = request.term ? request.term : '';
	        	    $.getJSON("delivery.php?sender_city=true", 
	        	    	{term:request.term, is_cache: $('#is_cache').is(':checked') }, 
	        	        response);
	        	  },
				minLength: 2,
				select: function( event, ui ) {
					$(this).data('ref', ui.item.ref)
					$('#sender_point_input').val('');
				}
			})
			.data('ui-autocomplete')._renderItem = function(ul, item){
		      return $( '<li class="ui-menu-item">' )
		          .attr( "data-ref", item.ref )
		          .append( '<div class="ui-menu-item-wrapper" >' + item.label + '</div>' )
		          .appendTo( ul );
		    };

	    	$('#sender_point_input').autocomplete({
	        	// source: 'delivery.php?sender_point=true&sender_city_ref='+ref,
	        	source: function(request, response) {
	        		var term = request.term ? request.term : '';
	        	    $.getJSON("delivery.php?sender_point=true", 
	        	    	{ term:request.term, sender_city_ref: $('#sender_city_input').data('ref'), is_cache: $('#is_cache').is(':checked') }, 
	        	        response);
	        	  },
	        	minLength: 0
	        }).focus(function () {
	    	    $(this).autocomplete("search");
	    	}).data('ui-autocomplete')._renderItem = function(ul, item){
	          return $( '<li class="ui-menu-item">' )
	              .attr( "data-ref", item.ref )
	              .append( '<div class="ui-menu-item-wrapper" >' + item.label + '</div>' )
	              .appendTo( ul );
	        };
		})
	</script>
</body>
</html>