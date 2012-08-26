<?php
	echo date('y-m-d h:m:s');
	//environment variables
	$key = '6vuvh66tx8evnz9b3r768gfh';
	$baseurl = 'https://api.bibliocommons.com/v1/';
	$user = '84339150';
	$today = date("Y-m-d");
	$dir = 'files/';
	$file_name = $today . '.json';
	
	if (file_exists($dir . $file_name)){
		$json = file_get_contents($dir . $file_name);

		echo ' file already exists<br />';
	}
	else{
		$url = $baseurl . 'users/' . $user . '/lists?api_key=' . $key;
		$json = file_get_contents($url) or die('nope');

		$today = date("Y-m-d"); 
	
		$fh = fopen($dir . $file_name, 'w');
		fwrite($fh, $response);
	
		fclose($fh);
		
		echo 'created file';
	}
	
	$jarray = json_decode($json, true);
	var_dump($jarray);
	
	echo $lists;
	
?>
