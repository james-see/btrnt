<?php
// Create connection
$con=mysql_connect("internal-db.s135538.gridserver.com","db135538_robot","!1V3r1tas123","db135538_btrnt");
$db_selected = mysql_select_db('db135538_btrnt', $con);
// Check connection
if (!$con)
  {
  echo "Failed to connect to MySQL: " . mysql_connect_error();
  }
  else { $evidence = 'yes';//echo "<div style='display:block'>Connection success mofo!</div>";
  }

?>