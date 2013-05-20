//check if jquery is loaded. if not load it, otherwise, call main function
if (typeof jQuery === "undefined") {
  loadjQuery("//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", verifyJQueryCdnLoaded);
} else {
  main();
}

//
function verifyJQueryCdnLoaded() {
  if (typeof jQuery === "undefined"){
    loadjQuery("script/jquery-1.9.1.js", main);
  }
  else{
    main();
  }
}

function loadjQuery(url, callback) {
  if (document.getElementById('bc-list-jquery') === null){
	  var script_tag = document.createElement('script');
	  script_tag.setAttribute('id', 'bc-list-jquery');
	  script_tag.setAttribute("src", url)
	  script_tag.onload = callback; // Run callback once jQuery has loaded
	  script_tag.onreadystatechange = function () { // Same thing but for IE
		if (this.readyState == 'complete' || this.readyState == 'loaded') callback();
	  }
	  script_tag.onerror = function() {
		loadjQuery("script/jquery-1.9.1.js", main);
	  }
	  document.getElementsByTagName("head")[0].appendChild(script_tag);
  }
}

function main() {
  $(document).ready(function () {
  	$.getScript('http://dppl.org/js/jquery.bcLists.js', function(){
  		$('.bc-list').each(function(){
			var list_id = $(this).attr('id').replace('bc-list-', '');
			var show_title = true;
			var show_thumbs = true;
			
			if ($(this).attr('data-bc-show-title') !== undefined ){
				show_title = $(this).attr('data-bc-show-title');
			}
			if ($(this).attr('data-bc-show-thumbs') !== undefined ){
				show_thumbs = $(this).attr('data-bc-show-thumbs');
			}
			$(this).bcList({"list_id" : list_id, "show_title" : show_title, "show_thumbs" : show_thumbs});
			$(this).find('.load').hide();
		})
  	});
  });
}
