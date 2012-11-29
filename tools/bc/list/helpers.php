<?php
	//Function to created associative array from url params
	function getParams($path){
		$url_elements = explode('/', $path);
		array_shift($url_elements);

		$params = array();

		for ($i = 0; $i < count($url_elements); $i++){
			if ($i % 2 == 0){
				$params[$url_elements[$i]] = $url_elements[($i + 1)];
			}
		}
	
		return $params;
	}
?>
