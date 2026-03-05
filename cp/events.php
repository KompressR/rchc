<?php
include('../config/config.php');
include($passscript);
$thisfile = basename($_SERVER['PHP_SELF']);
/* Used to avoid "Page has expired" errors. */
$failcode = null;
$action = $_GET['action'] ?? null;
if ($action === "add") {
	if (!empty($_POST['eventname']) && !empty($_POST['eventvenue'])) {
		include('events1.php');
		header('Location: '.$cploc.$thisfile.'?action=done&psrc=add');
		exit;
	}
	else { 
		header('Location: '.$cploc.$thisfile.'?action=error&etype=1');
		$failcode = "1";
		exit;
	}
}
if ($action === "edit2") {
	if (!empty($_POST['eventname']) && !empty($_POST['eventvenue'])) {
		include('events1.php');
		header('Location: '.$cploc.$thisfile.'?action=done&psrc=edit2');
		exit;
	}
	else { 
		header('Location: '.$cploc.$thisfile.'?action=error&etype=1');
		$failcode = "1";
		exit;
	}
}
if ($action === "del2") {
	include('events1.php');
	header('Location: '.$cploc.$thisfile.'?action=done&psrc=del2');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en-CA">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $site_name; ?> Control Panel</title>
		<link rel="stylesheet" href="config/control.css" type="text/css">
		<!--[if IE]><link rel="stylesheet" href="config/iecontrol.css" type="text/css"><![endif]-->
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
<?php include('events1.php'); ?>
			</div>
<?php include('footer.php'); ?>
		</div>
	</body>
</html>