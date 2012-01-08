// Start Kinko's Track
function isKinkosOrder(string){
	if (typeof(string) != 'string'){return false;}
	if (string.length != 16){return false;}
	if (string.match(/^\d+$/)){return true;}
	return false;
}
function TAtoArray(textArea){
	//convert textarea form entry type into an array of entries
	if (typeof(textArea) == 'undefined' || typeof(textArea.type) == 'undefined' || textArea.type != 'textarea')
	{
		//unexpected or bad element passed in
		return null;
	}
	var value = textArea.value;
	var valueArray = value.split('\n');
	var i = 0;
	var newArray = new Array();
	var arrayOffset = 0;
	for(i = 0; i < valueArray.length; i++){
		valueArray[i] = valueArray[i].replace(/\s/g, "");
		if (valueArray[i].length > 0)		{
			newArray[arrayOffset] = valueArray[i];
			arrayOffset++;
		}
	}
	return newArray;
}
function buildKinkosURL(orderArray){
	var kinkosURL = "http://tracking.fedexkinkos.com/trackOrder.do?gtns=";
	var i = 0;
	var wsslist = "";
	for (i = 0; i < orderArray.length; i++)	{
		kinkosURL += orderArray[i] + "%0D%0A";
		if (i < (orderArray.length - 1)){
			wsslist += orderArray[i] + ",";
		}
	}
	kinkosURL += "&hbx.c2=" + wsslist;
	return kinkosURL;
}
function openKinkosWindow(destURL){
	var openWidth = 800;
	var openHeight = 600;
	var xpos = (screen.width - openWidth)/2;
	var ypos = (screen.height - openHeight)/2;
	var windowParams = "resizable=yes,scrollbars=yes,status=no,";
	windowParams += "height=" + openHeight + ",";
	windowParams += "width=" + openWidth + ",";
	windowParams += "screenX=" + xpos + ",";
	windowParams += "screenY=" + ypos + ",";
	windowParams += "left=" + xpos + ",";
	windowParams += "top=" + ypos + ",";
	if (window.open){
		window.open(destURL, "KinkosOrderTracking", windowParams);
	}
	return false;
}
function checkKinkosOrders(textArea){
	var entriesArray = TAtoArray(textArea);
	var i = 0;
	var kinkosnumbers = 0;
	var nonkinkos = 0;
	for (i = 0; i < entriesArray.length; i++){
		if (isKinkosOrder(entriesArray[i])){
			kinkosnumbers++;
		}
		else{
			nonkinkos++;
		}
	}
	if (kinkosnumbers > 0 && nonkinkos == 0){
		var newLocation = buildKinkosURL(entriesArray);
		openKinkosWindow(newLocation);
		return false;
	}
	else{
		return true;
	}
}
// End Kinko's Track

