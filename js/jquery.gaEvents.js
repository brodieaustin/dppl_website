//function to add event tracker to certain links
$(function(){
	if (_gaq){
		//category, action, label
		var c, a, l;
		
		l = window.location.pathname;

		//find each link with "track" class and add tracking event
		$('.track').each(function(){
			//use links data attributes for variables
			c = $(this).attr('data-ga-category');
			a = $(this).attr('data-ga-action');
			//bind click event
			$(this).click(function(){
				_gaq.push(['_trackEvent', c, a, l]);
			}).addClass('tracking');
		});
	}

});