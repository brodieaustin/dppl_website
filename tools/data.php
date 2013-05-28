<?php
	
	$fh =  file_get_contents($_GET['url']);
	
	if ($_GET['format'] == 'json'){
	    //set the response header so browser recognizes json
	    header('Content-Type: application/json; charset=UTF-8');
	    echo $_GET['jsoncallback'] . '(' . $fh . ')';
	}
	else{
	    echo $fh;
    }
	
?>
