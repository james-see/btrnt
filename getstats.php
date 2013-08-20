<?
$statquery = "select distinct tuser, tfollowers, tdays,tperday,tpopularity, ttime from bots where tuser != '' group by tuser order by ttime desc limit 1000;";
$totalrowed = "select count(distinct tuser) as counters from bots where tuser != '';";
$con=mysql_connect("internal-db.s135538.gridserver.com","db135538_robot","!1V3r1tas123","db135538_btrnt");
$db_selected = mysql_select_db('db135538_btrnt', $con);

$results = mysql_query($statquery, $con);
$totalrowresults = mysql_query($totalrowed, $con);

if ($results) {
	echo "<div><table>";
	echo "<tr><th>NAME</th><th>TWEETS per DAY</th><th>DATE QUERIED</th></tr>";
while($row = mysql_fetch_array($results)) {
echo "<tr><td>".$row["tuser"]."</td><td> ".$row["tperday"]."</td><td> ".$row["ttime"]."</td></tr>";
}
echo "</table>";
}
$totalrowarray = mysql_fetch_assoc($totalrowresults);
$totalresultnum = $totalrowarray["counters"];
mysql_close($con);


echo "<ul><li>Total twitter users in database: $totalresultnum </li></ul></div>";


?>