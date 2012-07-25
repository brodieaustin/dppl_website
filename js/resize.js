window.onload = function(){
	var cookie = readCookie('resize');
	
	if (cookie){
		document.body.style.fontSize = cookie;
	}
	
	var resizes = document.getElementsByClassName('resize');
	
	for (i=0;i < resizes.length; i++){
		resizes[i].addEventListener('click', resizeText, false);
	}

};

window.onunload = function(){

	var active = document.getElementsByClassName('active');
	var size = active[0].id;
	
	createCookie('resize', size, 60);
}

function resizeText(){

	var classes;
	var resizes = document.getElementsByClassName('resize');
	for (i=0;i < resizes.length; i++){
		resizes[i].className = resizes[i].className.replace('active', '').trim();
	}
	
	var size = this.id;
	createCookie('resize', size, 60);
	document.body.style.fontSize = size;
	
	this.className = this.className + ' active';
	
	return false;
};

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
