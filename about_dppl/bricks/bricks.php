<?php

$username = "###";
$password = "###";
$db = "dpplbricks";

$con = mysql_connect("localhost:3306", $username, $password);

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
  
mysql_select_db($db, $con);

if (isset($_GET['param'])){
	$param = mysql_real_escape_string(strip_tags($_GET['param']));
	$type = mysql_real_escape_string(strip_tags($_GET['type']));
	
	if($type == 'search'){
		$where = " WHERE inscription LIKE \"%" . $param . "%\" ";
	}
	else{
		$where = " WHERE " . $type . " LIKE \"" . $param . "%\" ";
	}
}
else{
	$where = ' ';
}

$sql = "SELECT * FROM bricks" . $where . "ORDER BY inscription ASC";
$result = mysql_query($sql, $con);

$data = '{"bricks":[';

while($row = mysql_fetch_array($result)){
	$data = $data . '{"inscription":"'. $row['inscription'] . '","location":"' . $row['location'] . '"},';
}

$data = trim($data,',') . ']}';

mysql_close($con);

echo $data;

?>
