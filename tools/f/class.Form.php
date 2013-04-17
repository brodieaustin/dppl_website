<?php

    class Form{
        var $id;
        var $config;
        var $fields;
        var $sender;
        var $recipients;
        var $subject;
        var $template;
        var $body;
        var $messages;
        var $ajax;
        var $response;
        
        
        public function __construct($id, $ajax){
            $this->id = $id;
            if ($ajax){
                $this->ajax = $ajax;
            }
            $this->response = array();
        }
        
        public function __toString(){
			var_dump($this);
		}
		
		public function set_config(){
		    $fh = file_get_contents('fs/' . $this->id . '/config.json');
		    $json = json_decode($fh, true);
		    
		    if ($json){
		        $this->config = $json;
		    }
		}
		
		public function process_form($post){
		    $this->set_config();
            $this->set_fields($post);
            
            if ($this->has_fields() == true){     
                $this->set_sender();
                $this->set_recipients(); 
                $this->set_subject();     
                $this->set_template();
                $this->set_body();
                $this->set_messages();
            }
            else{
                $this->response['status'] = 'failure';
                $this->response['message'] = 'There were no form fields to process. Please try again.';
                
                $this->render_response();
            }
		}
        
		public function set_fields($post){
		    foreach ($post as $key => $val){
		        $this->check_required_field($key, $val);
		        $this->fields[$key] = nl2br(strip_tags($val));
		    }
		}
		
		public function check_required_field($key, $val){
		    if ($this->config['fields'][$key] == true){
	                if (empty($val)){
	                    $this->response['status'] = 'failure';
	                    $this->response['message'] = 'You did not complete a required field. Please double check the form and resubmit.';
	                    
	                    $this->render_response();
	                }
	            }
		}
		
		public function has_fields(){
		    if (count($this->fields)!=0){
		        return true;
		    }
		    else{
		        return false;
		    }
		}
		
		public function set_sender(){
		    if ($this->has_fields() == true){
		        //check if sender, otherwise use config values
		        if (!empty($this->fields['email'])){
		            $this->sender['email'] = filter_var($this->fields['email'], FILTER_SANITIZE_EMAIL);
		            
	                if ($this->fields['name']){
	                    $this->sender['name'] = $this->fields['name'];
	                }
	                elseif ($this->fields['last-name']){
	                    $this->sender['name'] = $this->fields['first-name'] . ' ' . $this->fields['last-name'];
	                }
	            }
	            else{
	                $this->sender['name'] = $this->config['sender']['name'];
		            $this->sender['email'] = filter_var($this->config['sender']['email'], FILTER_SANITIZE_EMAIL);
	            }

	            if (!filter_var($this->sender['email'], FILTER_VALIDATE_EMAIL)){
	                $this->response['status'] = 'failure';
	                $this->response['message'] = 'Please provide a valid email address (example@example.com)';
	                
	                $this->render_response();
	            }
	        }
		}
		
		public function set_recipients(){
            if ($this->has_fields() == true){
		        $this->recipients = $this->config['recipients'];
            }		
		}
		
		public function set_subject(){
		    if ($this->has_fields() == true){
				if (strpos($this->config['subject'], '{name}') !== false){
					$this->subject = str_replace('{name}', $this->sender['name'], $this->config['subject']);
				}
				elseif (strpos($this->config['subject'], '{position}') !== false){
					$this->subject = str_replace('{position}', $this->fields['position'], $this->config['subject']);
				}
				else{
					$this->subject = $this->config['subject'];
				}
		    }
		}
		
		public function set_template(){
		    if ($this->has_fields() == true){
		        $this->template = file_get_contents('fs/' . $this->id . '/template.txt');
		    }
		}
		
		public function set_body(){
		    if ($this->has_fields() == true){
		        $this->body = $this->template;
		        foreach($this->fields as $key => $val){
			        $this->body = str_replace('{' . $key . '}', $val, $this->body);
			    }
		    }    
		}
		
		public function set_messages(){
		    if ($this->has_fields() == true){
		        if (!empty($this->config['messages'])){
		            $this->messages = $this->config['messages'];
		        }
            }
		}
		
		public function set_response($status, $message){
		    //pass a status and message
		    $this->response['status'] = $status;
		    $this->response['message'] = $message;
		}
		
		public function render_response(){
            if ($this->ajax == true){
                header('Content-Type: application/json; charset=UTF-8');
                $out = json_encode($this->response);
            }
            else{
                $out = $this->response['message'];
            }
            
            if ($this->response['status'] == 'success'){
                echo $out;
            }
            else{
                die($out);
            }
        }
    
    }
    
?>
