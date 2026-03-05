<?php include('config/config.php'); 
$resulta = mysqli_query($db,"SELECT * FROM $imgdb ORDER BY imageid DESC LIMIT 1");
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
<?php while ($image = mysqli_fetch_row($resulta)) { echo "				<div class=\"pimg\"><div><div><div><a href=\"https://www.3common.com/u/wellandmusic\"><img src=\"".$setimgpath.$image[0].".".$image[3]."\" id=\"\" name=\"\" alt=\"\"><br>Click above for tickets!</a></div></div></div></div>"; }?>
			</main>
	</body>
</html>
<!-- Page Created by Rob Nesbitt Copyright 2026 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->