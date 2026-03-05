<?php
	/* The following preferences setup the pages for your use. Some defaults are in place for testing and setup purposes, be sure to adjust these for 
	your needs. */
	$moy = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'); 
	$month = 1; $day = 1; $year = date("Y"); $hour = 1; $minute = 0;
	$failcode = $failcode ?? null;
	if (isset($_GET['action'])) {
		if ($_GET['action'] == "done") {//Confirmation Pages
			include('cpconfirmation.php');
		}
		elseif ($_GET['action'] == "error") { //Error Pages
			include('cperrorcodes.php');
		}
		elseif ($_GET['action'] == "add") {	//Events Script Add Entry Script
			if ($failcode != "1") {
				$mname = trim($_POST['eventname']); $mday = trim($_POST['day']);
				$mmonth = trim($_POST['month']); $myear = trim($_POST['year']);
				$mvenue = trim($_POST['eventvenue']); $maddress = trim($_POST['eventaddress']); 
				$mprice = trim($_POST['eventprice']); $mdescription = trim($_POST['eventdescription']);
				$mtags = trim($_POST['tags']); $mstarthour = trim($_POST['starthour']);
				$mstartminute = trim($_POST['startminute']); $mticketlink = trim($_POST['ticketlink']);
				$munixstarttime = strtotime($myear."-".$mmonth."-".$mday." ".$mstarthour.":".$mstartminute.":00 ".$_POST['startampm']." UTC");
				$resulta = mysqli_prepare($db,"INSERT INTO $eventsdb (name, venue, address, price, description, unixstarttime, ticketlink, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");	
				if ($resulta === false) {die("Database Error");}
				mysqli_stmt_bind_param($resulta,"sssssiss",$mname,$mvenue,$maddress,$mprice,$mdescription,$munixstarttime,$mticketlink,$mtags);
				mysqli_stmt_execute($resulta);
				mysqli_stmt_close($resulta);
			}
		}
		elseif ($_GET['action'] == "del") {	//Events Script Delete Entry Page
			$mid = (int) $_GET['id'];
			$resultb = mysqli_prepare($db,"SELECT * FROM $eventsdb WHERE eventid=?");
			mysqli_stmt_bind_param($resultb,"i",$mid);
			mysqli_stmt_execute($resultb);
			$result = mysqli_stmt_get_result($resultb);
			$events = mysqli_fetch_row($result);
			mysqli_stmt_close($resultb);?>
				<h2>Delete Event:</h2>
				<div class="cpform">
					<div class="entrya">Event Name:</div>
					<div><?php echo htmlspecialchars($events[1], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Date:</div>
					<div><?php $eventstartdate = date_create_from_format('U', $events[6]); $thiseventstartdate = date_format($eventstartdate, 'Y-m-d'); echo $thiseventstartdate; ?></div>
					<div class="entrya">Time:</div>
					<div><?php $thiseventstarttime = date_format($eventstartdate, 'g:i A'); echo $thiseventstarttime; ?></div>
					<div class="entrya">Venue:</div>
					<div><?php echo htmlspecialchars($events[2], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Address:</div>
					<div><?php echo htmlspecialchars($events[3], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Price:</div>
					<div><?php echo htmlspecialchars($events[4], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Ticket Link:</div>
					<div><?php echo htmlspecialchars($events[8], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Tags:</div>
					<div><?php echo htmlspecialchars($events[9], ENT_NOQUOTES, 'UTF-8'); ?></div>
					<div class="entrya">Description:</div>
					<div class="textbody"><?php echo htmlspecialchars($events[5], ENT_QUOTES, 'UTF-8'); ?></div>
					<div style="padding-top: 40px; text-align: center;">Are you sure you want to delete this event?<br>
					<form method="post" action="<?php echo $thisfile; ?>?action=del2"><input type="hidden" name="id" value="<?php echo (int)$events[0]; ?>"><button type="submit">YES</button></form>
					<form method="post" action="<?php echo $thisfile; ?>"><button type="submit">NO</button></form>
				</div>
		<?php }
		elseif ($_GET['action'] == "del2") {	//Events Script Delete Entry Script
			$mid = (int) ($_POST['id'] ?? 0);
			$resultc = mysqli_prepare($db,"DELETE FROM $eventsdb WHERE eventid=?");
			mysqli_stmt_bind_param($resultc,"i",$mid);
			mysqli_stmt_execute($resultc);
			mysqli_stmt_close($resultc);
		}
		elseif ($_GET['action'] == "edit") {	//Events Script Edit Entry Page
			$mid = (int) $_GET['id'];
			$resultd = mysqli_prepare($db,"SELECT * FROM $eventsdb WHERE eventid=?");
			mysqli_stmt_bind_param($resultd,"i",$mid);
			mysqli_stmt_execute($resultd);
			$result = mysqli_stmt_get_result($resultd);
			$events = mysqli_fetch_row($result);
			mysqli_stmt_close($resultd);
			$eventstartdate = date_create_from_format('U', $events[6]); $thiseventstartday = date_format($eventstartdate, 'd'); $thiseventstartmonth = date_format($eventstartdate, 'm'); $thiseventstartyear = date_format($eventstartdate, 'Y'); $thiseventstarthour = date_format($eventstartdate, 'g'); $thiseventstartminute = date_format($eventstartdate, 'i'); $thiseventstartampm = date_format($eventstartdate, 'A');  
			?>
				<h2>Edit Event:</h2>
				<div class="cpform">
					<form method="post" action="<?php echo $thisfile; ?>?action=edit2&amp;id=<?php echo $events[0]; ?>">
						<div class="entrya"><label for="eventname">Event Name:</label></div>
						<div><input type="text" value="<?php echo htmlspecialchars($events[1], ENT_NOQUOTES, 'UTF-8'); ?>" id="eventname" name="eventname" required="required" /> Required</div>
						<div class="entrya"><label for="month">Start Time:</label></div>
						<div><select style="width: 135px;" id="month" name="month">
						<?php while ($month <= 12) { 
							$monthp = str_pad($month, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$monthp."\""; if ($thiseventstartmonth == $monthp) { echo " selected"; } echo ">".$moy[$month]."</option>\n"; $month++; 
						}			
						echo "						</select><select style=\"width: 61px;\" name=\"day\">\n";
						while ($day <= 31) { 
							$dayp = str_pad($day, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$dayp."\""; if ($thiseventstartday == $dayp) { echo " selected"; } echo ">".$dayp."</option>\n"; $day++; 
						}
						echo "						</select><select style=\"width: 81px;\" name=\"year\">\n";
						$sixyears = date("Y") + 6;
						while ($year <= $sixyears) { 
							echo "							<option value=\"".$year."\""; if ($thiseventstartyear == $year) { echo " selected"; } echo ">".$year."</option>\n"; $year++; 
						}
						echo "						</select><select style=\"width: 45px;\" name=\"starthour\">\n";
						while ($hour <= 12) { 
							$hourp = str_pad($hour, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$hourp."\""; if ($thiseventstarthour == $hour) { echo " selected"; } echo ">".$hourp."</option>\n"; $hour++; 
						}
						echo "						</select><select style=\"width: 45px;\" name=\"startminute\">\n";
						while ($minute <= 59) { 
							$minutep = str_pad($minute, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$minutep."\""; if ($thiseventstartminute == $minute) { echo " selected"; } echo ">".$minutep."</option>\n"; $minute++; 
						} ?>
						</select><select style="width:50px;" name="startampm"><option value="AM"<?php if ($thiseventstartampm == "AM") echo " selected";?>>AM</option><option value="PM"<?php if ($thiseventstartampm == "PM") echo " selected";?>>PM</option></select></div>
						<div class="entrya"><label for="eventvenue">Venue:</label></div>
						<div><input class="box" type="text" value="<?php echo stripslashes(htmlspecialchars_decode($events[2], ENT_NOQUOTES)); ?>" id="eventvenue" name="eventvenue" required="required" /> Required</div>
						<div class="entrya"><label for="eventaddress">Address:</label></div>
						<div><input class="box" type="text" value="<?php echo stripslashes(htmlspecialchars_decode($events[3], ENT_NOQUOTES)); ?>" id="eventaddress" name="eventaddress" /></div>
						<div class="entrya"><label for="eventprice">Price:</label></div>
						<div><input class="box" type="text" value="<?php echo stripslashes(htmlspecialchars_decode($events[4], ENT_NOQUOTES)); ?>" id="eventprice" name="eventprice" /> If Applicable</div>
						<div class="entrya"><label for="ticketlink">Ticket Link:</label></div>
						<div><input class="box" type="text" value="<?php echo stripslashes(htmlspecialchars_decode($events[8], ENT_NOQUOTES)); ?>" id="ticketlink" name="ticketlink" /></div>
						<div class="entrya"><label for="tags">Tags:</label></div>
						<div><input class="box" type="text" value="<?php echo stripslashes(htmlspecialchars_decode($events[9], ENT_NOQUOTES)); ?>" id="tags" name="tags" /></div>
						<div class="entrya"><label for="eventdescription">Description:</label></div>
						<div><textarea rows="12" cols="82" id="eventdescription" name="eventdescription"><?php echo htmlspecialchars($events[5], ENT_NOQUOTES, 'UTF-8'); ?></textarea></div>
						<div class="submit"><input style="width: 60px" type="submit" value="Submit" /></div>
					</form>
				</div> 
		<?php }
		elseif ($_GET['action'] == "edit2") {	//Events Script Edit Entry Script
			if ($failcode != "1") {
				$mname = trim($_POST['eventname']); $mday = trim($_POST['day']);
				$mmonth = trim($_POST['month']); $myear = trim($_POST['year']);
				$mvenue = trim($_POST['eventvenue']); $maddress = trim($_POST['eventaddress']); 
				$mprice = trim($_POST['eventprice']); $mdescription = trim($_POST['eventdescription']); 
				$mstarthour = trim($_POST['starthour']);
				$mstartminute = trim($_POST['startminute']); $mid = (int) $_GET['id'];
				$munixstarttime = strtotime($myear."-".$mmonth."-".$mday." ".$mstarthour.":".$mstartminute.":00 ".$_POST['startampm']." UTC"); $mticketlink = trim($_POST['ticketlink']); $mtags = trim($_POST['tags']);
				$resulte = mysqli_prepare($db,"UPDATE $eventsdb SET name=?, venue=?, address=?, price=?, description=?, unixstarttime=?, ticketlink=?, tags=? WHERE eventid=?");
				if ($resulte === false) {die("Database Error");}
				mysqli_stmt_bind_param($resulte,"sssssissi",$mname,$mvenue,$maddress,$mprice,$mdescription,$munixstarttime,$mticketlink,$mtags,$mid);
				mysqli_stmt_execute($resulte);
				mysqli_stmt_close($resulte);
			}
		}
		else { echo "				<div class=\"messages\"><h2>ERROR: The page you've selected is invalid. Please press the back button in your browser.</h2></div>\n";
		}
	}
	else {	//Events Script Start Page
		$resultf = mysqli_query($db,"SELECT * FROM $eventsdb ORDER BY unixstarttime DESC"); ?>
				<h2>Post Event:</h2>
				<div class="cpform">
					<form method="post" action="<?php echo $thisfile; ?>?action=add">
						<div class="entrya"><label for="eventname">Event Name:</label></div>
						<div><input type="text" id="eventname" name="eventname" required="required" /> Required</div>
						<div class="entrya"><label for="month">Start Time:</label></div>
						<div><select style="width: 135px;" id="month" name="month">
						<?php while ($month <= 12) { 
							$monthp = str_pad($month, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$monthp."\""; if (date("m") == $monthp) { echo " selected"; } echo ">".$moy[$month]."</option>\n"; $month++; 
						}			
						echo "						</select><select style=\"width: 61px;\" name=\"day\">\n";
						while ($day <= 31) { 
							$dayp = str_pad($day, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$dayp."\""; if (date("d") == $dayp) { echo " selected"; } echo ">".$dayp."</option>\n"; $day++; 
						}
						echo "						</select><select style=\"width: 81px;\" name=\"year\">\n";
						$sixyears = date("Y") + 6;
						while ($year <= $sixyears) { 
							echo "							<option value=\"".$year."\""; if (date("Y") == $year) { echo " selected"; } echo ">".$year."</option>\n"; $year++; 
						}
						echo "						</select><select style=\"width: 45px;\" name=\"starthour\">\n";
						while ($hour <= 12) { 
							$hourp = str_pad($hour, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$hourp."\""; if ($hourp == 12) { echo " selected"; } echo ">".$hourp."</option>\n"; $hour++; 
						}
						echo "						</select><select style=\"width: 45px;\" name=\"startminute\">\n";
						while ($minute <= 59) { 
							$minutep = str_pad($minute, 2, "0", STR_PAD_LEFT); echo "							<option value=\"".$minutep."\""; if ($minutep == 00) { echo " selected"; } echo ">".$minutep."</option>\n"; $minute++; 
						} ?>
						</select><select style="width:50px;" name="startampm"><option value="AM">AM</option><option value="PM" selected>PM</option></select></div>
						<div class="entrya"><label for="eventvenue">Venue:</label></div>
						<div><input type="text" id="eventvenue" name="eventvenue" required="required" /> Required</div>
						<div class="entrya"><label for="eventaddress">Address:</label></div>
						<div><input type="text" id="eventaddress" name="eventaddress" /></div>
						<div class="entrya"><label for="eventprice">Price:</label></div>
						<div><input type="text" id="eventprice" name="eventprice" /> If Applicable</div>
						<div class="entrya"><label for="ticketlink">Ticket Link:</label></div>
						<div><input type="text" id="ticketlink" name="ticketlink" /></div>
						<div class="entrya"><label for="tags">Tags:</label></div>
						<div><input type="text" id="tags" name="tags" /></div>
						<div class="entrya"><label for="eventdescription">Description:</label></div>
						<div><textarea rows="12" cols="93" id="eventdescription" name="eventdescription"></textarea></div>
						<div class="submit"><input style="width: 60px" type="submit" value="Submit" /></div>
					</form>
				</div>
				<h2>Edit Current Listings:</h2>
		<?php while ($shows = mysqli_fetch_row($resultf)) { $eventstartdate = date_create_from_format('U', $shows[6]); $thiseventstartdate = date_format($eventstartdate, 'Y-m-d');
			echo "				<div class=\"entrya\" style=\"text-align: center;\"><a href=\"".$thisfile."?action=edit&id=".$shows[0]."\">Edit</a> | <a href=\"".$thisfile."?action=del&id=".$shows[0]."\">Delete</a></div><div>".$thiseventstartdate." ".stripslashes(htmlspecialchars($shows[1], ENT_QUOTES))." @ ".stripslashes(htmlspecialchars($shows[2], ENT_QUOTES))."</div>\n";
		}
	}