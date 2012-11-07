<?php
	#get user counts then save to wordcount.json. run as chron every hour
	
	$users = array('brodieaustin', 'miriya-martell', 'grampaajt99', 'julia-christina', 'lorienquin', 
		'noemad', 'jennyjenn', 'ellieo', 'danae-maridakis', 'blossoming-bookworm', 'sinister-infant');
		
	$baseurl = 'http://www.nanowrimo.org/wordcount_api/wc/';
	$url = '';
	
	$count = 0;
	$data = '';
		
	for ($i = 0; $i < count($users); $i++){
		$url = $baseurl . $users[$i];
		
		$fh = simplexml_load_file($url);
		$count = $count +  $fh->user_wordcount;
	}
	
	$data =  '{"wordcount": "' . $count . '"}';
	
	#echo $data;
	
	$fh = fopen('wordcount.json', 'w');
	fwrite($fh, $data);
	fclose($fh);

?>
