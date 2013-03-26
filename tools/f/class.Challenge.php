<?php
    
    class Challenge{
        var $challenge;
        var $ajax;
        var $response;
        
        public function __construct($challenge, $ajax){
            if ($challenge){
                $this->challenge = $challenge;
            }
            if ($ajax){
                $this->ajax = $ajax;
            }
            $this->response = array();
        }
        
        public function verify($response){
            if(empty($response)){
		        $this->response['status'] = 'failure';
		        $this->response['message'] = 'Please answer the form challenge.';
	        }
            elseif ($response != $this->challenge) {
            	//What happens when the challenge was entered incorrectly
            	$this->response['status'] = 'failure';
            	$this->response['message'] = "I'm sorry. The text you entered did not match the image below. Please try it again.";
            }
            $this->render_response();
        }
        
        public function render_response(){
            if ($this->response['status'] == 'failure'){
                if ($this->ajax == true){
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode($this->response));
                }
                else{
                    die($this->response['message']);
                }
            }
        }
    }
?>
