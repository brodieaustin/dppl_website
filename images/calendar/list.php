<?php

	$dir    = $_GET['dir'] . '/';
	$files = scandir($dir);
	$file_list;

	for ($i = 0 ; $i < count($files) ; $i++){
		if ($files[$i] != '.' && $files[$i] != '..') {
			$file_list = $file_list . '<dl><dt>' . $files[$i]. '</dt><dd class="image"><img src="' . $dir . $files[$i] 
				. '" /></dd><dd>http://www.dppl.org/images/calendar/' . $dir . $files[$i] . '</dd><dd>' . round(filesize($dir . $files[$i])/1024) . ' bytes</dd><dd>'
				. 'Last changed on: ' . date("F j, Y, g:i a", filemtime($dir . $files[$i])) . '</dd></dl>';
		}
	}
	
	header('Content-Type: text/html; charset=utf-8');
	echo $file_list;

?>
