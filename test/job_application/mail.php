<?php

	require_once('class.phpmailer.php');
	require_once('recaptchalib.php');
	require_once('files.php');
	
	$response = '';
	$fresponse = '';
	
	//Private key for recaptcha KEEP PRIVATE!
	$privatekey = "6LeiDM4SAAAAAClOOqtK8JtZSziXYYsl3474_l51";
	
	//create recaptcha request
	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
    
    if (!$resp->is_valid) {
    	//What happens when the CAPTCHA was entered incorrectly
    	die ("The reCAPTCHA wasn't entered correctly. Please try it again." . "(reCAPTCHA said: " . $resp->error . ")");
    } 
    else {
    	//quick checks to make sure required fields have been set
    	if (empty($_POST['name'])){ 
    		die("Please provide a name before submitting your application");
    	}
    	elseif (empty($_POST['phone'])){ 
    		die("Please provide an email address before submitting your application");
    	}
    	elseif (empty($_POST['email'])){
    		die("Please provide a primary phone number before submitting your application");
    	}
    	elseif (empty($_POST['position'])){
    		die("Please select a position before submitting your application");
    	}
    	elseif (empty($_POST['agreement'])){
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
			
			$to = "brodie.austin@gmail.com";
			$mail->AddAddress($to, "Brodie Austin");
		
			//$to = "ckidd@dppl.org";
			//$mail->AddAddress($to, "Carol Kidd");
		
			//set variables from form values. Probably better way to do this, but this works for now
			$app_date = strip_tags($_POST['app-date']);
			$position = urldecode(strip_tags($_POST['position']));
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
				$body = '<table style="width: 100%; margin: 0; padding: 0; border: 0; font-family: sans-serif; font-size: 12px;">';
				$body .= '<tr>';
				$body .= '<td>';
				$body .= '<h1 style="font-size: 14px; text-transform: uppercase; border-bottom: 1px solid #000; margin-bottom: 15px; padding-bottom: 5px;">Employment Application</h1>';
				$body .= '<p style="margin-bottom: 10px; margin-right: 5px; margin-left: ">It is the policy of the Des Plaines Public Library to ensure equal opportunity for all individuals without regard to race, color, religion, sex, age, national origin, marital/veteran status/ disability or any other legally protected status in accordance with the requirements of local, state and federal law. Please complete all blanks or indicate "not applicable." Incomplete applications may be subject to rejection.</p>';
				$body .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold; font-size: 10px;">';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th style="width: 100%; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; text-align: left;" colspan="2">Background Information</th>';
				$body .= '</tr>';
				$body .= '</thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Full Name: * <br /><span style="font-weight: normal;">' . $name . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Date of Application <br /><span style="font-weight: normal;">' . $app_date . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" rowspan="2">Current Address (include Street, City, State, and Zip Code): <br /><span style="font-weight: normal;">' . $address_street . '</span><br /><span style="font-weight: normal;">' . $address_city . '</span>&nbsp;<span style="font-weight: normal;">' . $address_state . '</span>&nbsp;<span style="font-weight: normal;">' . $address_zip . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Primary Phone: *<br /><span style="font-weight: normal;">' . $phone . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Email Address:<br /><span style="font-weight: normal;">' . $email . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold; font-size: 10px;">';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th style="width: 100%; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; text-align: left;" colspan="2">Background Information</th>';
				$body .= '</tr>';
				$body .= '</thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Position applying for:<br /><span style="font-weight: normal;">' . $position . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Are you seeking (check appropriate):<br /><span style="font-weight: normal;">' . $worktype . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Date available:<br /><span style="font-weight: normal;">' . $date_avail . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">How were you referred to the Library?<br /><span style="font-weight: normal;">' . $refer_type . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Are you at last 18 years of age?<br /><span style="font-weight: normal;">' . $age . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Are you legally eligible for employment in the U.S.?<br /><span style="font-weight: normal;">' . $legal . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">If the position you are applying for requires a driver\'s license, please advise if you have a valid driver\'s license:<br /><span style="font-weight: normal;">' . $driver . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">What class is your license?<br /><span style="font-weight: normal;">' . $license_class . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Issuing State:<br /><span style="font-weight: normal;">' . $issue_state . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Have you ever been convicted of any violations of the law other than minor traffic violations?<br /><span style="font-weight: normal;">' . $violations . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">If you answered yes to the above, please explain:<br /><span style="font-weight: normal;">' . $violations_explain . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Were you previously employed by the Des Plaines Public Library?<br /><span style="font-weight: normal;">' . $prev_employed . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">If yes, what department?<br /><span style="font-weight: normal;">' . $prev_department . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Date of employment<br />From: <span style="font-weight: normal;">' . $prev_from . '</span>&nbsp;To: <span style="font-weight: normal;">' . $prev_to . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table style="width:100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold; font-size: 10px;">';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th style="width: 100%; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; text-align: left;"  colspan="5">Education</th>';
				$body .= '</tr>';
				$body .= '</thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Name of School attended & location (include Address, City, State)</td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Course of Study:</td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Last year completed</td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Did you graduate?</td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">List degree received:</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">High School:<br /><span style="font-weight: normal;">' . $high_school . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $hs_study . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $hs_years . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $hs_graduate . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $hs_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">College/University:<br /><span style="font-weight: normal;">' . $college . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $col_study . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $col_years . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $col_graduate . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $col_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Graduate School:<br /><span style="font-weight: normal;">' . $grad_school . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $grad_study . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $grad_years . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $grad_graduate . '</span</td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $grad_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Other (Specify):<br /><span style="font-weight: normal;">' . $other_school . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $other_study . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $other_years . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $other_graduate . '</span></td>';
				$body .= '<td style="width: 20%; vertical-align: text-top; border: 1px solid #000; padding: 5px;"><span style="font-weight: normal;">' . $other_degree . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold; font-size: 10px;">';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th style="width: 100%; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; text-align: left;" >Additional Job Related Qualifications</th>';
				$body .= '</tr>';
				$body .= '</thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Do you hold any certifcations and/or licenses?<br /><span style="font-weight: normal;">' . $license . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">If you answered yes to the above, please list:<br /><span style="font-weight: normal;">' . $license_list . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Please use this space to summarize any special job-related qualifications, training (including military or apprenticeship), computer skills, and/or experience which you feel should be considred in reviewing your application:<br /><span style="font-weight: normal;">' . $qualification . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #000; margin-bottom: 20px; font-weight: bold; font-size: 10px;">';
				$body .= '<thead>';
				$body .= '<tr>';
				$body .= '<th style="width: 100%; padding: 5px; background-color: #000; text-transform: uppercase; color: #fff; text-align: left;" colspan="2">Employment History</th>';
				$body .= '</tr>';
				$body .= '</thead>';
				$body .= '<tbody>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Are you presently employed?<br /><span style="font-weight: normal;">' . $employed . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">If yes, may we contact your employer?<br /><span style="font-weight: normal;">' . $contact_employer . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">List your present or most recent employer first. A resume will not substitute for completion of this portion of the application</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Employer One</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employer:<br /><span style="font-weight: normal;">' . $employer_one . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Address:<br /><span style="font-weight: normal;">' . $employer_one_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Telephone:<br /><span style="font-weight: normal;">' . $employer_one_tel . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Your title:<br /><span style="font-weight: normal;">' . $employer_one_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor:<br /><span style="font-weight: normal;">' . $employer_one_super . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor\'s Title:<br /><span style="font-weight: normal;">' . $employer_one_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Description of duties:<br /><span style="font-weight: normal;">' . $employer_one_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employed<br />From (mo/yr):<span style="font-weight: normal;">' . $employer_one_from . '</span>&nbsp;To (mo/yr):<span style="font-weight: normal;">' . $employer_one_to . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Last Salary:<br /><span style="font-weight: normal;">' . $employer_one_salary . '</span><br />Reason for leaving: <span style="font-weight: normal;">' . $employer_one_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Employer Two</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employer:<br /><span style="font-weight: normal;">' . $employer_two . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Address:<br /><span style="font-weight: normal;">' . $employer_two_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Telephone:<br /><span style="font-weight: normal;">' . $employer_two_tel . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Your title:<br /><span style="font-weight: normal;">' . $employer_two_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor:<br /><span style="font-weight: normal;">' . $employer_two_super . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor\'s Title:<br /><span style="font-weight: normal;">' . $employer_two_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Description of duties:<br /><span style="font-weight: normal;">' . $employer_two_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employed<br />From (mo/yr):<span style="font-weight: normal;">' . $employer_two_from . '</span>&nbsp;To (mo/yr):<span style="font-weight: normal;">' . $employer_two_to . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Last Salary:<br /><span style="font-weight: normal;">' . $employer_two_salary . '</span><br />Reason for leaving: <span style="font-weight: normal;">' . $employer_two_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Employer Three</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employer:<br /><span style="font-weight: normal;">' . $employer_three . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Address:<br /><span style="font-weight: normal;">' . $employer_three_add . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Telephone:<br /><span style="font-weight: normal;">' . $employer_three_tel . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Your title:<br /><span style="font-weight: normal;">' . $employer_three_title . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor:<br /><span style="font-weight: normal;">' . $employer_three_super . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Supervisor\'s Title:<br /><span style="font-weight: normal;">' . $employer_three_supertitle . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; vertical-align: text-top; border: 1px solid #000; padding: 5px;" colspan="2">Description of duties:<br /><span style="font-weight: normal;">' . $employer_three_duties . '</span></td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Employed<br />From (mo/yr):<span style="font-weight: normal;">' . $employer_three_from . '</span>&nbsp;To (mo/yr):<span style="font-weight: normal;">' . $employer_three_to . '</span></td>';
				$body .= '<td style="width: 50%; vertical-align: text-top; border: 1px solid #000; padding: 5px;">Last Salary:<br /><span style="font-weight: normal;">' . $employer_three_salary . '</span><br />Reason for leaving: <span style="font-weight: normal;">' . $employer_three_leaving . '</span></td>';
				$body .= '</tr>';
				$body .= '</tbody>';
				$body .= '</table>';
				$body .= '<p>Agreement: <span style="font-weight: normal;">' . $agreement . '</span></p>';
				$body .= '</td>';
				$body .= '</tr>';
				$body .= '</table>';
	
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
	}
?>
