<?php
	$failcode = $failcode ?? null;
	if (isset($_GET['action'])) {
		if ($_GET['action'] == "done") {//Confirmation Pages
			include('cpconfirmation.php');
		}
		elseif ($_GET['action'] == "error") {//Error Pages
			include('cperrorcodes.php');
		}
		elseif ($_GET['action'] == "add") {//News Script Add Entry Page
			if ($failcode != "1") {
				$date = time();
				$mtitle = trim($_POST['newstitle']); $mmessage = trim($_POST['newsmessage']);
				$resulta = mysqli_prepare($db,"INSERT INTO $newsdb (title, date, message) VALUES (?, ?, ?)");
				if ($resulta === false) {die("Database Error");}
				mysqli_stmt_bind_param($resulta,"sis",$mtitle,$date,$mmessage);
				mysqli_stmt_execute($resulta);
				mysqli_stmt_close($resulta);
			}
		}
		elseif ($_GET['action'] == "del") {	//News Script Delete Entry Page
			$mid = (int) $_GET['id'];
			$resultb = mysqli_prepare($db,"SELECT * FROM $newsdb WHERE newsid=?");
			mysqli_stmt_bind_param($resultb,"i",$mid);
			mysqli_stmt_execute($resultb);
			$result = mysqli_stmt_get_result($resultb);
			$news = mysqli_fetch_row($result);
			mysqli_stmt_close($resultb);?>
				<h2>Delete News Entry:</h2>
				<div class="cpform">
					<div class="entrya">Title:</div>
					<div><?php echo htmlspecialchars($news[1], ENT_QUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Date:</div>
					<div><?php $eventstartdate = date_create_from_format('U', $news[2]); $thiseventstartdate = date_format($eventstartdate, 'Y-m-d'); echo $thiseventstartdate; ?></div>
					<div class="entrya">Message:</div>
					<div class="textbody"><?php echo htmlspecialchars($news[3], ENT_QUOTES, 'UTF-8'); ?></div>
					<div style="padding-top: 40px; text-align: center;">Are you sure you want to delete this news entry?<br>
					<form method="post" action="<?php echo $thisfile; ?>?action=del2"><input type="hidden" name="id" value="<?php echo (int)$news[0]; ?>"><button type="submit">YES</button></form>
					<form method="post" action="<?php echo $thisfile; ?>"><button type="submit">NO</button></form>
				</div>
		<?php }
		elseif ($_GET['action'] == "del2") {	//News Script Delete Entry Script
			$mid = (int) ($_POST['id'] ?? 0);
			$resultc = mysqli_prepare($db,"DELETE FROM $newsdb WHERE newsid=?");
			mysqli_stmt_bind_param($resultc,"i",$mid);
			mysqli_stmt_execute($resultc);
			mysqli_stmt_close($resultc);
		}
		elseif ($_GET['action'] == "edit") {	//News Script Edit Entry Page
			$mid = (int) $_GET['id'];
			$resultd = mysqli_prepare($db,"SELECT * FROM $newsdb WHERE newsid=?");
			mysqli_stmt_bind_param($resultd,"i",$mid);
			mysqli_stmt_execute($resultd);
			$result = mysqli_stmt_get_result($resultd);
			$news = mysqli_fetch_row($result);
			mysqli_stmt_close($resultd); ?>
				<h2>Edit News Entry:</h2>
				<div class="cpform">
					<form method="post" action="<?php echo $thisfile; ?>?action=edit2&amp;id=<?php echo $mid; ?>">
						<div class="entrya"><label for="newstitle">Title:</label></div>
						<div style="float:left; width: 575px;"><input type="text" id="newstitle" name="newstitle" maxlength="150" style="width: 565px;" value="<?php echo htmlspecialchars($news[1], ENT_NOQUOTES, 'UTF-8'); ?>" required="required" /></div>
						<div class="entrya" style="width: 35px; clear: none">Date: </div>
						<div><?php $eventstartdate = date_create_from_format('U', $news[2]); $thiseventstartdate = date_format($eventstartdate, 'Y-m-d'); echo $thiseventstartdate; ?></div>
						<div class="entrya"><label for="newsmessage">Message:</label></div>
						<div><textarea rows="12" cols="93" id="newsmessage" name="newsmessage" required="required"><?php echo htmlspecialchars($news[3], ENT_NOQUOTES, 'UTF-8'); ?></textarea></div>
						<div class="submit"><input style="width: 60px" type="submit" value="Submit" /></div>
					</form>
				</div>
		<?php }
		elseif ($_GET['action'] == "edit2") {	//News Script Edit Entry Script
			if ($failcode != "1") {
				$mtitle = trim($_POST['newstitle']); $mmessage = trim($_POST['newsmessage']); $mid = (int) $_GET['id'];
				$resulte = mysqli_prepare($db,"UPDATE $newsdb SET title=?, message=? WHERE newsid=?");
				if ($resulte === false) {die("Database Error");}
				mysqli_stmt_bind_param($resulte,"sss",$mtitle,$mmessage,$mid);
				mysqli_stmt_execute($resulte);
				mysqli_stmt_close($resulte);
			}
		}
		else { echo "				<div class=\"messages\"><h2>ERROR: The page you've selected is invalid. Please press the back button in your browser.</h2></div>\n";
		}
	}
	else {	//News Script Start Page
		$resultf = mysqli_query($db,"SELECT * FROM $newsdb ORDER BY newsid DESC"); ?>
				<h2>Post News Entry:</h2>
				<div class="cpform">
					<form method="post" action="<?php echo $thisfile; ?>?action=add">
						<div class="entrya"><label for="newstitle">Title:</label></div>
						<div style="float:left; width: 575px;"><input type="text" id="newstitle" name="newstitle" maxlength="150" style="width: 565px;" required="required" /></div>
						<div class="entrya" style="width: 35px; clear: none;">Date: </div>
						<div><?php echo date("Y-m-d"); ?></div>
						<div class="entrya"><label for="newsmessage">Message:</label></div>
						<div><textarea rows="12" cols="93" id="newsmessage" name="newsmessage" required="required"></textarea></div>
						<div class="submit"><input style="width: 60px" type="submit" value="Submit" /></div>
					</form>
				</div>
				<h2>Edit/Delete News Entry:</h2>
		<?php while ($news = @mysqli_fetch_row($resultf)) { $newsdate = date_create_from_format('U', $news[2]); $newsdate->setTimezone(new DateTimeZone('America/Toronto')); $thisnewsdate = date_format($newsdate, 'Y-m-d g:i A');
			echo "				<div class=\"entrya\" style=\"text-align: center;\"><a href=\"".$thisfile."?action=edit&amp;id=".$news[0]."\">Edit</a> | <a href=\"".$thisfile."?action=del&amp;id=".$news[0]."\">Delete</a></div><div>".$thisnewsdate." ".stripslashes(htmlspecialchars_decode($news[1], ENT_QUOTES))."</div>\n";
		}
	}