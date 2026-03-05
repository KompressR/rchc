<?php include('../config/config.php');
if ((!$resulta = mysqli_query($db,"CREATE TABLE `$mysdb`.`$imgdb` (`imageid` int(12) NOT NULL AUTO_INCREMENT ,`title` text NOT NULL ,`imgsection` int(12) NOT NULL default '0',`imgtype` varchar(8) NOT NULL default '',PRIMARY KEY (`imageid`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1")) ||
(!$resultb = mysqli_query($db,"CREATE TABLE `$mysdb`.`$imgsectiondb` (`imgsectionid` int(12) NOT NULL AUTO_INCREMENT ,`title` varchar(50) NOT NULL default '',`imgtype` varchar(8) NOT NULL default '',PRIMARY KEY (`imgsectionid`)) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1"))) { echo "FAILED."; }
else { echo "Operation Successful!"; }
?>