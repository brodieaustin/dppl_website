(function( $ ) {
  $.fn.addFeed = function(options) {
  
    // Do your awesome plugin stuff here
	
	var settings = $.extend({
		'feed_type' : 'events',
		'num_items' : 10,
		'show_title' : false,
		'show_thumbnail' : false,
		'show_summary' : false,
		'url' : 'http://calendar.dppl.org/evanced/lib/eventsxml.asp?dm=exml&nd=5&fe=1'
	}, options);
	
	var div = '';
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON('http://dppl.org/tools/feed.php?jsoncallback=?', {url: settings.url}, function(data){
		console.log(data);
			if (settings.feed_type == 'blog'){
				data = data.channel;
			}
			
			if (settings.show_title == true){
				div = div + '<div class="feed-title">' + data.title + '</div>';
			}
					
			$.each(data.item, function(i) {
				if (settings.feed_type == 'events'){
					if (i < settings.num_items){
						div = div + '<div class="feed-item event" id="' + data.item[i].id + '">'
							+ '<div class="feed-item-title"><a href="' + data.item[i].link + '">' + data.item[i].title + '</a></div>'
							+ '<div class="feed-item-dates">' + data.item[i].date + '</div>'
							+ '<div class="feed-item-times">' + data.item[i].time + ((data.item[i].endtime != 'All Day')?'&nbsp;&ndash;&nbsp;' + data.item[i].endtime:'') + '</div>'
							+'</div>';
					}
				}
				else if (settings.feed_type == 'blog'){
					console.log(data.item[i]);
					if (i < settings.num_items){
						div = div + '<div class="feed-item blog-post" id="' + data.item[i].guid + '">'
							+ '<div class="feed-item-title"><a href="' + data.item[i].link + '">' + data.item[i].title + '</a></div>'
							/*+ ((settings.show_thumbnail == true)?'<div class="feed-item-thumbnail"><img src="' + data.item[i].media:thumbnail + '" /></div>':'')*/
							+ ((settings.show_summary == true)?'<div class="feed-item-summary">' + data.item[i].atom + '...</div>':'')
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
