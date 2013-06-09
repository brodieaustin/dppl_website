(function( $ ) {
  $.fn.bcList = function(options, callback) {
  
    // Display items from a bibliocommons list
	
	var settings = $.extend({
		'key' : '6vuvh66tx8evnz9b3r768gfh',
		'library' : 'dppl',
		'list_id' : '113135461',
		'display_fields' : 'minimal',
		'layout_class' : '',
		'inline_styles' : '',
		'show_title' : true,
		'show_description' : false,
		'show_thumbs' : true,
		'show_annotations' : false,
		'num_items' : 0,
		'output' : 'html',
	}, options);
	
	var baseurl = (window.location.host == 'dppl.org'?'/tools/bc/list/':'http://dppl.org/tools/bc/list/');
	var url  = baseurl + 'id/' + settings.list_id + '/library/' + settings.library + '/api_key/' + settings.key;
	
	var div, list_div, item_div;
	var i = 0;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON(url + '?jsoncallback=?', function(data){
		    console.log(data);
		    
		    div = $('<div>', {
		        'class' : 'bc-list',
		        'id' : 'bc-list-' + settings.list_id
		    });
		    
			if (settings.show_title == true){
                div.append('<div class="bc-list-title">' + data.list.name + '</div>');		
			}
			
			if (settings.show_description == true){
			    div.append('<div class="bc-list-description">' + data.list.description + '</div>');
			}
			
			list_div = $('<div>', {
			    'class' : 'bc-list-items ' + settings.layout_class,
		        'style' : settings.inline_styles
			});
			
			var items = data.list.list_items;
			var len = ((settings.num_items == 0)?data.list.item_count:settings.num_items);
			
			$.each(items, function(i, item){
				if (i < len){
					item_div = $('<div>',{
						'class': 'bc-list-item',
					});
			
					item = data.list.list_items[i].title;
					//console.log(item);
					
					if (item){
						item_url = item['details_url'];
				
						a = $('<a>', {
							'href': item_url,
							'class': (settings.show_thumbs == true?'bc-item-thumb':'')
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
							
							
							img = $('<img>',{
								'src' : image_src
							});

							a.append(img);
						}
						
						a.append('<p class="bc-item-title">' + item['title'] + '</p>');
						
						if (settings.show_annotations == true){
						    a.after('<p class="bc-item-annotation">' + data.list.list_items[i].annotation + '</p>');
						}
						
						item_div.append(a);
						list_div.append(item_div);
						
					}
				}
				
			});
			
			div.append(list_div);
			
			switch (settings.output){
				case 'html':
					$this.html(div);
					break;
				case 'text':
					//console.log(div[0].outerHTML);
					$this.text(div[0].outerHTML);
					break;
			}
			
			
			if(typeof callback == 'function'){
					callback.call(this);
				}
			
		});
	
	});

  };
})( jQuery );
