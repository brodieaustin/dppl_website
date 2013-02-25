<?php

    class Form{
        var $id;
        var $config;
        var $config_dir;
        var $fields;
        var $sender;
        var $recipients;
        var $subject;
        var $template;
        var $template_dir;
        var $body;
        
        
        public function __construct($id, $config_dir='configs/', $template_dir='templates/'){
            $this->id = $id;
            if($config_dir){
                $this->config_dir = $config_dir;
            }
            if($template_dir){
                $this->template_dir = $template_dir;
            }
        }
        
        public function __toString(){
			var_dump($this);
		}
		
		public function set_config(){
		    $fh = file_get_contents($this->config_dir . $this->id . '.json');
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
            }
            else{
                die('There were no form fields to process. Please try again.');
            }
		}
        
		public function set_fields($post){
		    foreach ($post as $key => $val){
		        $this->check_required_field($key, $val);
		        $this->fields[$key] = nl2br(strip_tags($val));
		    }
		}
		
		public function check_required_field($key, $val){
		    if ($this->config['fields'][$key] !== false){
	                if (empty($val)){
	                    die('You did not complete a required field. Please double check the form and resubmit.');
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
		        //check if sender set in config, otherwise use post values
		        if ($this->config['sender']){
		            $this->sender['name'] = $this->config['sender']['name'];
		            $this->sender['email'] = filter_var($this->config['sender']['email'], FILTER_SANITIZE_EMAIL);
		        }
		        else{
		            if ($this->fields['name']){
		                $this->sender['name'] = $this->fields['name'];
		            }
		            elseif ($this->fields['last-name']){
		                $this->sender['name'] = $this->fields['first-name'] . ' ' . $this->fields['last-name'];
		            }
		            
		            $this->sender['email'] = filter_var($this->fields['email'], FILTER_SANITIZE_EMAIL);
		            
		            if (!filter_var($this->sender, FILTER_VALIDATE_EMAIL)){
		                die('Please provide a valid email address (example@example.com)');
		            }
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
		        $this->subject = str_replace('{name}', $this->sender_name, $this->config['subject']);
		    }
		}
		
		public function set_template(){
		    if ($this->has_fields() == true){
		        $this->template = file_get_contents($this->template_dir . $this->config['template']);
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
    
    }
    
?>
