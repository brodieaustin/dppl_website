<?php

	//require key and list class
	require('keys.php');
	require('class.BCList.php');
	
	//variables
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$dir = dirname(__FILE__) . '/files/';
	
	//assumes that pretty urls are used to pass parameters
	$params = array();
	$params = getParams($_SERVER['PATH_INFO']);
	
	
	//check if GET params have been passed, die if not
	if (!isset($params['api_key'])){
		die('You must provide an api key!');
	}
	elseif (!in_array($params['api_key'], $keys)){
		die('You did not provide a valid api key!');
	}
	else{
		if (!isset($params['id'])){
			die('You must provide a list ID!');
		}
		else{
			//if all params clear, create new list instance, get list, and respond as JSONP
			$list = new BCList($params['id']);
			$json = $list->getList($baseurl, $params['api_key'], $params['library'], $dir, $list->getID() . '.json');
		
			if ($json){
				header('Content-Type: application/json; charset=UTF-8');
				echo $_GET['jsoncallback'] . '(' . $json . ')';
			}
		}
	}
	
	//Function to created associative array from url params
	function getParams($path){
		$url_elements = explode('/', $path);
		array_shift($url_elements);

		$params = array();

		for ($i = 0; $i < count($url_elements); $i++){
			if ($i % 2 == 0){
				$params[$url_elements[$i]] = $url_elements[($i + 1)];
			}
		}
	
		return $params;
	}
	
?>