// Start Login Module
function goLogin(cc,clang,cpath){
	var startLoc = new String(window.location);
	var startHost = startLoc.replace(/http(s)?:\/\/((.*\.)?fedex\.com)\/.*/, "$2");
	if ((startHost == "cms.idev.fedex.com") || (startHost == "contentdev.idev.fedex.com") || (startHost == "cmsdev.idev.fedex.com") || (startHost == "cmsdev1.idev.fedex.com") || (startHost == "teamsite.idev.fedex.com")){startHost="fedex.com";}
	if (startHost == "fedex.com") {startHost="www.fedex.com";}
	var gtmHost = startHost.replace("www", "gtm");
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FSM") {
		if(clang == "tc"){
			clang="zht";
		}
		if(clang == "sc"){
			clang="cs";
		}
	}
	
	//PleaseSelect
	PleaseSelect_appName = "fclfsm";
	PleaseSelect_stepURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26action=fsmregister";
	PleaseSelect_afterURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26programIndicator=0";
	
	//GTM
	GTM_appName = "fclgtm";
	GTM_stepURL = "https://"+gtmHost+"/GTM/FclStep3?cntry_code="+cpath+"%26link=1%26lid=//International//Pack+GTM+Intl+Doc+Corp";
	GTM_afterURL = "https://"+gtmHost+"/FID?cntry_code="+cpath+"%26link=1%26lid=//International//Pack+GTM+Intl+Doc+Corp";
	
	//FSM
	FSM_appName = "fclfsm";
	FSM_stepURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26action=fsmregister";
	FSM_afterURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26programIndicator=0";
	
	//MFX
	MFX_appName = "fclmfx";
	MFX_stepURL = "https://"+startHost+"/myfedex/go/fclstep3?cc="+cc+"%26language="+clang;
	MFX_afterURL = "https://"+startHost+"/myfedex/go/home?cc="+cc+"%26language="+clang;
	
	//RATES
	RATE_appName = "fclrates";
	RATE_stepURL = "https://"+startHost+"/ratefinder/regstep3?cc="+cc+"%26language="+clang+"%26action=Registration";
	RATE_afterURL = "https://"+startHost+"/ratefinder/fclhome?cc="+cc+"%26language="+clang;
	
	// INSIGHT
	INSIGHT_appName = "fclinsight";
	INSIGHT_stepURL = "https://"+startHost+"/insight/entrance/fcl_registration_landing_post.jsp";
	INSIGHT_afterURL = "https://"+startHost+"/insight/entrance/pre_entrance_post.jsp";
	
	//BILLING ONLINE
	FIO_appName = "fclfio";
	FIO_stepURL = "https://"+startHost+"/FedExMMA/jsp/FioStep3.jsp";
	FIO_afterURL = "https://"+startHost+"/FedExMMA/jsp/RegistrationRouter.jsp";
	
	//Pickup
	PICKUP_appName = "fclpickup";
	PICKUP_stepURL = "https://"+startHost+"/PickupApp/FCLStep3.jsp";
	PICKUP_afterURL = "https://"+startHost+"/PickupApp/?locale="+clang+"_"+cc;
	
	//Freight
	FXF_appName = "fclfreight";
	FXF_stepURL = "https://www.fedexfreight.fedex.com/fclStep3.jsp";
	FXF_afterURL = "https://www.fedexfreight.fedex.com/fcllogin.do?programIndicator=3";
	
	//Freight National
	FNL_appName = "fclfreight";
	FNL_stepURL = "https://fnl.fedexnational.fedex.com/us/fclStep3.jsp";
	FNL_afterURL = "https://fnl.fedexnational.fedex.com/us/FCLLogon?programIndicator=3";
	
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FIO") {
		document.logonForm.appName.value=FIO_appName;
		document.logonForm.step3URL.value=FIO_stepURL;
		document.logonForm.afterwardsURL.value=FIO_afterURL;
		document.logonForm.returnurl.value=FIO_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+FIO_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+FIO_stepURL+"&amp;afterwardsURL="+FIO_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FNL") {
		document.logonForm.appName.value=FNL_appName;
		document.logonForm.step3URL.value=FNL_stepURL;
		document.logonForm.afterwardsURL.value=FNL_afterURL;
		document.logonForm.returnurl.value=FNL_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+FNL_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+FNL_stepURL+"&amp;afterwardsURL="+FNL_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FXF") {
		document.logonForm.appName.value=FXF_appName;
		document.logonForm.step3URL.value=FXF_stepURL;
		document.logonForm.afterwardsURL.value=FXF_afterURL;
		document.logonForm.returnurl.value=FXF_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+FXF_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+FXF_stepURL+"&amp;afterwardsURL="+FXF_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "PICKUP") {
		document.logonForm.appName.value=PICKUP_appName;
		document.logonForm.step3URL.value=PICKUP_stepURL;
		document.logonForm.afterwardsURL.value=PICKUP_afterURL;
		document.logonForm.returnurl.value=PICKUP_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+PICKUP_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+PICKUP_stepURL+"&amp;afterwardsURL="+PICKUP_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "RATE") {
		document.logonForm.appName.value=RATE_appName;
		document.logonForm.step3URL.value=RATE_stepURL;
		document.logonForm.afterwardsURL.value=RATE_afterURL;
		document.logonForm.returnurl.value=RATE_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+RATE_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+RATE_stepURL+"&amp;afterwardsURL="+RATE_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "INSIGHT") {
		document.logonForm.appName.value=INSIGHT_appName;
		document.logonForm.step3URL.value=INSIGHT_stepURL;
		document.logonForm.afterwardsURL.value=INSIGHT_afterURL;
		document.logonForm.returnurl.value=INSIGHT_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+INSIGHT_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+INSIGHT_stepURL+"&amp;afterwardsURL="+INSIGHT_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "MFX") {
		document.logonForm.appName.value=MFX_appName;
		document.logonForm.step3URL.value=MFX_stepURL;
		document.logonForm.afterwardsURL.value=MFX_afterURL;
		document.logonForm.returnurl.value=MFX_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+MFX_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+MFX_stepURL+"&amp;afterwardsURL="+MFX_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "PleaseSelect") {
		document.logonForm.appName.value=PleaseSelect_appName;
		document.logonForm.step3URL.value=PleaseSelect_stepURL;
		document.logonForm.afterwardsURL.value=PleaseSelect_afterURL;
		document.logonForm.returnurl.value=PleaseSelect_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+PleaseSelect_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+PleaseSelect_stepURL+"&amp;afterwardsURL="+PleaseSelect_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FSM") {
		document.logonForm.appName.value=FSM_appName;
		document.logonForm.step3URL.value=FSM_stepURL;
		document.logonForm.afterwardsURL.value=FSM_afterURL;
		document.logonForm.returnurl.value=FSM_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+FSM_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+FSM_stepURL+"&amp;afterwardsURL="+FSM_afterURL;
	}
	if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "GTM") {
		document.logonForm.appName.value=GTM_appName;
		document.logonForm.step3URL.value=GTM_stepURL;
		document.logonForm.afterwardsURL.value=GTM_afterURL;
		document.logonForm.returnurl.value=GTM_afterURL;
		document.logonForm.action = "https://"+startHost+"/fcl/logon.do?appName="+GTM_appName+"&amp;locale="+cc+"_"+clang+"&amp;step3URL="+GTM_stepURL+"&amp;afterwardsURL="+GTM_afterURL;
	}
}
// shows/hides a tag by id
function hideID(val){
	var id 	= document.getElementById(val);
	if(!id) return;
	id.style.display = 'none';
}
// shows/hides a tag by id
function showID(val){
	var id 	= document.getElementById(val);
	if(!id) return;
	id.style.display = 'inline'; 
}
function getexpirydate( nodays){
	var UTCstring;
	Today = new Date();
	nomilli=Date.parse(Today);
	Today.setTime(nomilli+nodays*24*60*60*1000);
	UTCstring = Today.toUTCString();
	return UTCstring;
}
function getcookie(cookiename) {
	var cookiestring=""+document.cookie;
	var index1=cookiestring.indexOf(cookiename);
	if (index1==-1 || cookiename=="") return ""; 
	var index2=cookiestring.indexOf(';',index1);
	if (index2==-1) index2=cookiestring.length; 
	return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}
