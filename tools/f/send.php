<?php
    
    session_start();
   
    require_once('class.Challenge.php');
    require_once('class.Form.php');
	require_once('class.phpmailer.php');
    require_once('files.php');
	
    $response = '';
	$fresponse = '';
	
	if (!empty($_POST)){
	
	    $form = new Form($_POST['form-id']);
        $form->process_form($_POST);
	
	    $challenge = new Challenge($_SESSION['captcha']['code']);
	    $challenge->verify($form->fields['challenge-response']);
            
	
	    //set up mail object with phpmailer class
	    $mail = new PHPMailer();

	    //make mail object an html mail object
	    $mail->IsMail();
	    $mail->CharSet="utf-8";
	    $mail->IsHTML(true);
		

	    //set the send TO address
	    for ($i = 0; $i < count($form->recipients); $i++){
	        $mail->AddAddress($form->recipients[$i]['email'], $form->recipients[$i]['name']);
	    }
		    
        $mail->From = $form->sender['email'];
        $mail->FromName = $form->sender['name'];
		
        if ($_POST['send-copy'] == 'true'){
            $mail->AddBCC($form->sender);
        }
		
        //add a subject
       $mail->Subject = $form->subject;
        
        //set mail body from form body
       $mail->Body = $form->body;
			
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

		    $fresponse = handleFiles($mail, $files);
		    $fresponse = strlen($fresponse) > 0 ? '<br />' . $fresponse : '';
	    }//closes file if
		
	    //send the mail and test if it happened
	    if ($mail->Send()){
	        if (!empty($form->messages['success'])){
	            echo $form->messages['success'];
	        }
	        else{
		        echo  "Thank you! Your form has been submitted.";
		    }
	    }
	    else{
	        if (!empty($form->messages['error'])){
	            echo $form->messages['error'];
	        }
	        else{
		        echo "I'm sorry. Your message could not be sent due to an internal error. Please try again later.";
		    }
	    }
    }//closes post if	    
    else{
        die('Please complete the form before submitting.');
    }
?>
