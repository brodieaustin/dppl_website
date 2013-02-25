<?php

    class Challenge{
        var $challenge;
        
        public function __construct($challenge){
            if ($challenge){
                $this->challenge = $challenge;
            }
        }
        
        public function verify($response){
            if(empty($response)){
		        die("Please answer the form challenge.");
	        }
            elseif ($response != $this->challenge) {
            	//What happens when the challenge was entered incorrectly
            	die ("I'm sorry. The challenge question wasn't answered correctly. Please try it again.");
            }
        }
    }
?>
