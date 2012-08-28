/*how do i list*/
$(function(){
	$('.how-do-i > a').attr('href', 'javascript:void(0)');
	$('.how-do-i').click(function(){
			if ($('.how-do-i-links').is(':visible') == false){
				$('.how-do-i-links').show(0).delay(5000).hide(0);
			}
			else{
				$('.how-do-i-links').hide();
			}
		});
});
/*search box funcationality*/
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
			baseurl = '/search.shtml?q={param}';
		}
		
		var param = $('#search-text').val()
		param = encodeURI(param);
		//console.log(param)
		
		searchurl = baseurl.replace('{param}', param);
		
		window.location.href = searchurl;
		
		return false;
	});
});
/*dropdown list*/
$(function(){

    $("ul.dropdown li").hover(function(){
    
        $(this).addClass("hover");
        $('ul:first',this).css('visibility', 'visible');
    
    }, function(){
    
        $(this).removeClass("hover");
        $('ul:first',this).css('visibility', 'hidden');
    
    });
    
    $("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");

});
/*for text resizing*/
$(function(){
	var cookie = readCookie('resize');
	
	if (cookie){
		$('body').css('font-size', cookie);
		$('.resize').removeClass('active');
		$('#' + cookie).addClass('active');
	}
	
	$('a.resize').bind('click', function(){
		$('.resize').removeClass('active');
		$(this).addClass('active');

		var size = $(this).attr('id');
		createCookie('resize', size, 60);
		$('body').css('font-size', size);

		return false;
	});

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else expires = "";
		
		document.cookie = name+"="+value+expires+"; path=/";
	};

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
			
		return null;
	}
});
/*value counter*/
$(function(){
	var date1 = Date.today().at('0:00:00');
	var p = .000442;

	
	setInterval(function(){
		var date2 = new Date();
		var amount = (date2 - date1) * p;
		
		$('#counter').html('$' + numberWithCommas(amount.toFixed(2)));
	}, 1000);
	
	function numberWithCommas(x) {
	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
});
