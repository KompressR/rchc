<?php
// User will be redirected to this page after logout
define('LOGOUT_URL', 'http://www.robnesbitt.com/scriptlibrary/index.php');
// time out after NN minutes of inactivity. Set to 0 to not timeout
define('TIMEOUT_MINUTES', 0);
// This parameter is only useful when TIMEOUT_MINUTES is not zero
// true - timeout time from last activity, false - timeout time from login
define('TIMEOUT_CHECK_ACTIVITY', true);
if(isset($_GET['help'])) {
	die('Include following code into every page you would like to protect, at the very beginning (first line):<br>&lt;?php include("' . str_replace('\\','\\\\',__FILE__) . '"); ?&gt;');
}
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
	function showLoginPasswordProtect($error_msg, $mploc) {
		header("location: ".$mploc."cplogin.php");
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
?>