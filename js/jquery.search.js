$(function(){	
	$('#search').show();
	
	$('#search-text').focus(function(){
				$(this).val('');
				return false;
			});
			
	$('#search-form').submit(function(){
		var type = $('#search-type').val();
		//console.log(type);
		
		var baseurl='';
		var searchurl = ''
		
		if (type == 'catalog'){
			baseurl = 'http://dppl.bibliocommons.com/search?t=smart&search_category=keyword&q={param}&commit=Search';
		}
		else if (type == 'site'){
			baseurl = '/home/search.shtml?q={param}';
		}
		
		var param = $('#search-text').val()
		param = encodeURI(param);
		//console.log(param)
		
		searchurl = baseurl.replace('{param}', param);
		
		window.location.href = searchurl;
		
		return false;
	});
});
