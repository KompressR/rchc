<?php include('config/config.php'); 
$resulta = mysqli_query($db,"SELECT * FROM $imgdb ORDER BY RAND() LIMIT 1");
$resultb = mysqli_query($db,"SELECT * FROM $eventsdb ORDER BY eventid DESC");
?>
<!DOCTYPE html>
<html lang="en-CA">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
		<title><?php echo $site_title; ?></title>
		<link rel="icon" type="image/png" href="images/favicon.png">
		<link rel="stylesheet" href="config/stylesheet.css?<?php echo rand(1000, 10000); ?>" type="text/css">
	</head>
	<body>
			<main>
<?php 	while ($image = mysqli_fetch_row($resulta)) { echo "				<div class=\"pimg\"><div><div><div><img src=\"".$setimgpath.$image[0].".".$image[3]."\" id=\"\" name=\"\" alt=\"\"></div></div></div></div>"; } ?>
				<div class="pimg" style="height: 100%; width: 630px;"><div><div><div style="height:100%; text-align:left;"><h2 style="padding-top: 0px; margin-top: 0px;">Upcoming Shows:</h2>
<?php					while ($event = mysqli_fetch_row($resultb)) { $eventstarttime = date_create_from_format('U', $event[6]); $thiseventstartdate = date_format($eventstarttime, 'Y-m-d'); $thiseventstarttime = date_format($eventstarttime, 'h:iA'); echo "				<p style=\"text-align:left; padding-top: 0px; margin-top: 0px;\"><span style=\"font-size: 1.45em\">".$thiseventstartdate." - ".$thiseventstarttime."</span><br><br>".nl2br($event[5])."<br><br>".$event[2]."<br>".$event[3]."<br><span style=\"font-weight: bold\">Price:</span> ".$event[4]."<br><span style=\"font-weight: bold\">Tickets:</span> <a href=\"".$event[8]."\">".$event[8]."</a><br><br></p>"; } ?>
				</div></div></div></div>
			</main>
	</body>
</html>
<!-- Page Created by Rob Nesbitt Copyright 2026 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->