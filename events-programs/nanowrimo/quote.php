<?php
	
	$fh =  file_get_contents($_GET['url']);
	
	echo $_GET['callback'] . $fh;
	
?>
