<?php
// Create connection
$con=mysqli_connect("internal-db.s135538.gridserver.com","db135538_robot","!1V3r1tas123","db135538_btrnt");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>