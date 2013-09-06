(function( $ ) {
  $.fn.addFeed = function(options, callback) {
  
    // Do your awesome plugin stuff here
	
	var settings = $.extend({
		'feed_type' : 'events',
		'num_items' : 10,
		'feed_title' : '',
		'show_thumbnail' : false,
		'show_summary' : false,
		'url' : 'http://calendar.dppl.org/evanced/lib/eventsxml.asp?dm=exml&nd=5&fe=1'
	}, options);
	
	var div = '<div class="feed-items ' + settings.feed_type + '">';
	var has_image, has_summary;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON('/tools/feed.php?jsoncallback=?', {url: settings.url, feed_type: settings.feed_type, num_items: settings.num_items}, function(data){
		    //console.log(data);
		    
		    if (settings.feed_title.length > 0){
		        div = div + '<div class="feed-title ' + settings.feed_title.toLowerCase().replace(/ /g, '-') + '">' + settings.feed_title + '</div>';
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
					if (i < settings.num_items){
						if (settings.show_thumbnail == true){
							has_image = (data.item[i].thumbnail != undefined ? true : false);
						}
						else{
							has_image = false;
						}
						//console.log(has_image);
						div = div + '<div class="feed-item blog-post' + ((has_image == false)?' no-thumbnail':'') + '" id="' + data.item[i].guid + '">'
    						+ ((has_image == true) ? '<div class="feed-item-thumbnail"><img src="' + data.item[i].thumbnail + '" /></div>' : '')
							+ '<div class="feed-item-title"><a href="' + data.item[i].link + '">' + data.item[i].title + '</a></div>'
							+ ((settings.show_summary == true)?'<div class="feed-item-summary">' + (data.item[i].description == undefined ? data.item[i].summary : data.item[i].description) + '</div>' : '')
							+'</div>';
					}
				}
			});
			
			div = div + '</div><!--closing div for feed items-->';
			
			//$('.load').fadeOut(500);
			$this.html(div);
			
			if(callback) callback();
			
		});
	
	});

  };
})( jQuery );
