<?php
    date_default_timezone_set('America/Chicago');
	$today = date("Y-m-d");
	$file_name = 'poems/' . $today . '.xml';
	
    if (file_exists($file_name)){
	    $xml = file_get_contents($file_name);
	}
	else{
		$url = strip_tags($_GET['url']);
		$xml = file_get_contents($url) or die('This isn\'t a valid URL!');
		
		if ($xml){
			$fh = fopen($file_name, 'w');
	        fwrite($fh, $xml);

	        fclose($fh);
		}
	}
	
	echo $xml;
	
?>
