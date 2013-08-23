(function( $ ) {
  $.fn.bclist = function(options, callback) {
  
    // Display items from a bibliocommons list
	
	var settings = $.extend({
		'key' : '6vuvh66tx8evnz9b3r768gfh',
		'library' : 'dppl',
		'list_id' : '113135461',
		'display_fields' : 'minimal',
		'layout_class' : 'bc-layout-carousel',
		'inline_styles' : '',
		'show_title' : true,
		'show_description' : false,
		'show_thumbs' : true,
		'show_annotations' : false,
		'num_items' : 0,
		'output' : 'html',
	}, options);
	
	//define baseurl for retreiving list and add paramters from plugin
	var baseurl = (window.location.host == 'dppl.org'?'/tools/bc/list/':'http://dppl.org/tools/bc/list/');
	var url  = baseurl + 'id/' + settings.list_id + '/library/' + settings.library + '/api_key/' + settings.key;
	
	//define variables to use later on
	var div, list_div, item_div;
	var i = 0;
	
	return this.each(function() {
	
		var $this = $(this);
	
		$.getJSON(url + '?jsoncallback=?', function(data){
		    //console.log(data);
		    
		    //define the div for the item
		    div = $('<div>', {
		        'class' : 'bc-list',
		        'id' : 'bc-list-' + settings.list_id
		    });
		    
		    //if user wants title and description shown, then add those
			if (settings.show_title == true){
                div.append('<div class="bc-list-title">' + data.list.name + '</div>');		
			}
			
			if (settings.show_description == true){
			    //check that there is actually a description
			    if (data.list.description !== null){
			        div.append('<div class="bc-list-description">' + data.list.description + '</div>');
			    }
			}
			
			//define list for items, yes it's semantic
			list_ul = $('<ul>', {
			    'class' : 'bc-list-items ' + settings.layout_class,
		        'style' : settings.inline_styles
			});
			
			//pass list items into variable, just makes code a little easier to write/read
			var items = data.list.list_items;
			//figure out how many items should be returned, default setting is 0 which means all.
			var len = ((settings.num_items == 0)?data.list.item_count:settings.num_items);
			
			$.each(items, function(i, item){
				if (i < len){
					item_li = $('<li>',{
						'class': 'bc-list-item',
					});
			
					item = data.list.list_items[i].title;
					//console.log(item);
					
					//figure out if there is an item, and then collect info about it
					if (item){
						item_url = item['details_url'];
				        
				        //define the link that will contain thumbanil and title
						a = $('<a>', {
							'href': item_url,
							'class': (settings.show_thumbs == true?'bc-item-thumb':'bc-item-no-thumb')
						});
						
						//basic div to contain link and other block elements, it's an HTML thing
						a_div  = $('<div>');
						
						image_src = '';
						
						/*figure out if user wants thumbnails or not and proceed if so. switch statements just try to figure out the item
						type and make slot in the approprirate thumbnail or fallback*/
						if (settings.show_thumbs == true){
							switch (item['format']['id']){
								case 'BK':
									if (item['isbns']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=' + item['isbns'][0] + '/MC.GIF&client=847-342-5300&type=xw12&oclc=';
									}
									else{
										//image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-book.png';
									}
									break;
                                case 'BOOK_CD':
                                    if (item['isbns']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=' + item['isbns'][0] + '/MC.GIF&client=847-342-5300&type=xw12&oclc=';
									}
									else{
										//image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-audio-cd.png';
									}
                                    break;
								case 'MUSIC_CD':
									if (item['upcs']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=/MC.GIF&client=847-342-5300&type=xw12&oclc=&upc=' + item['upcs'][0];
									}
									else{
										//image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-music-cd.png';
									}
									break;
								case 'DVD':
								case 'BLURAY':
									if (item['upcs']){
										image_src = 'http://www.syndetics.com/index.aspx?isbn=/MC.GIF&client=847-342-5300&type=xw12&oclc=&upc=' + item['upcs'][0];
									}
									else{
										//image_src = 'http://cdn.bibliocommons.com/images/default_covers/icon-movie-alldiscs.png';
									}
									break;
							}
							
							//construct the image and append it to the link
							img = $('<img>',{
								'src' : image_src
							});

							a_div.append(img);
						}
						
						//append the title and then append that to the container div
						a_div.append('<div class="bc-item-title">' + item['title'] + '</div>');
						a.append(a_div);
						
						//console.log(a_div);
						
						//if user wants annotation display that
						if (settings.show_annotations == true){
						    //console.log(data.list.list_items[i].annotation);
						    if (data.list.list_items[i].annotation.length != 0){
						        a.after('<div class="bc-item-annotation">' + (settings.layout_class == 'bc-layout-list' && settings.show_thumbs == true?'<div class="bc-item-title">' + item['title'] + '</div>':'') + data.list.list_items[i].annotation + '</div>');
						    }
						}
						
						item_li.append(a);
						list_ul.append(item_li);
						
					}
				}
				
			});
			
			div.append(list_ul);
			
			//based on output setting, attach the output as html or text to target element
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
