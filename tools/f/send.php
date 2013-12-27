<?php
    session_start();

    date_default_timezone_set('America/Chicago');
   
    require_once('class.Challenge.php');
    require_once('class.Form.php');
	require_once('phpmailer/PHPMailerAutoload.php');
    require_once('files.php');
	
    $status;
    $message;
	$fresponse;
	$ajax;
	
	/*if ($_SERVER["HTTP_X_REQUESTED_WITH"]){
	    $ajax = true;
    }
    else{
        $ajax = false;
    }*/
    
    $ajax = true;
	
	if (!empty($_POST)){
	
	    $form = new Form($_POST['form-id'], $ajax);
        $form->process_form($_POST);
	
	    $challenge = new Challenge($_SESSION['captcha']['code'], $ajax);
	    $challenge->verify($form->fields['challenge-response']);
            
	
	    //set up mail object with phpmailer class
	    $mail = new PHPMailer();

	    //make mail object an html mail object
	    $mail->Mailer = 'sendmail';
	    $mail->CharSet="utf-8";
		

	    //set the send TO address
	    for ($i = 0; $i < count($form->recipients); $i++){
	        $mail->AddAddress($form->recipients[$i]['email'], $form->recipients[$i]['name']);
	    }
        
        if (isset($_POST['send-copy'])){
            if ($_POST['send-copy'] == 'true'){
                $mail->AddCC($form->sender['email']);
            }
        }
		    
        $mail->From = $form->sender['email'];
        $mail->FromName = $form->sender['name'];
		
        //add a subject
       $mail->Subject = $form->subject;
        
        //set mail body from form body
       $mail->msgHTML = $form->body;
			
		//deal with attachments here
	   if (!empty($_FILES['formfiles'])){
		    
		    //create an array for the files sent
		    $files = array();

		    //loop through files and build up array using key/values
		    foreach ($_FILES['formfiles'] as $k => $l){
			    foreach ($l as $i => $v){
				    if (!array_key_exists($i, $files))
				    $files[$i] = array();
				    $files[$i][$k] = $v;
			    }
		    }

		    $fresponse = handleFiles($mail, $files, $ajax);
	    }//closes file if
		
	    //send the mail and test if it happened
	  if ($mail->Send()){
	       $status = 'success';
	       if (!empty($form->messages['success'])){
	            $message = $form->messages['success'] . (isset($fresponse)?$fresponse:'');
	        }
	        else{
		        $message = "Thank you! Your form has been submitted." . (isset($fresponse)?$fresponse:'');
		    }
	    }
	    else{
	        $status = 'failure';
	        if (!empty($form->messages['failure'])){
	            $message = $form->messages['failure'];
	        }
	        else{
		        $message = "I'm sorry. Your form could not be sent due to an internal error. Please try again later.";
		    }
	    }
    }//closes post if	    
    else{
        $status = 'failure';
        $message = 'Please complete the form before submitting.';
    }
    
    $form->set_response($status, $message);
    $form->render_response();
    
?>
