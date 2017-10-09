<?php

date_default_timezone_set("Europe/Berlin");
$currentTime = time();
$now = strftime("%d.%m.%y, %H:%M:%S", $currentTime);
echo $now;
?>