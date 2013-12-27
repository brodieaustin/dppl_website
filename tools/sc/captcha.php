<?php
session_start();
$_SESSION = array();

include("simple-php-captcha.php");
$_SESSION['captcha'] = captcha( array(
	'min_length' => 5,
	'max_length' => 8,
	'png_backgrounds' => array(dirname(__FILE__) . '/stripes.png'),
	'color' => '#333',
	'angle_min' => 5,
	'angle_max' => 15,
));
echo '<style>body{margin: 0; padding: 0;}.captcha-wrap{width: 300px; height:80px; position: relative;} #reload-captcha{display: block; position: absolute; bottom: 0; right: 0; height: 16px; width: 15px; padding: 5px; background: #fff url(reload.png) no-repeat center center;}</style>';
echo '<div class="captcha-wrap">';
echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
echo '<a href="javascript:void(0)" id="reload-captcha" title="Reload"></a>';
echo '</div>';
echo '<script>window.onload=function(){document.getElementById("reload-captcha").onclick=function(){window.location.reload();}}</script>';

?>
