(function( $ ) {
  $.fn.addFeed = function(options) {
  
    // Do your awesome plugin stuff here
	
	var settings = $.extend({
		'feed_type' : 'events',
		'num_items' : 10,
		'url' : 'http://calendar.dppl.org/evanced/lib/eventsxml.asp?dm=exml&nd=5&fe=1'
	}, options);
	
	var div = '';
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON('/tools/feedtojson.php?jsoncallback=?', {url: settings.url}, function(data){
			//console.log(data);
			$.each(data.item, function(i) {
				if (settings.feed_type == 'events'){
					if (i < settings.num_items){
						div = div + '<div class="feed-item" id="' + data.item[i].id + '">'
							+ '<div class="feed-title"><a href="' + data.item[i].link + '" class="link_sm">' + data.item[i].title + '</a></div>'
							+ '<div class="feed-dates">' + data.item[i].date + '</div>'
							+ '<div class="feed-times">' + data.item[i].time + ((data.item[i].endtime != 'All Day')?'&nbsp;&ndash;&nbsp;' + data.item[i].endtime:'') + '</div>'
							+'</div>';
					}
				}
			});
			
			$('.load').fadeOut(500);
			$this.append(div);
			
		});
	
	});

  };
})( jQuery );
