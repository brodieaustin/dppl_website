<?php
//http://www.w3schools.com/php/php_file_upload.asp

	if ($_POST["password"] != md5('password')){
		die("I'm sorry. You didn't provide the correct password. Please try again.");
	}
	else{

		if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/png")
		|| ($_FILES["file"]["type"] == "image/x-png"))
		&& ($_FILES["file"]["size"] < 500000)){
		  if ($_FILES["file"]["error"] > 0){
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		  }
		  else{
			$year = Date("Y");
			$dir = $year . "/";
	
				if (is_dir($dir) === false){
					mkdir($dir, 0766, true);
				}
		
				$file_name = str_replace(' ', '-', $_FILES["file"]["name"]);
				$file_name = strtolower($file_name);

				if (file_exists($dir . $file_name)){
				  die($file_name . " already exists. ");
				}
				else{
				  move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $file_name);
				  echo "http://www.dppl.org/images/calendar/" . $dir . $file_name;
				}
			}
		  }
		else{
		  die("Invalid file: " . $_FILES["file"]["type"]);
		}
	}
  
?>