function setcookie(name,value,duration){
	cookiestring=name+"="+escape(value)+";EXPIRES="+getexpirydate(duration)+"; path=/; domain=.fedex.com;";
	document.cookie=cookiestring;
	if(!getcookie(name)){
		return false;
	}else{
		return true;
	}
}
function setsessioncookie(name,value){
	cookiestring=name+"="+escape(value)+"; EXPIRES=; path=/; domain=.fedex.com;";
	document.cookie=cookiestring;
	if(!getcookie(name)){
		return false;
	}else{
		return true;
	}
}
function deletecookie(name){
	cookiestring=name+"=; EXPIRES=Thu, 01-Jan-70 00:00:01 GMT; path=/; domain=.fedex.com;";
	document.cookie=cookiestring;
	if(!getcookie(name)){
		return false;
	}else{
		return true;
	}
}
function GoTo(page,cc,clang,cpath) {
	var startLoc = new String(window.location);
	var startHost = startLoc.replace(/http(s)?:\/\/((.*\.)?fedex\.com)\/.*/, "$2");
	if ((startHost == "cms.idev.fedex.com") || (startHost == "contentdev.idev.fedex.com") || (startHost == "cmsdev.idev.fedex.com") || (startHost == "cmsdev1.idev.fedex.com") || (startHost == "teamsite.idev.fedex.com")){startHost="fedex.com";}
	if (startHost == "fedex.com") {startHost="www.fedex.com";}
	var gtmHost = startHost.replace("www", "gtm");
	var locale = cc+"_"+clang;
	
	//PleaseSelect
	PleaseSelect_appName = "fclfsm";
	PleaseSelect_stepURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26action=fsmregister";
	PleaseSelect_afterURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26programIndicator=0";

	//GTM
	GTM_appName = "fclgtm";
	GTM_stepURL = "https://"+gtmHost+"/GTM/FclStep3?cntry_code="+cpath+"%26link=1%26lid=//International//Pack+GTM+Intl+Doc+Corp";
	GTM_afterURL = "https://"+gtmHost+"/FID?cntry_code="+cpath+"%26link=1%26lid=//International//Pack+GTM+Intl+Doc+Corp";
	
	//FSM
	FSM_appName = "fclfsm";
	FSM_stepURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26action=fsmregister";
	FSM_afterURL = "https://"+startHost+"/cgi-bin/ship_it/interNetShip?origincountry="+cc+"%26locallang="+clang+"%26urlparams="+cpath+"%26sType=%26programIndicator=0";
	
	//MFX
	MFX_appName = "fclmfx";
	MFX_stepURL = "https://"+startHost+"/myfedex/go/fclstep3?cc="+cc+"%26language="+clang;
	MFX_afterURL = "https://"+startHost+"/myfedex/go/home?cc="+cc+"%26language="+clang;
	
	//RATES
	RATE_appName = "fclrates";
	RATE_stepURL = "https://"+startHost+"/ratefinder/regstep3?cc="+cc+"%26language="+clang+"%26action=Registration";
	RATE_afterURL = "https://"+startHost+"/ratefinder/fclhome?cc="+cc+"%26language="+clang;
	
	// INSIGHT
	INSIGHT_appName = "fclinsight";
	INSIGHT_stepURL = "https://"+startHost+"/insight/entrance/fcl_registration_landing_post.jsp";
	INSIGHT_afterURL = "https://"+startHost+"/insight/entrance/pre_entrance_post.jsp";
	
	//BILLING ONLINE
	FIO_appName = "fclfio";
	FIO_stepURL = "https://"+startHost+"/FedExMMA/jsp/FioStep3.jsp";
	FIO_afterURL = "https://"+startHost+"/FedExMMA/jsp/RegistrationRouter.jsp";
	
	//Pickup
	PICKUP_appName = "fclpickup";
	PICKUP_stepURL = "https://"+startHost+"/PickupApp/FCLStep3.jsp";
	PICKUP_afterURL = "https://"+startHost+"/PickupApp/scheduleExpressPickup.do?actionText=init%26locale="+cc+"_"+clang+"%26HIFlag=null%26programIndicator=4";
	
	//Freight
	FXF_appName = "fclfreight";
	FXF_stepURL = "https://www.fedexfreight.fedex.com/fclStep3.jsp";
	FXF_afterURL = "https://www.fedexfreight.fedex.com/fcllogin.do?programIndicator=3";
	
	//Freight National
	FNL_appName = "fclfreight";
	FNL_stepURL = "https://fnl.fedexnational.fedex.com/us/fclStep3.jsp";
	FNL_afterURL = "https://fnl.fedexnational.fedex.com/us/FCLLogon?programIndicator=3";
	
	if (document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "") {
		alert("Please select a Start Page.");
	} else {
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FIO") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+FIO_appName+"&locale="+locale+"&step3URL="+FIO_stepURL+"&afterwardsURL="+FIO_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FNL") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+FXF_appName+"&locale="+locale+"&step3URL="+FNL_stepURL+"&afterwardsURL="+FNL_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FXF") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+FXF_appName+"&locale="+locale+"&step3URL="+FXF_stepURL+"&afterwardsURL="+FXF_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "PICKUP") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+PICKUP_appName+"&locale="+locale+"&step3URL="+PICKUP_stepURL+"&afterwardsURL="+PICKUP_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "RATE") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+RATE_appName+"&locale="+locale+"&step3URL="+RATE_stepURL+"&afterwardsURL="+RATE_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "INSIGHT") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+INSIGHT_appName+"&locale="+locale+"&step3URL="+INSIGHT_stepURL+"&afterwardsURL="+INSIGHT_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "MFX") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+MFX_appName+"&locale="+locale+"&step3URL="+MFX_stepURL+"&afterwardsURL="+MFX_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "PleaseSelect") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+PleaseSelect_appName+"&locale="+locale+"&step3URL="+PleaseSelect_stepURL+"&afterwardsURL="+PleaseSelect_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "FSM") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+FSM_appName+"&locale="+locale+"&step3URL="+FSM_stepURL+"&afterwardsURL="+FSM_afterURL;
		}
		if(document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value == "GTM") {
			window.location="https://"+startHost+"/fcl/web/jsp/"+page+".jsp?appName="+GTM_appName+"&locale="+locale+"&step3URL="+GTM_stepURL+"&afterwardsURL="+GTM_afterURL;
		}
	}
}
function Save() {
	if(document.logonForm.remusrid.checked && document.logonForm.username.value != "") {
		setcookie('FCLID',document.logonForm.username.value,9125);
	} else {
		setcookie('FCLID',"",9125);
	}
	setcookie('FCL_START',document.logonForm.startpage.options[document.logonForm.startpage.selectedIndex].value,9125);
}
function addWSSInfo(name) {	
	if(name == '')return;
	self._ci = name;
	self._c1 = name;
	_hbSet('customerid',name);
	_hbSet('c1',name);
	_hbSend();
	return;
}
// End Login Module

