<?php
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Content-Security-Policy: default-src \'self\';');
// Basic Settings
	$site_name = "WellandMusic.Com"; // The name of this site. Used in various places around the site.
	$site_title = "WellandMusic.Com"; // The site title. Used in the title bar of the browser.
	$cploc = "http://www.wellandmusic.com/cp/";
	$mploc = "http://www.wellandmusic.com/";
	/* The preceding two variables should point to the directories for your control panel ($cploc), and your main page ($mploc). Be sure to follow
	all paths with a "/". */
	$passscript = "/home/thnkhost/public_html/wellandmusic.com/cp/password_protect.php";
// MySQL Settings
	$myshost = "localhost"; // MySQL Database Host Address
	$mysuser = "thnkhost_clients"; // MySQL Username
	$myspass = "REDACTED"; // MySQL Password
	$mysdb = "thnkhost_clientdb"; // MySQL Database
// Control Panel Settings - Please do not change these unless you know what you are doing.
	$logindb = "wm_login"; // Table For The Login Script
#	$mailinglistdb = "mailinglist"; // Table For The Mailing List Script
	$newsdb = "news"; // Table For The News Script
#	$aboutdb = "about"; // Table For The About Script
	$imgdb = "wm_images"; // Table For The Image Script
	$imgsectiondb = "wm_imagesections"; //Table For The Image Sections
	$eventsdb = "wm_events"; // Table For The Events Script
#	$videodb = "videos"; // Table For The Video Script
#	$videosectiondb = "vidsections"; //Table For The Video Sections
#	$contactdb = "contact"; // Table For The Contact Script
#	$productsdb = "products"; // Table For The Products Script
#	$prodsectiondb = "productsections"; // Table For The Product Sections
#	$fproddb = "featuredproducts"; // Table For The Featured Product
#	$accountsdb = "accounts"; // Table For The Accounts Script
// Image Gallery Settings
	$limit = 24;  // Number of images to display per page in the control panel.
	$setthmbh = 120;  // Max Thumbnail height
	$setthmbw = 120; // Max Thumbnail width
	$setmimgh = 260;  // Max Medium Image height
	$setmimgw = 195; // Max Medium Image width
	$setlimgh = 600;  // Max Large Image height
	$setlimgw = 780; // Max Large Image width
	$setimgpath = "photos/gallery/"; // Path to store gallery images (relative to the root directory of the site). Please use this directory ONLY for gallery images used with this script.	
//Product Database Settings
#	$setpimgpath = "photos/products/"; // Path to store product images (relative to the root directory of the site). Please use this directory ONLY for product images used with this script.
#	$pdlimit = 12; // Number of products to display per page
#	$pcplimit = 30; // Number of products to display per page in the control panel.
//MySQL Connect
$db = mysqli_connect($myshost, $mysuser, $myspass, $mysdb);
if (!$db) {
	error_log('Database connection failed');
	exit('Internal server error');

}
