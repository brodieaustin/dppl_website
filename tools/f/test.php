<?php
    session_start();
   
    require_once('class.Challenge.php');
    require_once('class.Form.php');
	require_once('class.phpmailer.php');
    require_once('files.php');
    
    $form = new Form($_POST['form-id']);
    $form->process_form($_POST);  
    
    echo count($form->recipients);
    
     //set the send TO address
     //var_dump($form->recipients);
	   echo $form->sender;
	   echo $form->sender_name;
    
?>
