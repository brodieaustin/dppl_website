if (typeof jQuery === "undefined") {
  loadjQuery("//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js", verifyJQueryCdnLoaded);
} else {
  main();
}

function verifyJQueryCdnLoaded() {
  if (typeof jQuery === "undefined"){
    loadjQuery("script/jquery-1.8.2.js", main);
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
		loadjQuery("script/jquery-1.8.2.js", main);
	  }
	  document.getElementsByTagName("head")[0].appendChild(script_tag);
  }
}

function main() {
  $(document).ready(function () {
  	$.getScript('http://dppl.org/js/jquery.bcLists.js', function(){
  		$('.bc-list').each(function(){
			var list_id = $(this).attr('id').replace('bc-list-', '');
			$(this).bcList({"list_id" : list_id});
			$(this).find('.load').hide();
		})
  	});
  });
}
