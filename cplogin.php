<?php include('config/config.php');
// User will be redirected to this page after logout
define('LOGOUT_URL', 'http://www.wellandmusic.com/');
// time out after NN minutes of inactivity. Set to 0 to not timeout
define('TIMEOUT_MINUTES', 0);
// This parameter is only useful when TIMEOUT_MINUTES is not zero
// true - timeout time from last activity, false - timeout time from login
define('TIMEOUT_CHECK_ACTIVITY', true);
// timeout in seconds
$timeout = (TIMEOUT_MINUTES == 0 ? 0 : time() + TIMEOUT_MINUTES * 60);
// logout?
if(isset($_GET['logout'])) {
	setcookie("verify", '', $timeout, '/'); // clear password;
	header('Location: ' . LOGOUT_URL);
	exit();
}
if(!function_exists('showLoginPasswordProtect')) {
	// show login form
	function showLoginPasswordProtect($error_msg,$mploc) { ?>
<!DOCTYPE html>
<html lang="en-CA">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache">
		<title><?php echo $site_title ?></title>
		<link rel="stylesheet" href="config/stylesheet.css?<?php echo rand(1000, 10000); ?>" type="text/css">
	</head>
	<body>
		<div class="main">
<?php include('header.php'); ?>
			<h2>Control Panel Login</h2>
			<main>
				<form method="post">
					<?php if ($error_msg != "") { echo "<div>Error: ".$error_msg."</div>"; } ?>
					<div>Please log in to continue:</div><br>
					<div>
						<label for="access_login">Login:</label><br>
						<input type="text" name="access_login" id="access_login" value="" maxlength="100" required>
					</div>
					<div>
						<label for="access_password">Password:</label><br>
						<input  type="password" name="access_password" id="access_password" value="" maxlength="100" required>
					</div>
					<div>
						<input type="submit" name="Submit" value="Submit">
					</div>
				</form>
			</main>
<?php include('footer.php'); ?>
		</div>
	</body>
</html>
<!-- Page Created by Rob Nesbitt Copyright 2026 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->
<?php
// stop at this point
		die();
	}
}
// If Password is set, check for matching combo in database.
if (isset($_POST['access_password'])) {
	$login = isset($_POST['access_login']) ? $_POST['access_login'] : '';
	$pass = mysqli_real_escape_string($db,$_POST['access_password']);
	$result = mysqli_query($db,"SELECT pass FROM $logindb where user='$login'");
	$rtpass = mysqli_fetch_row($result);
	if ((mysqli_num_rows($result) == 0) || ($pass != $rtpass[0])) {
		showLoginPasswordProtect("Incorrect password.",$mploc);
	}
	else {
// set cookie if password was validated
		setcookie("verify", md5($login.'%'.$pass), $timeout, '/');
		$userlogin = $_POST['access_login'];
		unset($_POST['access_login']);
		unset($_POST['access_password']);
		unset($_POST['Submit']);
	}
}
// If Password is not set, check for cookie and verify.
else {
	if (!isset($_COOKIE['verify'])) {
		showLoginPasswordProtect("",$mploc);
	}
	$result1 = mysqli_query($db,"SELECT user, pass FROM $logindb");
	$found = false;
	while($login_info = mysqli_fetch_array($result1)) {
		$lp = $login_info[0].'%'.$login_info[1];
		if ($_COOKIE['verify'] == md5($lp)) {
			$found = true;
			if (TIMEOUT_CHECK_ACTIVITY) {
				setcookie("verify", md5($lp), $timeout, '/');
			}
			$userlogin = $login_info[0];
			break;
		}
	}
	if (!$found) { showLoginPasswordProtect("",$mploc); }
}
header("location: $cploc");
die();
?>