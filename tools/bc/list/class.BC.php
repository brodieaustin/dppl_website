<?php
	class BC{
		var $baseurl;
		var $file_dir;
		var $library;
		var $api_key;
		
		public function __construct($library, $api_key){
			$this->baseurl = 'https://api.bibliocommons.com/v1/';
			$this->file_dir = dirname(__FILE__) . '/files/';
			$this->library = $library;
			$this->api_key = $api_key;
		}
		
		public function __toString(){
			var_dump($this);
		}
	}
