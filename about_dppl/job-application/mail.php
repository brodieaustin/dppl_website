<?php
    //echo var_dump($_SERVER);
    sleep(2);
    $response = array();
    $rnd = rand(1,2);
    if ($rnd == 1){
        $response['status'] = 'success';
    }
    else{
        $response['status'] = 'failure';
    }
    $response['message'] = 'lorem ipusm dolor and some other text that doesn\'t mean very much to you. this is a form, yes a form. lorem ipusm dolor and some other text that doesn\'t mean very much to you either.';
    
    if ($_SERVER["HTTP_X_REQUESTED_WITH"]){
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response);
    }
    else{
        echo $response['message'];
    }

?>
