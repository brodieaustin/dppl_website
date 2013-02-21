<?php

    require_once('class.Form.php');
	require_once('class.phpmailer.php');
	//require_once('files.php');
	
	$response = '';
	$fresponse = '';
	
	if (!empty($_POST)){
	
	    if(empty($_POST['challenge-response'])){
		    die("Please answer the form challenge.");
	    }
        elseif ($_POST['challenge-response'] != "16") {
        	//What happens when the challenge was entered incorrectly
        	die ("I'm sorry. The challenge question wasn't answered correctly. Please try it again.");
        } 
        else {
            $form = new Form($_POST('form-id'));
            $form->process_form();
	
		    //set up mail object with phpmailer class
		    $mail = new PHPMailer();

		    //make mail object an html mail object
		    $mail->IsMail();
		    $mail->CharSet="utf-8";
		    $mail->IsHTML(true);
		
		    //set the sender's email address (sometimes passed as hidden field from form)
		    $email = strip_tags($_POST['email']);

		    //set the send TO address
		    //$to = "baustin@dppl.org";
		    //$mail->AddAddress($to, "Brodie Austin");
		
		    $recipients = json_decode(str_replace('\'', '"', strip_tags($_POST['recipients'])));
		    var_dump($recipients);
		
		    foreach($recipients as $key => $val){
		        $to = $val;
		        $mail->AddAddress($to, $key);
		    }

		    //uses php function to check if email valid (not a real email address, just a valid form)
		    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                
                //try to catch any other bad stuff in email address
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                
			    $mail->From = $email;
			
			    if ($_POST['send-copy'] == 'true'){
				    $mail->AddBCC($email);
			    }
			
			    //add a subject
			    $mail->Subject = strip_tags($_POST['subject']);

			    //create a variable for the body (be sure to santize input)
			    $template = strip_tags($_POST['template']);
			    $body = file_get_contents('templates/' . $template);
			
			    foreach($_POST as $key => $val){
			        $body = str_replace('{' . $key . '}', nl2br(strip_tags($val)), $body);
			    }
			
			    echo $body;
			

			    /*$mail->Body = $body;
			
			    if (!empty($_FILES['formfiles'])){
				    //deal with attachments here
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
			
			    }
		

			    //send the mail and test if it happened
			    if ($mail->Send()){
				    echo  "Thank you! Your form has been submitted.";
			    }
			    else{
				    echo "I'm sorry. Your message could not be sent due to an internal error. Please try again later.";
			    }*/
		    }
		    else{
			    die("Your email address was not formatted properly. Please provide a valid email address.");
		    }
	    }
	}
    else{
        die('Please complete the form before submitting.');
    }
?>
