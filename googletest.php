<?php
function whatTime() {
	

$currenttime = strtotime(time());
$morning = strtotime('8:00');
$afternoon = strtotime('12:00');
$evening = strtotime('17:00');
$night = strtotime('20:00');

//echo($currenttime.$br.)
if ($currenttime>$night || $currenttime<$morning) { 
	echo "It's night!";
	}
elseif ($currenttime>$morning && $currenttime<$afternoon) { 
	echo "It's morning!";
	}
elseif ($currenttime>$afternoon && $currenttime<$evening) { 
	echo "It's afternoon!";
	}
elseif ($currenttime>$evening && $currenttime<$night) { 
	echo "It's evening!";
	}
}
whatTime();
?>