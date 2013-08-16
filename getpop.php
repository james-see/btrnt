<?
$botquery = "select tuser, trating from bots order by trating desc limit 1 ;";
$totalrows = "select count(*) as counter from bots;";
$db_selected = mysql_select_db('db135538_btrnt', $con);
if (!mysql_query($botquery, $con))
  {
  die('Error: ' . mysql_error($con));
  }
else {$result = mysql_query($botquery, $con);$worstbot = mysql_fetch_array($result,MYSQL_ASSOC);}


if (!mysql_query($totalrows, $con))
  {
  die('Error: ' . mysql_error($con));
  }
else {$totals = mysql_query($totalrows, $con);$totaled = mysql_fetch_array($totals,MYSQL_ASSOC);}

mysql_close($con);


$totalcount = $totaled["counter"];
$topbot = $worstbot["tuser"];
$topbotscore = $worstbot["trating"];
?>