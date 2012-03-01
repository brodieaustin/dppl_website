<?php

	require_once('class.phpmailer.php');
	require_once('recaptchalib.php');
	require_once('files.php');
	
	$response = '';
	$fresponse = '';
	
	//Private key for recaptcha KEEP PRIVATE!
	$privatekey = "6LeiDM4SAAAAAClOOqtK8JtZSziXYYsl3474_l51";
	
	//create recaptcha request
	//$resp = recaptcha_check_answer ($privatekey,
    //                            $_SERVER["REMOTE_ADDR"],
    //                            $_POST["recaptcha_challenge_field"],
    //                            $_POST["recaptcha_response_field"]);
    
    //if (!$resp->is_valid) {
    	//What happens when the CAPTCHA was entered incorrectly
    //	die ("The reCAPTCHA wasn't entered correctly. Please try it again." . "(reCAPTCHA said: " . $resp->error . ")");
    //} 
    //else {                          
		
		//set up mail object with phpmailer class
		$mail = new PHPMailer();
	
		//make mail object an html mail object
		$mail->IsMail();
		$mail->CharSet="utf-8";
		$mail->IsHTML(true);
	
		//set the send TO address
		$to = "baustin@dppl.org";
		$mail->AddAddress($to, "Brodie Austin");
		
		//$to = "ckidd@dppl.org";
		//$mail->AddAddress($to, "Carol Kidd");
	
		//uses php function to check if email valid (not a real email address, just a valid form)
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	
			//santize the email address first
			$mail->From = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
			$mail->FromName = strip_tags($_POST['name']);
		
			//add a subject
			$mail->Subject = "A test email";
	
			//create a variable for the body (be sure to santize input)
			$body = "<h1>This is a test</h1>";
			$body .= "</p>" . $_POST['name'] . "</p>";
			$body .= "</ul>";
			$body .= "<li>" . $_POST['position'] . "</li>";
			$body .= "<li>" . $_POST['phone']. "</li>";
			$body .= "</ul>";
	
			$mail->Body = $body;
			
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
	
			//send the mail and test if it happened
			if ($mail->Send()){
				echo  "Thank you! Your form has been submited" . $fresponse;
			}
			else{
				echo $body . $fresponse;
				//echo "I'm sorry. Your message could not be sent due to an internal error. Please try again later.";
			}
		}
		else{
			die("I'm sorry. Your form was not sent due to an invalid email address. Please try again.");
		}
		
	//}
?>
