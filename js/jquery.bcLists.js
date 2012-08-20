(function( $ ) {
  $.fn.bcList = function(options, callback) {
  
    // Display items from a bibliocommons list
	
	var settings = $.extend({
		'key' : '6vuvh66tx8evnz9b3r768gfh',
		'display_fields' : 'minimal',
		'show_title' : true,
		'num_items' : 0,
		'list_id' : '113135461'
		
	}, options);
	
	var baseurl = 'https://api.bibliocommons.com/v1/';
	var url  = baseurl + 'lists/' + settings.list_id + '?library=dppl&api_key=' + settings.key;
	
	var div = '';
	var i = 0;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON(url + '&callback=?', function(data){
			if (settings.show_title == true){
				$this.before('<div class="list-title">' + data.list.name + '</div>');
			}
			var items = data.list.list_items;
			var len = ((settings.num_items == 0)?data.list.item_count:settings.num_items);
			
			for (i = 0; i < len; i++){
				div = $('<div>',{
					'class': 'list-item',
				});
		
				item = items[i]['title'];
			
				a = $('<a>', {
					'href': item_url = item['details_url'],
				});
				
				console.log(item['format']['id']);

				if (item['isbns']){
					isbn = 'http://www.syndetics.com/index.aspx?isbn=' + item['isbns'][0] + '/MC.GIF&client=847-342-5300&type=xw12&oclc='
				}
				else{
					if (item['format']['id'] == 'MUSIC_CD'){
						isbn = 'http://opl.bibliocommons.com/images/default_covers/icon-music-cd.png';
					}
					else if (item['format']['id'] == 'DVD'){
						isbn = 'http://opl.bibliocommons.com/images/default_covers/icon-movie-alldiscs.png';
					}
				}
				
				img = $('<img>',{
					'class': 'bookjacket',
					'src' : isbn
				});
			
			
				a.append(img);
				
				a.append('<p>' + item['title'] + '</p>');
				
				div.append(a);
				
				$this.append(div);
				
			}
			
			if(typeof callback == 'function'){
					callback.call(this);
				}
			
		});
	
	});

  };
})( jQuery );
