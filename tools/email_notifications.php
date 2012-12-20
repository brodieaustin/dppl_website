<?php
	
	$response;
	$result;
	
	if (empty($_POST['BARCODE'])){
		die('Please enter your library card number! Refresh the page to start over.');
	}
	elseif (empty($_POST['PASSWORD'])){
		die('Please enter your password! Refresh the page to start over.');
	}
	elseif (empty($_POST['EMAIL1'])){
		die('Please enter your email address! Refresh the page to start over.');
	}
	else{
	
		//put the post values into an array, but drop the newsletter value
		$fields = array_map("htmlspecialchars", $_POST);
		unset($fields['newsletter']);
		
		//var_dump($fields);
		
		//turn array into query string with php function
		$query_string = http_build_query($fields);
		
		//echo $query_string;
		
		//make sure curl is available to process POST request
		if (!function_exists('curl_init')){
			die('Sorry cURL is not installed!');
		}
		
		//base url for request and intitialize curl
		$url = 'http://64.107.155.132:8080/cgi-bin/UpdateEmail.cgi';
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $query_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		
		//execute post
		$response = curl_exec($ch);

		//close connection
		curl_close($ch);
		
		preg_match("/<TITLE>(?'title'[a-zA-Z0-9 ]+)<\/TITLE>/", $response, $title);
		preg_match("/<CENTER>(?'message'[a-zA-Z0-9 ,-:;.!?<>@\r\n]+)<A /", $response, $matches);
		
		$result = $matches['message'];
		
		echo $result;
	}
?>
