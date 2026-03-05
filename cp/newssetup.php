<?php include('../config/config.php');
if (!$resulta = mysqli_query($db,"CREATE TABLE IF NOT EXISTS `$mysdb`.`$newsdb` (`newsid` int(12) NOT NULL AUTO_INCREMENT, `title` varchar(150) NOT NULL DEFAULT '', `date` varchar(12) NOT NULL DEFAULT '', `message` longtext NOT NULL, PRIMARY KEY (`newsid`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1")) { echo "News Script Setup: FAILED."; }
else { echo "News Script Setup: Operation Successful!"; }
?>