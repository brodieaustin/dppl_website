/*search box funcationality*/
$(function(){	
	$('#search').show();
	
	$('#search-type').change(function(){
		var placeholder;
		switch ($(this).val()){
			case 'catalog':
				placeholder = 'for books, movies, more...';
				break;
			case 'site':
				placeholder = 'for library information...';
				break;
		}
		$('#search-text').attr('placeholder', placeholder);
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
});
//handler for close buttons on warning messages
$(function(){
    $('.close').click(function(){
        $(this).parent().hide();
        return false;
    });
});
$(function(){ 
    $.smartbanner({
        title : 'Get the library on the go!',
        button : 'Download',
        scale : 1
    });  
});
/*$(function(){
	//try to detect if mobile browser is being used using isMobile function (see below)
	if (isMobile.any() == true){
		//look for mobile_banner cookie, if user closes message we don't want it appearing again
		//during that session
		var mobile_cookie = readCookie('mobile_alert');
		
		//if the cookie does not exist, show message
		if (!(mobile_cookie)){
			$('#mobile-alert').show();
		}
	};
	
	$('#mobile-alert a').click(function(){
		createCookie('mobile_alert','clicked', 60);
	});
	
	//handler for the close button
	$('#mobile-alert .close').click(function(){
		$(this).parent().hide();
		$('body').css('paddingTop', '0');
		createCookie('mobile_alert','closed');
	});
	
});*/

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

var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i) ? true : false;
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i) ? true : false;
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i) ? true : false;
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
		}
	};
	
	
