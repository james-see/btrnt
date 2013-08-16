<?php
function DateFigure($creation){
date_default_timezone_set('Europe/London');
$datetime1 = new DateTime($creation);
$datetime2 = new DateTime();
$interval = $datetime1->diff($datetime2);
$daysdiff = $interval->format('%R%a days');
return $daysdiff;}
?>
