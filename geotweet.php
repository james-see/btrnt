<!DOCTYPE html>
<html>
<head>
<div><h2 style="text-align:center;padding:20px;margin:20px;">experimental map of recent tweets</h2></div>
<script language="javascript"> 
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "show";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
	}
} 
</script>


<div id="toggleText" style="display: none">
<?php 

 $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    if ($browser == true){
    $browser = 'iphone';
  }
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
$userid = isset($_GET['u']) ? $_GET['u'] : 'mr_darling';

// codebird connect
require_once ('codebird.php');
Codebird::setConsumerKey('J6D02oyoZGD7N5bMkZTeIw', '7HmaYNfuwBWXElr3MacV2Twpkj63ALZSV87HkwrtIjs'); // static, see 'Using multiple Codebird instances'

$cbb = Codebird::getInstance();
$cbb->setToken('13050982-CzHNmsiBdhw0btNxiyxe1Uu3t179LcjYX59QvfLBL', 'NKXwQxJnkXu27eOUg5mD0hsA4qZlrSd8ORkF2kZ6c');
$bigger = 'bigger';
$params = array(
    'user_id' => $userid,
    'trim_user' => 1,
    'include_entities' => 0,
    'count' => 200
);
$geod = $cbb->statuses_userTimeline($params);// end codebird connect

//print_r($geod);
//print_r($data);
$ga = (array) $geod;
//echo json_encode($ga); //for debugging purposes only
//print_r($ga);
//print_r($geoent);
//echo "<br>worked?<br>"; 
$geotweetid = array();
$textual = array();

	$lata = array();
	$longa = array();
$counter = 0;
$geocount = 0;
echo "<div style='width:90%; margin-left:auto;margin-right:auto;'><h2 style='font-family:Helvetica;text-align:center;'>Last 200 tweets</h2>";
foreach ($ga as $gar) {
if ($gar->id != null || $gar->id != '') 
		{
$idd = $gar->id; //id
$text= $gar->text; //text

	array_push($geotweetid,$idd);
	array_push($textual,$text);
echo "<span style='font-size:10px;font-family:Helvetica,san-serif;padding:10px;'>count: $counter id: $idd text of tweet: $text </span><br>";
$counter++;

	$coord = (array) $gar->coordinates;
	if (array_key_exists('coordinates', $coord))
				{
 //echo $coord['coordinates'][0][1][0], $coord['coordinates'][0][1][1];echo "<br>";
 		$geocount++;
		$lat = $coord['coordinates'][0];
		$long = $coord['coordinates'][1];
		$latlng = $lat.','.$long;
		$long = $counter."_".$long;
		echo "latlong $latlng ";
		array_push($lata,$lat);
		array_push($longa,$long);
//print_r($lata);
//print_r($longa);
//print_r($textual);
	echo "<a href='https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=$latlng&amp;aq=&amp;sll=$latlng&amp;sspn=0.354858,0.532837&amp;t=v&amp;ie=UTF8&amp;ll=$latlng&amp;spn=0.022176,0.033302&amp;z=14'>map link</a> <br>";
	//else echo "No geo for tweet <br>";
				}
			}
		}
	echo "</div></div>";
echo "<div><h3 style='text-align:center;font-size:20px;font-family:Helvetica,san-serif;padding:20px;margin:20px;color:orange;'>$geocount total tweets with geo-coordinates in last 200</h3></div>";
//print_r($lata);

//echo "lata: $lata(1) longa: $longa[1]";
//$markf = "$lata[0][0][0],$longa[0][0][0],\"tweetid$geotweetid[0][0][0]\", \"description\"" ;
//echo $markf;

include_once("include/GoogleMap.php");
include_once("include/JSMin.php");
?>
</head>
<body>
<?$MAP_OBJECT = new GoogleMapAPI(); $MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;?>
<?$MAP_OBJECT->setDSN("mysql://user:password@localhost/db_name");?>
<?$marked = array();?>

<?for ($n=0; isset($lata[$n]) && isset($longa[$n]); $n++) {
$counted = array();
$counted = explode('_',$longa[$n],2);
$thenum = $counted[0];
if ($thenum != 0) {$thenum = $thenum -1;}
$longa[$n] = $counted[1];
$marked = array();
$marked[$n] = $MAP_OBJECT->addMarkerByCoords($lata[$n],$longa[$n],"$geotweetid[$thenum]","$textual[$thenum]");
}?>
<? //$MAP_OBJECT->addMarkerByCoords($lata[0],$longa[0],"$geotweetid[0]","bs");?>

<?=$MAP_OBJECT->getHeaderJS();?>
<?=$MAP_OBJECT->getMapJS();?>
<?$MAP_OBJECT->width="90%";?>
<?php if($browser == 'iphone'){
$MAP_OBJECT->mobile=true;?>
  <title>Bot R Not</title>
  <?$MAP_OBJECT->height="300px";?>
  <meta name="format-detection" content="telephone=no">
 <meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
 <meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" />
  <link rel="stylesheet" type="text/css" href="mobile.css" media="all">
  <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- you can comment this out to test to make sure it works-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
<? }?>

<?=$MAP_OBJECT->printOnLoad();?> 
<?=$MAP_OBJECT->printMap();?>
<?=$MAP_OBJECT->disableSidebar();?>
<?echo "<h2 style='text-align:center;border:3px solid #eee;padding:20px;margin-top:80px;width:50%;margin-left:auto;margin-right:auto;'><a style='color:orange;border-bottom:2px solid #ccc;text-decoration:none;'href='http://www.btrnt.com/'>back to home</a></h2>";?>
<div style='text-align:center;'><a id="displayText" href="javascript:toggle();">click Here to show last 200 tweets</a></div>
</body>
</html>