// Start App Module
function togglediv1(divid){
	if(document.getElementById(divid).style.display == 'none'){
		document.getElementById(divid).style.display = 'inline'; 
		document.getElementById('locations_tab').style.display = 'none'; 
		document.getElementById('track_container').style.background = '#6d6d6d url(/images/homepage/activeTab_bg.gif) repeat-x scroll bottom left';
		document.getElementById('track_container').style.borderBottom = '#6d6d6d';
		document.getElementById('track_container').style.color = '#ffffff';
		document.getElementById('locations_container').style.background = '#ffffff url(/images/homepage/inactiveTab_bg.gif) repeat-x scroll bottom left'; 
		document.getElementById('locations_container').style.borderBottom = '#ffffff';
		document.getElementById('locations_container').style.color = '#666666';
	}
	else{
		if(document.getElementById('locations_tab')){
			document.getElementById('locations_tab').style.display = 'none'; 
			document.getElementById('locations_container').style.background = '#ffffff url(/images/homepage/inactiveTab_bg.gif) repeat-x scroll bottom left'; 
			document.getElementById('locations_container').style.borderBottom = '#ffffff';
			document.getElementById('locations_container').style.color = '#666666';
		}
		document.getElementById(divid).style.display = 'inline'; 
		document.getElementById('track_container').style.background = '#6d6d6d url(/images/homepage/activeTab_bg.gif) repeat-x scroll bottom left';
		document.getElementById('track_container').style.borderBottom = '#6d6d6d';
		document.getElementById('track_container').style.color = '#ffffff';
		
	}
}
function togglediv2(divid){
	if(document.getElementById(divid).style.display == 'none'){
		document.getElementById(divid).style.display = 'inline';
		document.getElementById('track_tab').style.display = 'none';
		document.getElementById('track_container').style.background = '#ffffff url(/images/homepage/inactiveTab_bg.gif) repeat-x scroll bottom left';
		document.getElementById('track_container').style.borderBottom = '#ffffff';
		document.getElementById('track_container').style.color = '#666666';
		document.getElementById('locations_container').style.background = '#6d6d6d url(/images/homepage/activeTab_bg.gif) repeat-x scroll bottom left'; 
		document.getElementById('locations_container').style.borderBottom = '#6d6d6d';
		document.getElementById('locations_container').style.color = '#ffffff';
	}
	else{
		document.getElementById('track_tab').style.display = 'none';
		document.getElementById('track_container').style.background = '#ffffff url(/images/homepage/inactiveTab_bg.gif) repeat-x scroll bottom left';
		document.getElementById('track_container').style.borderBottom = '#ffffff';
		document.getElementById('track_container').style.color = '#666666';
		document.getElementById('locations_container').style.display = 'inline';
		document.getElementById('locations_container').style.background = '#6d6d6d url(/images/homepage/activeTab_bg.gif) repeat-x scroll bottom left';		
		document.getElementById('locations_container').style.borderBottom = '#6d6d6d';
		document.getElementById('locations_container').style.color = '#ffffff';
	}
}
// End App Module

