<?php
	//require key and list class
	require('keys.php');
	require('helpers.php');
	require('class.BCList.php');
	
	//variables
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$dir = dirname(__FILE__) . '/files/';
	
	//assumes that pretty urls are used to pass parameters
	$params = array();
	$params = getParams($_SERVER['PATH_INFO']);
	var_dump($params);
	
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
		}
	}
?>
