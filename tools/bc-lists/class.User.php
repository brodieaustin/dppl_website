<?php

	class User{
		var $id;
		var $name;
		var $profile;
		
		public function __construct($id){
			$this->id = $id;
		}
		
		public function setID($id){
			$this->id = $id;
		}
		
		public function getID(){
			return $this->id;
		}
		
		public function getUserInfo($baseurl, $key){
			$url = $baseurl . 'users/' . $this->id . '?key=' . $key;
			
			return $url;
		}
		
		public function getUserLists($baseurl, $key, $dir, $file_name){
			//check if file has been saved
			if (file_exists($dir . $file_name)){
				$json = file_get_contents($dir . $file_name);
			}
			else{
				//returns the request as json
				$url = $baseurl . 'users/' . $this->id . '/lists?api_key=' . $key;
				echo $url;
				$json = file_get_contents($url) or die('nope');
			}
			return $json;
		}
		
		public function getUserListIDs($jarray){
			foreach ($jarray['lists'] as $list){
				echo $list['id'];
			}
		}
	
	}
?>
