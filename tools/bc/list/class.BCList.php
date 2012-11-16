<?php
	class BCList{
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
		
		public function getList($baseurl, $key, $library, $dir, $file_name){
			//check if the file exists
			if (file_exists($dir . $file_name)){
				$json = file_get_contents($dir . $file_name);
			}
			else{
				$url = $baseurl . 'lists/' . $this->id . '?library=' . $library . '&api_key=' . $key;
				$json = file_get_contents($url) or die('List #' . $this->id . ' is not a valid list!');
				
				if ($json){
					$this->saveList($json, $dir, $file_name);
					//sleep(3);
				}
			}
			
			return $json;
			
		}
		
		public function saveList($json, $dir, $file_name){
			$fh = fopen($dir . $file_name, 'w');
			fwrite($fh, $json);
	
			fclose($fh);
		}
		
	}
?>
