
<?php

	function handleFiles($mail, $files){
	//the key/value loops borrowed from http://amiworks.co.in/talk/handling-file-uploads-in-php/
	
		//few files variables
		$filetypes = array("application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "text/plain", "application/rtf");
		$maxsize = 1024;
		$response = '';
	
		//loop through each file in the array
		foreach ($files as $file){
			$error = $file['error'];
			$valid = false;
		
			if ($error != 4){
				//hand off file to the checkFile function
				$valid = checkFile($file, $filetypes, $maxsize, $fresponse);
			
				if ($valid != false){
					$mail->AddAttachment($file['tmp_name'], strip_tags($file['name']));
					$response = $response . '<br />' . $file['name'] . " was sent.";
				}
				else
					$response = $response . '';
			
			}
		}
		
		return $response;
	}
	
	function checkFile($f, $filetypes, $maxsize, $fresponse){
		//first check if file is too big (floor rounds decimals down)
		if (floor(($f['size']/1000)) > $maxsize){
			die("The file (" . $f['name'] . " is too large! Please submit a smaller file.<br />");
			return false;
		}
		else{
			//if it's not too big make sure it is a valid filetype
			if (!in_array($f['type'], $filetypes)){
				die("The file (" . $f['name'] .  " is not a valid falid type! Only doc, docx, pdf, txt, or rtf accepted. <br />");
				return false;
			}
			else{
				return true;
			}
		}
	}
	
?>
