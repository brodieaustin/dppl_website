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
    
    	//quick checks to make sure required fields have been set
    	if (!isset($_POST['name'])){ //check name
    		die("Please provide a name before submitting your application");
    	}
    	elseif (!isset($_POST['email'])){ //check email
    		die("Please provide an email address before submitting your application");
    	}
    	elseif (!isset($_POST('phone')){
    		die("Please provide a primary phone number before submitting your application");
    	}
    	elseif (!isset($_POST['position'])){
    		die("Please select a position before submitting your application");
    	}
    	elseif (!isset($_POST['agreement'])){
    		die("Please respond to the application agreement before submitting your application");
    	}
    	else{
		
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
		
			//set variables from form values. Probably better way to do this, but this works for now
			$app_date = strip_tags($_POST['app-date']);
			$position = strip_tags($_POST['position']);
			$name = strip_tags($_POST['name']);
			$address_street = strip_tags($_POST['address-street']);
			$address_city = strip_tags($_POST['address-city']);
			$address_state = strip_tags($_POST['address-state']);
			$address_zip = strip_tags($_POST['address-zip']);
			$phone = strip_tags($_POST['phone']);
			$email = strip_tags($_POST['email']);
			$worktype = strip_tags($_POST['worktype']);
			$date_avail = strip_tags($_POST['date-avail']);
			$refer_type = strip_tags($_POST['refer-type']);
			$refer_other = strip_tags($_POST['refer-other']);
			$age = strip_tags($_POST['age']);
			$legal = strip_tags($_POST['legal']);
			$driver = strip_tags($_POST['driver']);
			$license_class = strip_tags($_POST['license-class']);
			$issue_state = strip_tags($_POST['issue-state']);
			$violations = strip_tags($_POST['violations']);
			$violations_explain = strip_tags($_POST['violations-explain']);
			$prev_employed = strip_tags($_POST['prev-employed']);
			$prev_department = strip_tags($_POST['prev-department']);
			$prev_from = strip_tags($_POST['prev-from']);
			$prev_to = strip_tags($_POST['prev-to']);
			$high_school = strip_tags($_POST['high-school']);
			$hs_study = strip_tags($_POST['hs-study']);
			$hs_years = strip_tags($_POST['hs-years']);
			$hs_graduate = strip_tags($_POST['hs-graduate']);
			$hs_degree = strip_tags($_POST['hs-degree']);
			$college = strip_tags($_POST['college']);
			$col_study = strip_tags($_POST['col-study']);
			$col_years = strip_tags($_POST['col-years']);
			$col_graduate = strip_tags($_POST['col-graduate']);
			$col_degree = strip_tags($_POST['col-degree']);
			$grad_school = strip_tags($_POST['grad-school']);
			$grad_study = strip_tags($_POST['grad-study']);
			$grad_years = strip_tags($_POST['grad-years']);
			$grad_graduate = strip_tags($_POST['grad-graduate']);
			$grad_degree = strip_tags($_POST['grad-degree']);
			$other_school = strip_tags($_POST['other-school']);
			$other_study = strip_tags($_POST['other-study']);
			$other_years = strip_tags($_POST['other-years']);
			$other_graduate = strip_tags($_POST['other-graduate']);
			$other_degree = strip_tags($_POST['other-degree']);
			$license = strip_tags($_POST['license']);
			$license_list = strip_tags($_POST['license-list']);
			$qualification = strip_tags($_POST['qualification']);
			$employed = strip_tags($_POST['employed']);
			$contact_employer = strip_tags($_POST['contact-employer']);
			$employer_one = strip_tags($_POST['employer-one']);
			$employer_one_add = strip_tags($_POST['employer-one-add']);
			$employer_one_tel = strip_tags($_POST['employer-one-tel']);
			$employer_one_title = strip_tags($_POST['employer-one-title']);
			$employer_one_super = strip_tags($_POST['employer-one-super']);
			$employer_one_supertitle = strip_tags($_POST['employer-one-supertitle']);
			$employer_one_duties = strip_tags($_POST['employer-one-duties']);
			$employer_one_from = strip_tags($_POST['employer-one-from']);
			$employer_one_to = strip_tags($_POST['employer-one-to']);
			$employer_one_salary = strip_tags($_POST['employer-one-salary']);
			$employer_one_leaving = strip_tags($_POST['employer-one-leaving']);
			$employer_two = strip_tags($_POST['employer-two']);
			$employer_two_add = strip_tags($_POST['employer-two-add']);
			$employer_two_tel = strip_tags($_POST['employer-two-tel']);
			$employer_two_title = strip_tags($_POST['employer-two-title']);
			$employer_two_super = strip_tags($_POST['employer-two-super']);
			$employer_two_supertitle = strip_tags($_POST['employer-two-supertitle']);
			$employer_two_duties = strip_tags($_POST['employer-two-duties']);
			$employer_two_from = strip_tags($_POST['employer-two-from']);
			$employer_two_to = strip_tags($_POST['employer-two-to']);
			$employer_two_salary = strip_tags($_POST['employer-two-salary']);
			$employer_two_leaving = strip_tags($_POST['employer-two-leaving']);
			$employer_three = strip_tags($_POST['employer-three']);
			$employer_three_add = strip_tags($_POST['employer-three-add']);
			$employer_three_tel = strip_tags($_POST['employer-three-tel']);
			$employer_three_title = strip_tags($_POST['employer-three-title']);
			$employer_three_super = strip_tags($_POST['employer-three-super']);
			$employer_three_supertitle = strip_tags($_POST['employer-three-supertitle']);
			$employer_three_duties = strip_tags($_POST['employer-three-duties']);
			$employer_three_from = strip_tags($_POST['employer-three-from']);
			$employer_three_to = strip_tags($_POST['employer-three-to']);
			$employer_three_salary = strip_tags($_POST['employer-three-salary']);
			$employer_three_leaving = strip_tags($_POST['employer-three-leaving']);
			$employer_four = strip_tags($_POST['employer-four']);
			$employer_four_add = strip_tags($_POST['employer-four-add']);
			$employer_four_tel = strip_tags($_POST['employer-four-tel']);
			$employer_four_title = strip_tags($_POST['employer-four-title']);
			$employer_four_super = strip_tags($_POST['employer-four-super']);
			$employer_four_supertitle = strip_tags($_POST['employer-four-supertitle']);
			$employer_four_duties = strip_tags($_POST['employer-four-duties']);
			$employer_four_from = strip_tags($_POST['employer-four-from']);
			$employer_four_to = strip_tags($_POST['employer-four-to']);
			$employer_four_salary = strip_tags($_POST['employer-four-salary']);
			$employer_four_leaving = strip_tags($_POST['employer-four-leaving']);
			$agreement = strip_tags($_POST['agreement']);
	
			//uses php function to check if email valid (not a real email address, just a valid form)
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
	
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
				die("Your email address was not formatted properly. Please provide a valid email address.");
			}
		}
	//}
?>
