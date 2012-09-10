<?php
	require('key.php');
	require('class.User.php');
	require('class.UserList.php');
	
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$library = 'dppl';
	$dir = dirname(__FILE__) . '/files/';
	$today = date("Y-m-d");
	
	//create new user
	$user = new User('84339150', 'dppl');
	$lists = $user->getUserLists($baseurl, $key, $dir, $today . '.json');
	
	writeJSON($lists, $dir, $today . '.json');
	
	$jarray = jsonToArray($lists);
	
	$list_ids = array();
	$list_ids = $user->getUserListIDS($jarray, $list_ids);
	
	var_dump($list_ids);
	
	echo $user->getLibrary();
	
	foreach ($list_ids as $list_id){
		$list = new UserList($list_id);
		echo $list->getUserList($baseurl, $key, $user->getLibrary()) . '<br />';
	}
	
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
