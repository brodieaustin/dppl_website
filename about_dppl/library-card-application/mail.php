<?php

	require_once('class.phpmailer.php');
	//require_once('files.php');
	
	$response = '';
	$fresponse = '';
	
	$type = strip_tags($_POST['application-type']);
	
	if(empty($_POST['challenge-response'])){
		die("Please fill out the application form!");
	}
    elseif ($_POST['challenge-response'] != "16") {
    	//What happens when the challenge was entered incorrectly
    	die ("I'm sorry. The challenge question wasn't answered correctly. Please try it again.");
    } 
    else {
    	//quick checks to make sure required fields have been set
    	if (empty($_POST['last-name'])){ 
    		die("Please provide a name before submitting your application");
    	}
    	elseif (empty($_POST['address'])){ 
    		die("Please provide an address before submitting your application");
    	}
		elseif (empty($_POST['zipcode'])){ 
    		die("Please provide a zipcode before submitting your application");
    	}
		elseif (empty($_POST['home-phone'])){
    		die("Please provide a primary phone number before submitting your application");
    	}
		elseif (empty($_POST['date-of-birth'])){
    		die("Please provide a date of birth before submitting your application");
    	}
		elseif (($type == 'Child') && (empty($_POST['parent-name']))){
			die("Please provide a parent's name before submitting your application");
		}
		elseif (($type == 'Child') && empty($_POST['drivers-license'])){
			die("Please provide a drivers license before submitting your application");
		}
    	else{
		
			//set up mail object with phpmailer class
			$mail = new PHPMailer();
	
			//make mail object an html mail object
			$mail->IsMail();
			$mail->CharSet="utf-8";
			$mail->IsHTML(true);
	
			//set the send TO address
			$to = "librarycards@dppl.org";
			$mail->AddAddress($to, "Library Cards");
			
			$email = 'librarycards@dppl.org';
			$name = strip_tags($_POST['first-name']) . ' ' . strip_tags($_POST['last-name']);
	
			//uses php function to check if email valid (not a real email address, just a valid form)
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
	
				//santize the email address first
				$mail->From = filter_var($email, FILTER_SANITIZE_EMAIL);
				$mail->FromName = 'Library Cards';
				
				if ($_POST['send-copy'] == 'true'){
					$mail->AddBCC($email);
				}
				
		
				//add a subject
				$mail->Subject = "Library Card Application for " . $name;
	
				//create a variable for the body (be sure to santize input)
				$body = '<table><tbody>';
	
				foreach ($_POST as $key=>$value){
					 $body .= '<tr><td>' . makeLabel(strip_tags($key)) . ':</td><td>' . strip_tags($value) . '</td></tr>';
				 }

				$body .= '</tbody></table>';
				
	
				$mail->Body = $body;
				
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
					if ($type == 'Adult'){
						echo  "Thank you! Your form has been submitted. Give us <strong>3 days</strong> before you come to pick up your library card. Cards will be held for 1 month. Be sure to bring your photo ID and proof of current address when you come. We're excited to meet you!";
					}
					elseif ($type == 'Child'){
						echo "Thank you! Your form has been submitted. Give us <strong>3 days</strong> before you come to pick up your library card. Cards will be held for 1 month. Be sure to bring a photo ID and proof of current address when you come. Remember that the child's parent or guardian must be present to get the card. We're excited to meet you!";
					}
					else{
					 	echo "Thank you! Your form has been submitted. Give us 3 days before you come to pick up your library card. Cards will be held for 1 month. Be sure to bring your photo ID and proof of current address when you come.";
					 }
				}
				else{
					echo "I'm sorry. Your message could not be sent due to an internal error. Please try again later.";
				}
			}
			else{
				die("Your email address was not formatted properly. Please provide a valid email address.");
			}
		}
	}
	
	function makeLabel($val){
		$t = trim($val);
		$t = str_replace('-', ' ', $t);
		$t = ucwords($t);

		return $t;
	}
?>
