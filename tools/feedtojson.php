<?php
    header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json; charset=UTF-8');
	
	//check if a url has been passed, decode if so, return error if not
	if ($_GET['url']){
		$url = urldecode($_GET['url']);
	}
	else{
		echo $_GET['jsoncallback'] . '({"item":[{"title":"There was no feed to process!"}]})';
		die();
	}
	
	//load feed file
	$feed = simplexml_load_file($url);
	
	//encode xml as json and echo back to ajax function as GET parameters
	echo $_GET['jsoncallback'] . '(' . json_encode($feed) . ')';
	

?>
