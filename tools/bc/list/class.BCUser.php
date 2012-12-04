<?php

	class BCUser{
		var $id;
		
		public function __construct($id){
			$this->id = $id;
		}
		
		public function __toString(){
			var_dump($this);
		}
		
		public function setID($id){
			$this->id = $id;
		}
		
		
		public function getUserInfo($baseurl, $key){
			$url = $baseurl . 'users/' . $this->id . '?library=' . $this->library . '&api_key=' . $key;
			return $url;
		}
		
		public function getUserLists($baseurl, $key, $library){
			$url = $baseurl . 'users/' . $this->id . '/lists?library=' . $library . '&api_key=' . $key;
			$json = file_get_contents($url) or die('nope');
			
			return $json;
		}
		
		public function getUserListIDs($json){
			$jarray = json_decode($json, true);
			$id_array = array();
			
			foreach ($jarray['lists'] as $list){
				array_push($id_array, $list['id']);
			}
			
			return $id_array;
		}
		
		public function saveUserLists($baseurl, $key, $library)	
	
	}
?>
