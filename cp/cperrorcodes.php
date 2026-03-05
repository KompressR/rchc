<?php //Error Pages
			if ($_GET['etype'] == "1") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears you left some fields blank. Please press the back button in your browser and fill the empty fields. (Code #001)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "2") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears the file you have selected is larger than this script supports. Please press the back button in your browser and try a smaller file. (Code #002)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "3") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears the file you have selected is larger than your server supports. Please press the back button in your browser and try a smaller file. (Code #003)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "4") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears the file did not finish uploading. Please press the back button in your browser try again. (Code #004)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "5") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears you left some fields blank. Please press the back button in your browser and fill the empty fields. (Code #005)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "6") {
				echo "				<div class=\"messages\"><h2>ERROR: There appears to be a problem with your server's tmp_dir settings. Please contact your server administrator for futher assistance. (Code #006)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "7") {
				echo "				<div class=\"messages\"><h2>ERROR: This file appears to have been rejected by the server. Please press the back button in your browser try a different file. (Code #007)</h2></div>\n";
			}
			elseif ($_GET['etype'] == "8") {
				echo "				<div class=\"messages\"><h2>ERROR: It appears you have selected an event end time that is before it's start time. Please press the back button in your browser and try again. (Code #008)</h2></div>\n";
			}
			else {
				echo "				<div class=\"messages\"><h2>ERROR: There has been an unknown error. Please press the back button in your browser and try again. If the problem persists, contact your administrator. (Code #000)</h2></div>\n";
			}
?>
<!-- LLR Control Panel Error Codes V1.0 Final - 2015-01-22 -->
<!-- Page Created by Rob Nesbitt Copyright 2017 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->