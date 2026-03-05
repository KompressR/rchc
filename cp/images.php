<?php 
include('../config/config.php');
include($passscript);
$thisfile = basename($_SERVER['PHP_SELF']);
$failcode = null;
$action = $_GET['action'] ?? null;
if ($action === "add") {
	if ($_FILES['image']['error'] === UPLOAD_ERR_FORM_SIZE) {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=2'); 
		$failcode = "1";
		exit;
	}
	elseif ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE) {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=3'); 
		$failcode = "1";
		exit;
	}
	elseif ($_FILES['image']['error'] === UPLOAD_ERR_PARTIAL) {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=4'); 
		$failcode = "1";
		exit;
	}
	elseif ($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
		include('images1.php');		
		header('Location: '.$cploc.$thisfile.'?action=error&etype=5'); 
		$failcode = "1";
		exit;
	}
	elseif ($_FILES['image']['error'] === UPLOAD_ERR_NO_TMP_DIR) {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=6'); 
		$failcode = "1";
		exit;
	}
	elseif ($_FILES['image']['error'] === UPLOAD_ERR_CANT_WRITE) {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=7'); 
		$failcode = "1";
		exit;
	}
	elseif (($_FILES['image']['size'] != 0) && (!empty($_POST['title']))) {
		include('images1.php');
		$start = mysqli_real_escape_string($db,$_GET['start']);
		header('Location: '.$cploc.$thisfile.'?action=done&psrc=add&start='.$start.'');
		exit;
	}
	else { 
		header('Location: '.$cploc.$thisfile.'?action=error&etype=1'); 
		$failcode = "1";
		exit;
	}
}
if ($action === "edit2") {
	if (!empty($_POST['title'])) {
		include('images1.php');
		$mstart = mysqli_real_escape_string($db,$_GET['start']);
		header('Location: '.$cploc.$thisfile.'?action=done&psrc=edit2&start='.$mstart.'');
	}
	else {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=1'); 
		$failcode = "1";
	}
}
if ($action === "del2") { 
	include('images1.php');
	header('Location: '.$cploc.$thisfile.'?action=done&psrc=del2');
	
}
if ($action === "delsection2") { 
	include('images1.php');
	header('Location: '.$cploc.$thisfile.'?action=done&psrc=delsection2');
}
if ($action === "addsection") {
	if (!empty($_POST['title'])) {
		$start = mysqli_real_escape_string($db,$_GET['start']);
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=done&psrc=addsection');
	}
	else {
		include('images1.php');
		header('Location: '.$cploc.$thisfile.'?action=error&etype=1'); 
		$failcode = "1";
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en-CA">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $site_name; ?> Control Panel</title>
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
<?php include('images1.php'); ?>
			</div>
<?php include('footer.php') ?>
		</div>
	</body>
</html>