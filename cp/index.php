<?php include('../config/config.php');
require_once $passscript; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?php echo htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8'); ?> Control Panel</title>
		<link rel="stylesheet" href="config/control.css" type="text/css">
	</head>
	<body>
		<div class="main">
			<div>
<?php include('header.php'); ?>
			</div>
			<div class="nav">
<?php include('nav.php'); ?>
			</div>
			<div class="content">
				<p>Welcome to your control panel. You may make changes to various parts of your website through the links on the left.</p>
			</div>
<?php include('footer.php'); ?>
		</div>
	</body>
</html>