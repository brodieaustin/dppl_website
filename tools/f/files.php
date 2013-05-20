
<?php
	function handleFiles($mail, $files, $ajax){
	//the key/value loops borrowed from http://amiworks.co.in/talk/handling-file-uploads-in-php/
	
		//few files variables
		$filetypes = array("application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "text/plain", "application/rtf");
		$maxsize = 1024;
		$response = '';
		$i = 0;
	
		//loop through each file in the array
		foreach ($files as $file){
			$error = $file['error'];
			$valid = false;
		
			if ($error != 4){
				//hand off file to the checkFile function
				$valid = checkFile($file, $filetypes, $maxsize, $ajax);
			
				if ($valid != false){
					$mail->AddAttachment($file['tmp_name'], strip_tags($file['name']));
					$i++;
				}
			
			}
		}
		
		if ($i > 0){
		    $response = ' ' . $i . ($i==1?' file was':' files were') . ' attached and sent.';
		}
		else{
		    $response = '';
		}
		
		return $response;
	}
	
	function checkFile($f, $filetypes, $maxsize, $ajax){
	    $response = array();
		//first check if file is too big (floor rounds decimals down)
		if (floor(($f['size']/1000)) > $maxsize){
		    $response['status'] = 'failure';
			$response['message'] = 'The file (' . $f['name'] . ') is too large! Please submit a smaller file.';
		}
		elseif (!in_array($f['type'], $filetypes)){
		    //if it's not too big make sure it is a valid filetype
			$response['status'] = 'failure';
		    $response['message'] = 'The file (' . $f['name'] .  ') is not a valid type! Only doc, docx, pdf, txt, or rtf accepted.';
        }
        else{
            $response['status'] = 'success';
		}
		
		if ($response['status'] == 'failure'){
		    if ($ajax == true){
		        header('Content-Type: application/json; charset=UTF-8');
		        $out = json_encode($response);
		    }
		    else{
		        $out = $response['message'];
		    }
		    die($out);
		    return false;
		}
		else{
		    return true;
		}
	}
	
?>
