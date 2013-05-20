<?php
	session_start ();
	require_once 'ConstantContact.php';
	require_once 'config.php';
	
	if ($accessToken){
		if($_POST){
			$email;
			$lists = array('http://api.constantcontact.com/ws/customers/' . $username . '/lists/1');
			
			$ConstantContact = new ConstantContact ( "oauth2", $apikey, $username, $accessToken );
			
			if($_POST['email_address']){
				$email = $_POST['email_address'];
			}
			elseif ($_POST['EMAIL1']){
				$email = $_POST['EMAIL1'];
			}
			else{
				die('Please provide an email address!');
			}
			
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			
			    $Contact = new Contact();
			    $Contact->emailAddress = $email;
			
			    $search = $ConstantContact->searchContactsByEmail($email);
			
			    if ($search == false){
			        $Contact->optInSource = 'ACTION_BY_CONTACT';
		            $Contact->lists = $lists;
		            
			        $NewContact = $ConstantContact->addContact($Contact);
		
			        if($NewContact){
				        echo 'Your email address was added to our newsletter. You will receive a confirmation email shortly.';
			        }
			        else{
				        echo 'Something went wrong. Your email was not added';
			        }
			    }
			    else{
			        echo 'You are already signed up for the newsletter.';
			    }
		}
		else{
			echo 'No data to post!';
		}
	}
?>