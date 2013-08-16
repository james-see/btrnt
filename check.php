<?php 
if (isset($_GET['name'])) {
	$url = $_GET['name'];
	if ($url == '') {echo "no username set"; exit;} // if for some reason it executes page without having a name field set
	else {$url = "https://twitter.com/".$url;} 	// puts url into correct format for twitter - example: https://twitter.com/jamescampbell
  
$agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";$ch=curl_init();

curl_setopt ($ch, CURLOPT_URL,$url );

curl_setopt($ch, CURLOPT_USERAGENT, $agent);

curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt ($ch,CURLOPT_VERBOSE,false);

curl_setopt($ch, CURLOPT_TIMEOUT, 5);

$page=curl_exec($ch);

//echo curl_error($ch);

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//echo $httpcode;
//echo $url;
curl_close($ch);

if($httpcode>=200 && $httpcode<300) {echo 1; return true;} //this is the magic that checks if the link exists

else {echo 0; return false;}
}
?>