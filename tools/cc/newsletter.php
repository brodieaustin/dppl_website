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
			
			$Contact = new Contact();
			$Contact->emailAddress = $email;
			$Contact->optInSource = 'ACTION_BY_CONTACT';
		    $Contact->lists = $lists;
		    
			$NewContact = $ConstantContact->addContact($Contact);
		
			if($NewContact){
				echo $email . ' was added to our newsletter!';
			}
			else{
				echo $email . ' not added';
			}
		}
		else{
			echo 'No data to post!';
		}
	}
?>
