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
		
		public function getUserList($baseurl, $key, $library){
			$url = $baseurl . 'list/' . $this->id . '?library=' . $library . '&key=' . $key;
			
			return $url;
		}
	}
?>
