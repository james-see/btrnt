<?
$vip = $_SERVER['REMOTE_ADDR'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']); 
$clientInfo = get_browser(null, true);

$vquery = "INSERT INTO visitors (visitorip,visitorhost) VALUES ('$vip', '$hostname')";
if (!mysql_query($con,$vquery))
  {
  die('Error: ' . mysql_error($con));
  }
mysql_close($con);
?>