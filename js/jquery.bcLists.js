(function( $ ) {
  $.fn.bcList = function(options, callback) {
  
    // Display items from a bibliocommons list
	
	var settings = $.extend({
		'key' : '6vuvh66tx8evnz9b3r768gfh',
		'display_fields' : 'minimal',
		'show_title' : true,
		'show_thumbs' : true,
		'num_items' : 0,
		'output' : 'html',
		'list_id' : '113135461',
		'library' : 'dppl'
		
	}, options);
	
	var baseurl = (window.location.host == 'dppl.org'?'/tools/bc/list/':'http://dppl.org/tools/bc/list/');
	var url  = baseurl + 'id/' + settings.list_id + '/library/' + settings.library + '/api_key/' + settings.key;
	
	var div = '';
	var i = 0;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON(url + '?jsoncallback=?', function(data){
			if (settings.show_title == true){
				$this.before('<div class="list-title">' + data.list.name + '</div>');
			}
			var items = data.list.list_items;
			var len = ((settings.num_items == 0)?data.list.item_count:settings.num_items);
			
			$.each(items, function(i, item){
				if (i < len){
					div = $('<div>',{
						'class': 'list-item',
					});
			
					item = data.list.list_items[i].title;
					console.log(item);
					
					if (item){
						item_url = item['details_url'];
				
						a = $('<a>', {
							'href': item_url
						});
						
						image_src = '';
						
						if (settings.show_thumbs == true){
							switch (item['format']['id']){
								case 'BK':
									if (item['isbns']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=' + item['isbns'][0] + '/MC.GIF&client=847-342-5300&type=xw12&oclc=';
									}
									else{
										image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-book.png';
									}
									break;
                                case 'BOOK_CD':
                                    if (item['isbns']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=' + item['isbns'][0] + '/MC.GIF&client=847-342-5300&type=xw12&oclc=';
									}
									else{
										image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-audio-cd.png';
									}
                                    break;
								case 'MUSIC_CD':
									if (item['upcs']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=/MC.GIF&client=847-342-5300&type=xw12&oclc=&upc=' + item['upcs'][0];
									}
									else{
										image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-music-cd.png';
									}
									break;
								case 'DVD':
								case 'BLURAY':
									if (item['upcs']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=/MC.GIF&client=847-342-5300&type=xw12&oclc=&upc=' + item['upcs'][0];
									}
									else{
										image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-movie-alldiscs.png';
									}
									break;
							}
							
							console.log(image_src)
							
							img = $('<img>',{
								'class': 'bookjacket',
								'src' : image_src
							});
					
							a.append(img);
						}
						
						a.append('<p>' + item['title'] + '</p>');
						div.append(a);
						
						switch (settings.output){
							case 'html':
								$this.append(div);
								break;
							case 'text':
								console.log(div[0].outerHTML);
								$this.text($this.text() + div[0].outerHTML);
								break;
						}

					}
				}
				
			});
			
			
			if(typeof callback == 'function'){
					callback.call(this);
				}
			
		});
	
	});

  };
})( jQuery );
