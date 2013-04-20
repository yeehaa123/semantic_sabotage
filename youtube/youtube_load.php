<?php  
	
	function get_data($url) {
		$ch = curl_init();
		$timeout = 30;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	$urlData = get_data($_POST["url"], false);
	
	$startInd = strpos($urlData, "ttsurl") + 10;
	
	$endInd = strpos($urlData, '"', $startInd);
	$ccUrl = substr($urlData, $startInd, $endInd-$startInd);
	$ccUrl = str_replace("\u0026", "&", $ccUrl);
	$ccUrl = str_replace("\/", "/", $ccUrl)."&type=track&lang=en&name&kind=asr&fmt=1";
	
	$xml = simplexml_load_file($ccUrl);

	
	$cc =  array();
  foreach ($xml->children() as $text){ 
		$cc[] = $text;
  }
	
	//echo '{ "cc": "' . json_encode($cc) . '", "url": "' . $ccUrl . '" }';  
	$response = array("url" => $ccUrl,  "cc" => $cc);
	
	
	echo json_encode($response); 
	
	
?>