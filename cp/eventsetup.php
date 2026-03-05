<?php include('../config/config.php');
if (!$resulta = mysqli_query($db,"CREATE TABLE IF NOT EXISTS `$mysdb`.`$eventsdb` (`eventid` int(12) NOT NULL AUTO_INCREMENT, `name` varchar(255) NOT NULL DEFAULT '', `venue` varchar(255) NOT NULL DEFAULT '', `address` varchar(255) NOT NULL DEFAULT '', `price` varchar(255) NOT NULL DEFAULT '', `description` longtext NOT NULL, `unixstarttime` int(255) NOT NULL, `unixendtime` int(255) NOT NULL, PRIMARY KEY `eventid` ( `eventid` )) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1")) { echo "FAILED."; }
else { echo "Operation Successful!"; }
?>