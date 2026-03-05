<?php //Confirmation Pages
			if ($_GET['psrc'] == "add") {
				if (isset($_GET['start'])) {
					echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?start=".$_GET['start']."\">Click Here To Continue</a></div>\n";
				}
				else { echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."\">Click Here To Continue</a></div>\n"; }
			}
			elseif($_GET['psrc'] == "add2") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?dept=".$_GET['type']."\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "add3") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "addportfolio") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?action=add2&amp;scode=".$_GET['scode']."\">Click Here To Continue To Audio Upload Form</a></div>\n";
			}
			elseif ($_GET['psrc'] == "edit2") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."\">Click Here To Continue</a></div>\n";
			}
			elseif($_GET['psrc'] == "edit3") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?action=edit&amp;type=".$_GET['type']."&amp;start=".$_GET['start']."\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "del2") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "addsection") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?action=editsections\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "delsection2") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?action=editsections\">Click Here To Continue</a></div>\n";
			}
			elseif ($_GET['psrc'] == "sendmail") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."\">Click Here To Continue</a></div>\n";
			}
			elseif($_GET['psrc'] == "changepic2") {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?action=edit&amp;id=".$_GET['id']."\">Click Here To Continue</a></div>\n";
			}
			else {
				echo "				<div class=\"messages\"><h2>Operation Complete</h2><a href=\"".$thisfile."?".(isset($_GET['type'])?"?type=".$_GET['type']."":"")."\">Click Here To Continue</a></div>\n";
			}
?>
<!-- LLR Control Panel Confirmation Pages V1.0 Final - 2015-01-22 -->
<!-- Page Created by Rob Nesbitt Copyright 2017 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->