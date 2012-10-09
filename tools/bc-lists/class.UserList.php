<?php
	class UserList{
		var $id;
		
		public function __construct($id){
			$this->id = $id;
		}
		
		public function setID($id){
			$this->id = $id;
		}
		
		public function getID(){
			return $this->id;
		}
		
		public function getUserList($baseurl, $key, $library, $dir, $file_name){
			if (file_exists($dir . $file_name)){
				echo 'it already exists<br />';
				$json = file_get_contents($dir . $file_name);
			}
			else{
				$url = $baseurl . 'lists/' . $this->id . '?library=' . $library . '&api_key=' . $key;
				$json = file_get_contents($url) or die('nope');
			
				sleep(3);
			}
			return $json;
			
		}
	}
?>
