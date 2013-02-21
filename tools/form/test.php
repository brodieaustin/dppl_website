<?php

    require_once('class.Form.php');
    $form = new Form('homebound-application');
    
    echo filter_var('help@dppl.org', FILTER_VALIDATE_EMAIL);
    echo '<hr>';
    
    if ($_POST){
        $form->process_form($_POST);
        echo $form->body;
        
        
    } 
?>
