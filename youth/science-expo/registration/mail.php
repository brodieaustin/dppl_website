<?php

	require_once('class.phpmailer.php');
	//require_once('files.php');
	
	$response = '';
	$fresponse = '';
	
	if(empty($_POST['challenge-response'])){
		die("Please fill out the application form!");
	}
    elseif ($_POST['challenge-response'] != "16") {
    	//What happens when the challenge was entered incorrectly
    	die ("I'm sorry. The challenge question wasn't answered correctly. Please try it again.");
    } 
    else {
    	//quick checks to make sure required fields have been set
    	if (empty($_POST['name'])){ 
    		die("Please provide a name before submitting your application");
    	}
    	elseif (empty($_POST['email'])){ 
    		die("Please provide an email address before submitting your application");
    	}
		elseif (empty($_POST['phone-one'])){
    		die("Please provide a primary phone number before submitting your application");
    	}
		elseif (empty($_POST['organization'])){
    		die("Please provide your organization before submitting your application");
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
		
			$to = "sspetter@dppl.org";
			$mail->AddAddress($to, "Stephanie Spetter");
			
			$to = "lalleman@dppl.org";
			$mail->AddAddress($to, "Lauren Alleman");
		
			//set variables from form values. Probably better way to do this, but this works for now
			$name = strip_tags($_POST['name']);
			$email = strip_tags($_POST['email']);
			$phone_one = strip_tags($_POST['phone-one']);
			$phone_two = strip_tags($_POST['phone-two']);
			$other_participants = strip_tags($_POST['other-participants']);
			$organization = strip_tags($_POST['organization']);
			$organization_website = strip_tags($_POST['organization-website']);
			$contact = strip_tags($_POST['contact']);
			$contact_phone_email = strip_tags($_POST['contact-phone-email']);
			$organization_description = nl2br(strip_tags($_POST['organization-description']));
			$description = nl2br(strip_tags($_POST['description']));
			$number_of_tables = strip_tags($_POST['number-of-tables']);
			$electrical_needed = strip_tags($_POST['electrical-needed']);
			$number_of_chairs = strip_tags($_POST['number-of-chairs']);
			$back_wall_needed = strip_tags($_POST['back-wall-needed']);
			$library_materials = nl2br(strip_tags($_POST['library-materials']));
	
			//uses php function to check if email valid (not a real email address, just a valid form)
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
	
				//santize the email address first
				$mail->From = filter_var($email, FILTER_SANITIZE_EMAIL);
				$mail->FromName = $name;
				
				if ($_POST['send-copy'] == 'true'){
					$mail->AddBCC($email);
				}
				
		
				//add a subject
				$mail->Subject = "2012 Science Expo Registration for " . $name;
	
				//create a variable for the body (be sure to santize input)
				$body = '<table style="width: 100%; margin: 0; padding: 0; border: 0; font-family: Optima, \'Times New Roman\', serif; font-size: 12px;">';
				$body .= '<tr>';
				$body .= '<td colspan="2">';
				$body .= '<h1 style="text-align: center;" >2012 Family Science Expo Registration Form</h1>';
				$body .= '<p>Thank you for agreeing to participate in the 2012 Family Science Expo to be held Saturday, October 13, 2012 from noon–4 p.m. at the Des Plaines Public Library. Please complete the following form and return it by Monday, October 1, 2012.</p>';
				$body .= '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="padding-top: 24px;" colspan="2">';
				$body .= '<h2 style="font-size: 14px; color: #31859b;">Please provide the best contact information for event organizers to reach you with questions or updates:&nbsp;</h2>';
				$body .= '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Name:&nbsp;</strong>' . $name . '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>E-mail:&nbsp;</strong>' . $email . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Phone #1:&nbsp;</strong>' . $phone_one . '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Phone #2:&nbsp;</strong>' . $phone_two . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; padding-bottom: 12px; vertical-align: text-top;" colspan="2"><strong>Names of other participants from your organization attending:&nbsp;</strong><br />' . $other_participants . '</td>';
				$body .= '</tr>';
				$body .= '<td style="padding-top: 24px;" colspan="2">';
				$body .= '<h2 style="font-size: 14px; color: #31859b;">Please provide the following information as you would like it to appear in the printed participant directory, available the day of the event: </h2>';
				$body .= '</td>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Organization:&nbsp;</strong>' . $organization . '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Organization Website:&nbsp;</strong>' . $organization_website . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Contact:&nbsp;</strong>' . $contact. '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Contact Phone/Email:&nbsp;</strong>' . $contact_phone_email . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; padding-bottom: 12px; vertical-align: text-top;" colspan="2"><strong>Description of Organization:&nbsp;</strong><br />' . $organization_description . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; padding-bottom: 12px; vertical-align: text-top;" colspan="2"><strong>Desciption of what you will be doing at the expo:&nbsp;</strong><br />' . $description . '</td>';
				$body .= '</tr>';
				$body .= '<td style="padding-top: 24px;" colspan="2">';
				$body .= '<h2 style="font-size: 14px; color: #31859b;">Please indicate your display needs: </h2>';
				$body .= '</td>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Number of 6 foot tables:&nbsp;</strong>' . $number_of_tables . '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Electrical Needed?&nbsp;</strong>' . $electrical_needed . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Number of Chairs&nbsp;</strong>' . $number_of_chairs . '</td>';
				$body .= '<td style="width: 50%; padding-bottom: 12px; vertical-align: text-top;"><strong>Back Wall Needed?&nbsp;</strong>' . $back_wall_needed . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="width: 100%; padding-bottom: 12px; vertical-align: text-top;" colspan="2"><strong>Would you be interested in a selection of library materials in your subject area for display on or near your table(s) and available for checkout by visitors? If so, please specify the subjects</strong><br />' . $library_materials . '</td>';
				$body .= '</tr>';
				$body .= '<tr>';
				$body .= '<td style="padding-top: 24px;" colspan="2">';
				$body .= '<p style="font-weight: bold; font-size: 14px; color: #31859b; text-align: center;">We are looking forward to a wonderful event. Thank you again for your participation!</p><p style="text-align: center;"><img src="http://www.dppl.org//images/themes/River/logo.jpg" width="200" /></p>';
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
					echo  "Thank you! Your form has been submitted.";
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
?>