// BAG
function bag(){
	document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,16,0" width="540" height="206">\n');
	document.write('<param name="allowScriptAccess" value="always" />\n');
	document.write('<param name=movie value="/images/homepage/shell/bagShell.swf">\n');
	document.write('<param name=quality value=high>\n');
	document.write('<PARAM NAME=FlashVars VALUE="XMLPath=index_bag%2Exml&bagMenuPath=%2Fimages%2Fhomepage%2Fshell%2FbagMenu%2Eswf">\n');
	document.write('<param name="WMode" value="Transparent">\n');
	document.write('<embed src="/images/homepage/shell/bagShell.swf" WMode="Transparent" FlashVars="XMLPath=index_bag%2Exml&bagMenuPath=%2Fimages%2Fhomepage%2Fshell%2FbagMenu%2Eswf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="540" height="206" allowScriptAccess="always">\n');
	document.write('</embed>\n');
	document.write('</object>\n');
}

// Alert Box
function alertFlash(){
	document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,16,0" width="540" height="36">\n');
	document.write('<param name=movie value="/images/homepage/shell/alertMessage_.swf">\n');
	document.write('<param name=quality value=high>\n');
	document.write('<PARAM NAME=FlashVars VALUE="XMLPath=index_alert%2Exml">\n');
	document.write('<param name="WMode" value="Transparent">\n');
	document.write('<embed src="/images/homepage/shell/alertMessage_.swf" WMode="Transparent" FlashVars="XMLPath=index_alert%2Exml" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="540" height="36">\n');
	document.write('</embed>\n');
	document.write('</object>\n');
}

