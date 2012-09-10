<?php

	class User{
		var $id;
		var $library;
		var $name;
		var $profile;
		
		public function __construct($id, $library){
			$this->id = $id;
			$this->library = $library;
		}
		
		public function __toString(){
			var_dump($this);
		}
		
		public function setID($id){
			$this->id = $id;
		}
		
		public function getID(){
			return $this->id;
		}
		
		public function getLibrary(){
			return $this->library;
		}
		
		public function getUserInfo($baseurl, $key){
			$url = $baseurl . 'users/' . $this->id . '?library=' . $this->library . '&key=' . $key;
			
			return $url;
		}
		
		public function getUserLists($baseurl, $key, $dir, $file_name){
			//check if file has been saved
			echo $file_name . '<br />';
			echo file_exists($dir . $file_name);
			if (file_exists($dir . $file_name)){
				echo 'it already exists<br />';
				$json = file_get_contents($dir . $file_name);
			}
			else{
				//returns the request as json
				$url = $baseurl . 'users/' . $this->id . '/lists?library=' . $this->library . '&api_key=' . $key;
				echo $url;
				$json = file_get_contents($url) or die('nope');
			}
			return $json;
		}
		
		public function getUserListIDs($jarray, $id_array){
			foreach ($jarray['lists'] as $list){
				array_push($id_array, $list['id']);
			}
			
			return $id_array;
		}
	
	}
?>
