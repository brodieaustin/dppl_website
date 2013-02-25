<?php
	session_start();
	
	echo $_SESSION['captcha']['code'];
	
	if ($_POST['challenge-text'] != $_SESSION['captcha']['code']){
		die('does not match');
	}
	else{
		foreach($_POST as $key => $val) {
			echo $key . ' ' . $val . '<br />';
		}
	}
?>
