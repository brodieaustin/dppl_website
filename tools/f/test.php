<?php
     ini_set('display_errors', 'On');

    session_start();
   
    require_once('class.Challenge.php');
    require_once('class.Form.php');
	require_once('class.phpmailer.php');
    require_once('files.php');
    
    $form = new Form($_POST['form-id'], false);
    $form->process_form($_POST);

?>
