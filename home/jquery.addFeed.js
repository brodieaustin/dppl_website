(function( $ ) {
  $.fn.addFeed = function(options) {
  
    // Do your awesome plugin stuff here
	
	var settings = $.extend({
		'feed_type' : 'events',
		'num_items' : 10,
		'url' : 'http://calendar.dppl.org/evanced/lib/eventsxml.asp?dm=exml&nd=5&fe=1',
	}, options);
	
	var div = '';
	var i = 0;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON('http://www.dppl.org/tools/feedtojson.php?jsoncallback=?', {url: settings.url}, function(data){
			$.each(data.item, function(index) {
				if (settings.feed_type == 'events'){
					if (i < settings.num_items){
						endtime = 
						div = div + '<div class="feed-item" id="' + data.item[index].id + '">'
							+ '<div class="feed-title"><a href="' + data.item[index].link + '">' + data.item[index].title + '</a></div>'
							+ '<div class="feed-dates">' + data.item[index].date + '</div>'
							+ '<div class="feed-times">' + data.item[index].time + ((data.item[index].endtime != 'All Day')?'&nbsp;&ndash;&nbsp;' + data.item[index].endtime:'') + '</div>'
							+'</div>';
						i++;
					}
				}
			});
			
			$this.append(div);
			
		});
	
	});

  };
})( jQuery );
