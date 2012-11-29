if (typeof jQuery === "undefined") {
  loadjQuery("//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js", verifyJQueryCdnLoaded);
} else 
  main();

function verifyJQueryCdnLoaded() {
  if (typeof jQuery === "undefined")
    loadjQuery("script/jquery-1.8.2.js", main);
  else
    main();
}

function loadjQuery(url, callback) {
  var script_tag = document.createElement('script');
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

function main() {
  if (typeof jQuery === "undefined")
    alert("jQuery not loaded.");

  $(document).ready(function () {
  	$.getScript('http://dppl.org/js/jquery.bcLists.js', function(){
  		var list_id = $('.bc-list').attr('id').replace('bc-list-', '');
  		$('head').append('<link rel="stylesheet" href="http://dppl.org/tools/bc/list-view/css/list.css" />');
  		$('.bc-list').bcList({"list_id" : list_id});
  	});
  });

}
