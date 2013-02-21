<?php

    class Form{
        var $id;
        var $fields;
        var $sender;
        var $sender_name;
        var $recipients;
        var $subject;
        var $template;
        var $template_dir;
        var $body;
        
        
        public function __construct($id, $template_dir='templates/'){
            $this->id = $id;
            if($template_dir){
                $this->template_dir = $template_dir;
            }
        }
        
        public function __toString(){
			var_dump($this);
		}
		
		public function process_form($post){
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
		    if (stripos($key, "-req") !== false){
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
		        if ($this->fields['name-req']){
		            $this->sender_name = $this->fields['name'];
		        }
		        elseif ($this->fields['last-name-req']){
		            $this->sender_name = $this->fields['first-name-req'] . ' ' . $this->fields['last-name-req'];
		        }
		        
		        $this->sender = filter_var($this->fields['email'], FILTER_SANITIZE_EMAIL);
		        
		        if (!filter_var($this->sender, FILTER_VALIDATE_EMAIL)){
		            die('Please provide a valid email address (example@example.com)');
		        }
		    }
		}
		
		public function set_recipients(){
            if ($this->has_fields() == true){
		        $this->recipients = json_decode(str_replace('\'', '"', $this->fields['recipients']));
            }		
		}
		
		public function set_subject(){
		    if ($this->has_fields() == true){
		        $this->subject = str_replace('{name}', $this->sender_name, $this->fields['subject']);
		    }
		}
		
		public function set_template(){
		    if ($this->has_fields() == true){
		        $this->template = file_get_contents($this->template_dir . $this->id . '.txt');
		    }
		}
		
		public function set_body(){
		    if ($this->has_fields() == true){
		        $this->body = $this->template;
		        foreach($this->fields as $key => $val){
			        $this->body = str_replace('{' . $key . '}', nl2br(strip_tags($val)), $this->body);
			    }
		    }    
		}
    
    }
    
?>
