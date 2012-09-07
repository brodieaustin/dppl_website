<?php
	require('key.php');
	require('class.User.php');
	require('class.UserList.php');
	
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$dir = dirname(__FILE__) . '/files/';
	$today = date("Y-m-d");
	
	//create new user
	$user = new User('84339150');
	$lists = $user->getUserLists($baseurl, $key, $dir, 'lists-' + today + '.json');
	
	//echo $lists;
	
	$jarray = jsonToArray($lists);
	
	var_dump($jarray);
	
	//helper functions
	function writeJSON($json, $dir, $file_name){
		$fh = fopen($dir . $file_name, 'w');
		fwrite($fh, $json);
	
		fclose($fh);
	}
	
	function jsonToArray($json){
		return json_decode($json, true);
	}
	
?>
