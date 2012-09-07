<?php
	require('key.php');
	echo date('y-m-d h:m:s');
	echo '<br />';
	
	//environment variables
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$user = '84339150';
	$today = date("Y-m-d");
	$dir = dirname(__FILE__) . '/files/';
	$file_name = $today . '.json';
	
	if (file_exists($dir . $file_name)){
		$json = file_get_contents($dir . $file_name);

		echo ' file already exists<br />' . $dir . $file_name;
	}
	else{
		$url = $baseurl . 'users/' . $user . '/lists?api_key=' . $key;
		$json = file_get_contents($url) or die('nope');

		$today = date("Y-m-d"); 
	
		$fh = fopen($dir . $file_name, 'w');
		fwrite($fh, $json);
	
		fclose($fh);
		
		echo 'created file<br />';
	}
	
	echo '<br />';
	
	$jarray = json_decode($json, true);
	
	//foreach ($jarray['lists'] as $list){
		//echo $list['id'] . '<br />';
	//}
	
	$list = $jarray['lists'][0];
	$id = $list['id'];
	
	$file_name = $id . '.json';
	
	if (file_exists($dir . $file_name)){
		$json = file_get_contents($dir . $file_name);

		echo ' file already exists<br />' . $dir . $file_name;
	}
	else{
		$url = $baseurl . 'lists/' . $id . '?api_key=' . $key;
		$json = file_get_contents($url) or die('nope');
	
		$fh = fopen($dir . $file_name, 'w');
		fwrite($fh, $json);
	
		fclose($fh);
		
		echo 'created file<br />';
	}
	
	
	$jarray = json_decode($json, true);
	
	echo '<br />';
	if ($list['updated'] == $jarray['list']['updated']){
		echo 'list up to date';
	}
	else{
		echo 'list not up to date';
	}
	
	echo '<br />';
	var_dump($jarray);
	
	
?>
