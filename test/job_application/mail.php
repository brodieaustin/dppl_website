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
    	/*if (!isset($_POST['name'])){ 
    		die("Please provide a name before submitting your application");
    	}
    	elseif (!isset($_POST['email'])){ 
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
    	else{*/
		
			//set up mail object with phpmailer class
			$mail = new PHPMailer();
	
			//make mail object an html mail object
			$mail->IsMail();
			$mail->CharSet="utf-8";
			$mail->IsHTML(true);
	
			//set the send TO address
			$to = "baustin@dppl.org";
			$mail->AddAddress($to, "Brodie Austin");
			
			$to = "brodie.austin@gmail.com";
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
			$high_school = nl2br(strip_tags($_POST['high-school']));
			$hs_study = strip_tags($_POST['hs-study']);
			$hs_years = strip_tags($_POST['hs-years']);
			$hs_graduate = strip_tags($_POST['hs-graduate']);
			$hs_degree = strip_tags($_POST['hs-degree']);
			$college = nl2br(strip_tags($_POST['college']));
			$col_study = strip_tags($_POST['col-study']);
			$col_years = strip_tags($_POST['col-years']);
			$col_graduate = strip_tags($_POST['col-graduate']);
			$col_degree = strip_tags($_POST['col-degree']);
			$grad_school = nl2br(strip_tags($_POST['grad-school']));
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
			$license_list = nl2br(strip_tags($_POST['license-list']));
			$qualification = nl2br(strip_tags($_POST['qualification']));
			$employed = strip_tags($_POST['employed']);
			$contact_employer = strip_tags($_POST['contact-employer']);
			$employer_one = strip_tags($_POST['employer-one']);
			$employer_one_add = nl2br(strip_tags($_POST['employer-one-add']));
			$employer_one_tel = strip_tags($_POST['employer-one-tel']);
			$employer_one_title = strip_tags($_POST['employer-one-title']);
			$employer_one_super = strip_tags($_POST['employer-one-super']);
			$employer_one_supertitle = strip_tags($_POST['employer-one-supertitle']);
			$employer_one_duties = nl2br(strip_tags($_POST['employer-one-duties']));
			$employer_one_from = strip_tags($_POST['employer-one-from']);
			$employer_one_to = strip_tags($_POST['employer-one-to']);
			$employer_one_salary = strip_tags($_POST['employer-one-salary']);
			$employer_one_leaving = strip_tags($_POST['employer-one-leaving']);
			$employer_two = strip_tags($_POST['employer-two']);
			$employer_two_add = nl2br(strip_tags($_POST['employer-two-add']));
			$employer_two_tel = strip_tags($_POST['employer-two-tel']);
			$employer_two_title = strip_tags($_POST['employer-two-title']);
			$employer_two_super = strip_tags($_POST['employer-two-super']);
			$employer_two_supertitle = strip_tags($_POST['employer-two-supertitle']);
			$employer_two_duties = nl2br(strip_tags($_POST['employer-two-duties']));
			$employer_two_from = strip_tags($_POST['employer-two-from']);
			$employer_two_to = strip_tags($_POST['employer-two-to']);
			$employer_two_salary = strip_tags($_POST['employer-two-salary']);
			$employer_two_leaving = strip_tags($_POST['employer-two-leaving']);
			$employer_three = strip_tags($_POST['employer-three']);
			$employer_three_add = nl2br(strip_tags($_POST['employer-three-add']));
			$employer_three_tel = strip_tags($_POST['employer-three-tel']);
			$employer_three_title = strip_tags($_POST['employer-three-title']);
			$employer_three_super = strip_tags($_POST['employer-three-super']);
			$employer_three_supertitle = strip_tags($_POST['employer-three-supertitle']);
			$employer_three_duties = nl2br(strip_tags($_POST['employer-three-duties']));
			$employer_three_from = strip_tags($_POST['employer-three-from']);
			$employer_three_to = strip_tags($_POST['employer-three-to']);
			$employer_three_salary = strip_tags($_POST['employer-three-salary']);
			$employer_three_leaving = strip_tags($_POST['employer-three-leaving']);
			$employer_four = strip_tags($_POST['employer-four']);
			$employer_four_add = nl2br(strip_tags($_POST['employer-four-add']));
			$employer_four_tel = strip_tags($_POST['employer-four-tel']);
			$employer_four_title = strip_tags($_POST['employer-four-title']);
			$employer_four_super = strip_tags($_POST['employer-four-super']);
			$employer_four_supertitle = strip_tags($_POST['employer-four-supertitle']);
			$employer_four_duties = nl2br(strip_tags($_POST['employer-four-duties']));
			$employer_four_from = strip_tags($_POST['employer-four-from']);
			$employer_four_to = strip_tags($_POST['employer-four-to']);
			$employer_four_salary = strip_tags($_POST['employer-four-salary']);
			$employer_four_leaving = strip_tags($_POST['employer-four-leaving']);
			$agreement = strip_tags($_POST['agreement']);
	
			//uses php function to check if email valid (not a real email address, just a valid form)
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
	
				//santize the email address first
				$mail->From = filter_var($email, FILTER_SANITIZE_EMAIL);
				$mail->FromName = $name;
		
				//add a subject
				$mail->Subject = "A test email";
	
				//create a variable for the body (be sure to santize input)
				$body = '<html>';
				$body .= '<head>';
				$body .= '<style>';
				$body .= '*{font-family: sans-serif; font-size: 9pt; margin: 0; padding: 0;}';
				$body .= 'body {width: 800px; margin: 1em; padding: 1em;}';
				$body .= 'h1 {font-size: 12pt; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 15px; font-weight: bold;}';
				$body .= 'p {font-size: 10pt; margin: 15px 5px;}';
				$body .= 'table {width: 800px; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold;}';
				$body .= 'th {width: 790px; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; font-weight: bold; text-align: left;}';
				$body .= 'td {vertical-align: text-top; width: 50%; height: 20px; border: 1px solid #000; padding: 5px;}';
				$body .= 'td.full {width: 790px;}';
				$body .= 'form {float: right; width: 40%;}';
				$body .= 'i {font-style: oblique;}';
				$body .= 'input {margin-left: 30px;}';
				$body .= '.response{font-weight:normal;}';
				$body .= '</style>';
				$body .= '</head>';
				$body .= '<body>';
				$body .= '<h1>Employment Application</h1>';
				$body .= '<p>It is the policy of the Des Plaines Public Library to ensure equal opportunity for all individuals without regard to race, color, religion, sex, age, national origin, marital/veteran status/ disability or any other legally protected status in accordance with the requirements of local, state and federal law. Please complete all blanks or indicate "not applicable." Incomplete applications may be subject to rejection.</p>';
				$body .= '<table>';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th colspan="2">Personal Information</th>';
				$body .= '</tr>';
				$body .= '<thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td>Full Name: * <br /><span class="response">' . $name . '</span></td>';
				$body .= '<td>Date of Application <br /><span class="response">' . $app_date . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td rowspan="3">Current Address (include Street, City, State, and Zip Code): <br /><span class="response">' . $address_street . '</span><br /><span class="response">' . $address_city . '</span>,&nbsp;<span class="response">' . $address_state . '</span>&nbsp;<span class="response">' . $address_zip . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Primary Phone: *<br /><span class="response">' . $phone . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Email Address:<br /><span class="response">' . $email . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table>';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th colspan="2">Background Information</th>';
				$body .= '</tr>';
				$body .= '<thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td colspan="2">Position applying for:<br /><span class="response">' . $position . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">Are you seeking (check appropriate):<br /><span class="response">' . $worktype . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">Date available:<br /><span class="response">' . $date_avail . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">How were you referred to the Library?<br /><span class="response">' . $refer_type . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Are you at last 18 years of age?<br /><span class="response">' . $age . '</span></td>';
				$body .= '<td>Are you legally eligible for employment in the U.S.?<br /><span class="response">' . $legal . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">If the position you are applying for requires a driver\'s license, please advise if you have a valid driver\'s license:<br /><span class="response">' . $driver . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>What class is your license?<br /><span class="response">' . $license_class . '</span></td>';
				$body .= '<td>Issuing State:<br /><span class="response">' . $issue_state . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">Have you ever been convicted of any violations of the law other than minor traffic violations?<br /><span class="response">' . $violations . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">If you answered yes to the above, please explain:<br /><span class="response">' . $violations_explain . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">Were you previously employed by the Des Plaines Public Library?<br /><span class="response">' . $prev_employed . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>If yes, what department?<br /><span class="response">' . $prev_department . '</span></td>';
				$body .= '<td>Date of employment<br />From: <span class="response">' . $prev_from . '</span>&nbsp;To: <span class="response">' . $prev_to . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table>';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th colspan="5">Education</th>';
				$body .= '</tr>';
				$body .= '<thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td>Name of School attended & location (include Address, City, State)</td>';
				$body .= '<td>Course of Study:</td>';
				$body .= '<td>Last year completed</td>';
				$body .= '<td>Did you graduate?</td>';
				$body .= '<td>List degree received:</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>High School:<br /><span class="response">' . $high_school . '</span></td>';
				$body .= '<td><span class="response">' . $hs_study . '</span></td>';
				$body .= '<td><span class="response">' . $hs_years . '</span></td>';
				$body .= '<td><span class="response">' . $hs_graduate . '</span></td>';
				$body .= '<td><span class="response">' . $hs_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>College/University:<br /><span class="response">' . $college . '</span></td>';
				$body .= '<td><span class="response">' . $col_study . '</span></td>';
				$body .= '<td><span class="response">' . $col_years . '</span></td>';
				$body .= '<td><span class="response">' . $col_graduate . '</span></td>';
				$body .= '<td><span class="response">' . $col_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Graduate School:<br /><span class="response">' . $grad_school . '</span></td>';
				$body .= '<td><span class="response">' . $grad_study . '</span></td>';
				$body .= '<td><span class="response">' . $grad_years . '</span></td>';
				$body .= '<td><span class="response">' . $grad_graduate . '</span</td>';
				$body .= '<td><span class="response">' . $grad_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Other (Specify):<br /><span class="response">' . $other_school . '</span></td>';
				$body .= '<td><span class="response">' . $other_study . '</span></td>';
				$body .= '<td><span class="response">' . $other_years . '</span></td>';
				$body .= '<td><span class="response">' . $other_graduate . '</span></td>';
				$body .= '<td><span class="response">' . $other_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table>';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th>Additional Job Related Qualifications</th>';
				$body .= '</tr>';
				$body .= '<thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td>Do you hold any certifcations and/or licenses?<br /><span class="response">' . $license . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>If you answered yes to the above, please list:<br /><span class="response">' . $license_list . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Please use this space to summarize any special job-related qualifications, training (including military or apprenticeship), computer skills, and/or experience which you feel should be considred in reviewing your application:<br /><span class="response">' . $qualification . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table>';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th colspan="5">Employment History</th>';
				$body .= '</tr>';
				$body .= '<thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td>Are you presently employed?<br /><span class="response">' . $employed . '</span></td>';
				$body .= '<td>If yes, may we contact your employer?<br /><span class="response">' . $contact_employer . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">List your present or most recent employer first. A resume will not substitute for completion of this portion of the application</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employer:<br /><span class="response">' . $employer_one . '</span></td>';
				$body .= '<td>Address:<br /><span class="response">' . $employer_one_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Telephone:<br /><span class="response">' . $employer_one_tel . '</span></td>';
				$body .= '<td>Your title:<br /><span class="response">' . $employer_one_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Supervisor:<br /><span class="response">' . $employer_one_super . '</span></td>';
				$body .= '<td>Supervisor\'s Title:<br /><span class="response">' . $employer_one_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<td colspan="2">Description of duties:<br /><span class="response">' . $employer_one_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employed<br />From (mo/yr):<span class="response">' . $employer_one_from . '</span>&nbsp;To (mo/yr):<span class="response">' . $employer_one_to . '</span></td>';
				$body .= '<td>Last Salary:<br /><span class="response">' . $employer_one_salary . '</span>';
				$body .= '<br />Reason for leaving: <span class="response">' . $employer_one_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">&nbsp;</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employer:<br /><span class="response">' . $employer_two . '</span></td>';
				$body .= '<td>Address:<br /><span class="response">' . $employer_two_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Telephone:<br /><span class="response">' . $employer_two_tel . '</span></td>';
				$body .= '<td>Your title:<br /><span class="response">' . $employer_two_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Supervisor:<br /><span class="response">' . $employer_two_super . '</span></td>';
				$body .= '<td>Supervisor\'s Title:<br /><span class="response">' . $employer_two_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<td colspan="2">Description of duties:<br /><span class="response">' . $employer_two_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employed<br />From (mo/yr):<span class="response">' . $employer_two_from . '</span>&nbsp;To (mo/yr):<span class="response">' . $employer_two_to . '</span></td>';
				$body .= '<td>Last Salary:<br /><span class="response">' . $employer_two_salary . '</span>';
				$body .= '<br />Reason for leaving: <span class="response">' . $employer_two_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td colspan="2">&nbsp;</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employer:<br /><span class="response">' . $employer_three . '</span></td>';
				$body .= '<td>Address:<br /><span class="response">' . $employer_three_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Telephone:<br /><span class="response">' . $employer_three_tel . '</span></td>';
				$body .= '<td>Your title:<br /><span class="response">' . $employer_three_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Supervisor:<br /><span class="response">' . $employer_three_super . '</span></td>';
				$body .= '<td>Supervisor\'s Title:<br /><span class="response">' . $employer_three_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<td colspan="2">Description of duties:<br /><span class="response">' . $employer_three_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td>Employed<br />From (mo/yr):<span class="response">' . $employer_three_from . '</span>&nbsp;To (mo/yr):<span class="response">' . $employer_three_to . '</span></td>';
				$body .= '<td>Last Salary:<br /><span class="response">' . $employer_three_salary . '</span>';
				$body .= '<br />Reason for leaving: <span class="response">' . $employer_three_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<p>Agreement: <span class="response">' . $agreement . '</span></p>';
				$body .= '</body>';
	
				$mail->Body = $body;
			
				//deal with attachments here
				//create an array for the files sent
				/*$files = array();
	
				//loop through files and build up array using key/values
				foreach ($_FILES['formfiles'] as $k => $l){
					foreach ($l as $i => $v){
						if (!array_key_exists($i, $files))
						$files[$i] = array();
						$files[$i][$k] = $v;
					}
				}
			
				$fresponse = handleFiles($mail, $files);
				$fresponse = strlen($fresponse) > 0 ? '<br />' . $fresponse : '';*/
	
				//send the mail and test if it happened
				if ($mail->Send()){
					echo  "Thank you! Your form has been submited" . $fresponse;
				}
				else{
					//echo $body . $fresponse;
					echo "I'm sorry. Your message could not be sent due to an internal error. Please try again later.";
				}
			}
			else{
				die("Your email address was not formatted properly. Please provide a valid email address.");
			}
		//}
	//}
?>
