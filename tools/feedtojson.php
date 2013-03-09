<?php
    //set the response header so browser recognizes json
	header('Content-Type: application/json; charset=UTF-8');
	
	//get some url parameters
	$feed_type = $_GET['feed_type'];
	$num_items = $_GET['num_items'];
	
	//check if a url has been passed, decode if so, return error if not
	if ($_GET['url']){
		$url = urldecode($_GET['url']);
	}
	else{
		echo $_GET['jsoncallback'] . '({"item":[{"title":"There was no feed to process!"}]})';
		die();
	}
	
	//load feed file
	$xml = simplexml_load_file($url);
	
	//load the right part of the xml doc based on the feed type
	switch ($feed_type){
	    case 'events':
	        $items = $xml;
	        break;
	    case 'blog':
	        $items = $xml->channel;
	}
	
	//create empty array for feed items
	$feed = array();
	$i = 0;
	
	//loop through feed items
	foreach ($items->item as $entry){
	    //check if number of items limit has been reached
	    if ($i < $num_items){
	        //empty array for item
	        $item = array();
	        
	        //get namespaces to parse summaries and thumbnails
	        $namespaces = $entry->getNamespaces(true);
	        
	        //loop through each elements and add to array as key/value pair
	        foreach ($entry as $thing){
	            $item[$thing->getName()] = $thing->__toString();
	        }
	        
	        //get the thumbnail image if it exists
	        if ($entry->children($namespaces['media'])->thumbnail){
	            $image = $entry->children($namespaces['media'])->thumbnail[0]->attributes();
                $item['thumbnail'] = $image['url']->__toString();
            }
            
            //get the summary text if it exsits, use format_summary helper function below for parsing summary
            if ($entry->children($namespaces['atom'])->summary){
                $summary = $entry->children($namespaces['atom'])->summary;
                $summary_text = format_summary(trim(str_replace('/\n', ' ', $summary->__toString())));
                $item['summary'] = $summary_text;
            }
            
            //append item to feed array
            $feed['item'][] = $item;
            $i++;
        }
	}
	
	//encode xml as json and echo back to ajax function as GET parameters
	echo $_GET['jsoncallback'] . '(' . json_encode($feed) . ')';
	
	function format_summary($input){
        //cleans up a blog summary from blogger
        
        //register regex pattern to remove links in text
        $pattern = '/[http|https]:\/\/[a-zA-Z0-9\-\.\:\/\#\?]+/';
        $cleaninput = preg_replace($pattern, '', $input);
	    
	    //remove spaces from text
	    $cleaninput = trim(str_replace('\n', ' ', $cleaninput));
	    
	    //break into sentences 
	    $pieces = explode('.', $cleaninput);
	    
	    //return the first sentece with ellipsis after it
	    if ($pieces){
	        $output = $pieces[0] . '&hellip;';
	    }
	    else{
	        $output = $cleaninput;
	    }
	    
	    return $output;
	}

?>