// Popup
function popUp(url,name,w,h){
	openwin = window.open(url,name,"height="+h+",width="+w+",resizable=yes,toolbar=no,location=no,scrollbars=yes,status=no");
	return false;
}

// Display Module
function displayModule(){
	var fclID = getcookie('FCLID');
	var fclStart = getcookie('FCL_START');
	if (fclStart != "" && fclStart != ";") {
		if (document.logonForm){
			for (var optn = 0;optn<document.logonForm.startpage.options.length;optn++) {
				if (document.logonForm.startpage.options[optn].value == fclStart) {
					document.logonForm.startpage.value=fclStart;				
				}
			}
			if (fclID != "" && fclID !=";") {
				document.logonForm.username.value=fclID;
				document.logonForm.remusrid.checked="true";
			}
		}
	}
	if(getcookie('fdx_login').length > 8) {
		hideID('nojavascript');
		hideID('login');
		hideID('newCustomerController');
		showID('logout');
	} else {
		hideID('nojavascript');
		showID('login');
		showID('newCustomerController');
	}
}
			
// Display Dropdown
var ddstate = new Array();
function displayDD(mn,am){
	var imgname = "img"+mn;
	var endname = mn+"end";
	if (((ddstate[mn] == 0)||(ddstate[mn]==undefined))&&(am == 1)){
		ddstate[mn] = 1;
		showID(mn);
		switch_dd(document.getElementById(imgname),1);
		document.getElementById(endname).scrollIntoView(true); 
	}
	else if ((ddstate[mn] == 1)&&(am == 2)){
		ddstate[mn] = 0;
		setTimeout(function(){hideID(mn)},500);
		setTimeout(function(){switch_dd(document.getElementById(imgname),0)},500);
	}
	else{
		ddstate[mn] = 0;
		hideID(mn);
		switch_dd(document.getElementById(imgname),0);
	}
}

// Switch Dropdown Arrow
function switch_dd(dimg,bool) {
	(bool) ? dimg.src="/images/homepage/dd_up.gif": dimg.src="/images/homepage/dd_down.gif";
}

// this function determines whether the event is the equivalent of the microsoft 
// mouseleave or mouseenter events. 
function isMouseLeaveOrEnter(e, handler) {
	if (e.type != 'mouseout' && e.type != 'mouseover') return false;
	var reltg = e.relatedTarget ? e.relatedTarget : e.type == 'mouseout' ? e.toElement : e.fromElement;
	while (reltg && reltg != handler) reltg = reltg.parentNode;
	return (reltg != handler); 
}
