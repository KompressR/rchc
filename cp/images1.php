<?php
	/* The following preferences setup the pages for your use. Some defaults are in place for testing and setup purposes, be sure to adjust these for 
	your needs. */
	include('thumbgenerator.php');
	/* Script Begin */
	if (isset($_GET['action'])) { 
		if ($_GET['action'] == "done") { //Confirmation Pages
			include('cpconfirmation.php');
		}
		elseif ($_GET['action'] == "error") { //Error Pages
			include('cperrorcodes.php');
		}
		elseif ($_GET['action'] == "add") {	//Add Image Script
			if ($failcode != "1") {
				$mtitle = htmlspecialchars(mysqli_real_escape_string($db,$_POST['title']), ENT_QUOTES);
				$msection = $_POST['section'];
				$resulta = mysqli_query($db,"SELECT * FROM $imgdb ORDER BY imageid DESC");
				if (!mysqli_num_rows($resulta)) { $getimgid = 1; }
				else {
					$reseta = mysqli_data_seek($resulta, 0);
					$images = mysqli_fetch_row($resulta);
					$getimgid = $images[0] + 1;
				}
				$getbigimg = $_FILES['image']['tmp_name'];
				$getimgft = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['image']['tmp_name']);
				$smallthumb = img_create($getbigimg, $getimgid, $getimgft, $setimgpath, 's', $setthmbw, $setthmbh);
				$mediumthumb = img_create($getbigimg, $getimgid, $getimgft, $setimgpath, 'm', $setmimgw, $setmimgh);
				$largethumb = img_create($getbigimg, $getimgid, $getimgft, $setimgpath, 'l', $setlimgw, $setlimgh);
				move_uploaded_file($getbigimg, '../'.$setimgpath.$getimgid.'.'.$smallthumb);
				$resultb = mysqli_query($db,"INSERT INTO $imgdb (imageid, title, imgsection, imgtype) VALUES ('$getimgid', '$mtitle', '$msection', '$smallthumb')");
			}
		}
		elseif ($_GET['action'] == "del") {	//Delete Image Display Page
			$mid = mysqli_real_escape_string($db,$_GET['id']); $mstart = $_GET['start'];
			$resultc = mysqli_query($db,"SELECT * FROM $imgdb WHERE imageid='$mid'");
			$images = mysqli_fetch_row($resultc); ?>
				<h2>Delete Image:</h2>
				<div class="cpform">
					<div style="text-align: center;"><img src="../<?php echo $setimgpath."l".$images[0].".".$images[3]; ?>" style="width: 780px;" alt="<?php echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?>" /><br><br><?php echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?></div>
					<div style="padding-top: 40px; text-align: center;">Are you sure you want to delete this image?<br>
						<a href="<?php echo $thisfile; ?>?action=del2&amp;id=<?php echo $mid; ?>&amp;start=<?php echo $mstart; ?>&amp;ptype=<?php echo $images[3];?>">YES</a> | <a href="<?php echo $thisfile; ?>?start=<?php echo $mstart; ?>">NO</a>
					</div>
				</div>
		<?php }
		elseif ($_GET['action'] == "del2") {	//Delete Image Script/Confirmation Page
			$mid = mysqli_real_escape_string($db,$_GET['id']); $mstart = $_GET['start'];
			$mptype = mysqli_real_escape_string($db,$_GET['ptype']);
			$resultd = mysqli_query($db,"DELETE FROM $imgdb WHERE imageid=$mid");
			unlink('../'.$setimgpath.'m'.$mid.'.'.$mptype.''); unlink('../'.$setimgpath.'s'.$mid.'.'.$mptype.'');
			unlink('../'.$setimgpath.$mid.'.'.$mptype.''); unlink('../'.$setimgpath.'l'.$mid.'.'.$mptype.'');
			$optimize = mysqli_query($db,"OPTIMIZE TABLE $imgdb");
		}
		elseif ($_GET['action'] == "edit") {	//Edit Image Display Page
			$mid = mysqli_real_escape_string($db,$_GET['id']); $mstart = $_GET['start'];
			$resulte = mysqli_query($db,"SELECT * FROM $imgdb WHERE imageid='$mid'");
			$images = mysqli_fetch_row($resulte);
			$resultf = mysqli_query($db,"SELECT * FROM $imgsectiondb");
			$resultg = mysqli_query($db,"SELECT * FROM $imgsectiondb ORDER BY imgsectionid ASC");
			$numsec = @mysqli_num_rows($resultf); ?>
				<h2>Edit Caption:</h2>
				<div class="cpform">
					<div style="text-align: center; padding-bottom: 20px;"><img src="../<?php echo $setimgpath."l".$images[0].".".$images[3]; ?>" alt="<?php echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?>" style="width: 780px;" /></div>
					<form method="post" action="<?php echo $thisfile; ?>?action=edit2&amp;id=<?php echo $mid; ?>&amp;start=<?php echo $mstart; ?>">
			<?php if ($numsec == 1 || $numsec == 0) { ?> <input type="hidden" name="section" value="1" /> <?php }
			else { //Image Section Dropdown Start ?>
					<div style="text-align: center"><label for="section">Image Section:</label>
						<select id="section" name="section">
			<?php while ($imgsec = mysqli_fetch_row($resultg)) { ?>
							<option value="<?php echo $imgsec[0]; ?>" <?php if ($images[2] == $imgsec[0]) { ?> selected="selected" <?php } echo ">".$imgsec[1]; ?></option> 
			<?php } ?>
						</select>
			<?php //Image Section Dropdown End ?>
						<a href="<?php echo $thisfile; ?>?action=editsections">Edit Sections</a>
					</div> 
			<?php } ?>
					<div style="text-align: center"><label for="title">Caption:</label> <input type="text" id="title" name="title" value="<?php echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?>" style="width: 500px;" /></div>
					<div class="submit"><input style="width: 120px" type="submit" value="Submit Changes" /></div>
				</div>
		<?php }
		elseif ($_GET['action'] == "edit2") {	//Edit Image Script/Confirmation Page
			if (!empty($_POST['title'])) {
				$mtitle = htmlspecialchars(mysqli_real_escape_string($db,$_POST['title']), ENT_QUOTES); $mid = mysqli_real_escape_string($db,$_GET['id']);
				$msection = mysqli_real_escape_string($db,$_POST['section']); $mstart = $_GET['start'];
				$resulth = mysqli_query($db,"UPDATE $imgdb SET title='$mtitle', imgsection='$msection' WHERE imageid=$mid");
			}
		}
		elseif ($_GET['action'] == "editsections") {	//Edit Sections Page
			$resulti = mysqli_query($db,"SELECT * FROM $imgsectiondb ORDER BY imgsectionid ASC"); ?>
				<h2>Add Section:</h2>
				<div class="cpform">
					<form enctype="multipart/form-data" action="<?php echo $thisfile; ?>?action=addsection" method="post">
					<input type="hidden" name="MAX_FILE_SIZE" value="12340032" />
					<div class="entrya"><label for="image">Browse To Image:</label></div>
					<div><input id="image" name="image" type="file" /></div>
					<div class="entrya"><label for="title">Title:</label></div>
					<div><input id="text" type="text" name="title" /></div>
					<div class="submit"><input style="width: 100px" type="submit" value="Add Section" /></div>
					</form>
				</div>
				<h2>Current Sections:</h2>
<?php while ($imgsec = @mysqli_fetch_row($resulti)) {
	echo "<a href=\"".$thisfile."?action=delsection&amp;imgsecid=".$imgsec[0]."\">Delete<a> - ".$imgsec[1]."<br>\n";
} ?>
		<?php }
		elseif ($_GET['action'] == "addsection") {	//Add Section Script/Confirmation Page
			if ($failcode != "1") {
				$mtitle = htmlspecialchars(mysqli_real_escape_string($db,$_POST['title']), ENT_QUOTES); $mstart = $_GET['start'];
				if ($_FILES['image']['size'] != 0) {
					$resultj = mysqli_query($db,"SELECT * FROM $imgsectiondb ORDER BY imgsectionid DESC");
					if (!mysqli_num_rows($resultj)) { $getimgid = 1; }
					else {
						$resetj = mysqli_data_seek($resultj, 0);
						$images = mysqli_fetch_row($resultj);
						$getimgid = $images[0] + 1;
					}
					$getbigimg = $_FILES['image']['tmp_name'];
					$getimgft = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['image']['tmp_name']);
					$getptype = img_create($getbigimg, $getimgid, $getimgft, $setimgpath, sec, $setthmbw, $setthmbh);
					$resultk = mysqli_query($db,"INSERT INTO $imgsectiondb (imgsectionid, title, imgtype) VALUES ('$getimgid', '$mtitle', '$getptype')");
				}
				else { $resultl = mysqli_query($db,"INSERT INTO $imgsectiondb (title, imgtype) VALUES ('$mtitle', '0')"); }
			}
		}
		elseif ($_GET['action'] == "delsection") {	//Delete Section Confirmation Page
			$mid = mysqli_real_escape_string($db,$_GET['imgsecid']); $mstart = $_GET['start'];
			$resultm = mysqli_query($db,"SELECT * FROM $imgsectiondb WHERE imgsectionid='$mid'");
			$images = mysqli_fetch_row($resultm); ?>
				<h2>Delete Section:</h2>
				<div class="cpform">
					<div style="text-align: center;"><?php if ($images[2] != 0) { ?><img src="../<?php echo $setimgpath."sec".$images[0].".".$images[2]; ?>" alt="<?php echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?>" /><br><br><?php } echo stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); ?></div>
					<div style="padding-top: 20px; text-align: center;">Are you sure you want to delete this section?<br><a href="<?php echo $thisfile; ?>?action=delsection2&amp;id=<?php echo $mid; ?>&amp;ptype=<?php echo $images[2]; ?>">YES</a> | <a href="<?php echo $thisfile; ?>?start=<?php echo $mstart; ?>">NO</a></div>
				</div>
		<?php }
		elseif ($_GET['action'] == "delsection2") {	//Delete Section Script
			$mid = mysqli_real_escape_string($db,$_GET['id']);
			$mptype = mysqli_real_escape_string($db,$_GET['ptype']);
			$resultn = mysqli_query($db,"DELETE FROM $imgsectiondb WHERE imgsectionid=$mid");
			unlink('../'.$setimgpath.'sec'.$mid.'.'.$mptype.'');
			$optimize = mysqli_query($db,"OPTIMIZE TABLE $imgsectiondb");
		}
		else {
				echo "				<div class=\"messages\"><h2>ERROR: You have selected an action that does not exist. Please press the back button in your browser and try again. If the problem persists, contact your administrator. (Code #002)</h2></div>\n";
		}
	}
	else {	//Images Script Start Page
		if(isset($_GET['start'])) { $start=$_GET['start']; }
		if(!isset($start)) { $start = 0;}
		$resulto = mysqli_query($db,"SELECT * FROM $imgsectiondb");
		$resultp = mysqli_query($db,"SELECT * FROM $imgsectiondb ORDER BY imgsectionid ASC");
		$numsec = @mysqli_num_rows($resulto);
		?>
				<h2>Upload Photo:</h2>
				<div class="cpform">
					<form method="post" enctype="multipart/form-data" action="<?php echo $thisfile; ?>?action=add&amp;start=<?php echo $start; ?>">
					<input type="hidden" name="MAX_FILE_SIZE" value="12340032" />
		<?php if ($numsec == 1 || $numsec == 0) { ?> <input type="hidden" name="section" value="1" /> <?php }
		else { //Image Section Dropdown Start ?>
					<div><div class="entrya"><label for="section">Image Section:</label></div>
						<select id="section" name="section">
		<?php while ($imgsec = mysqli_fetch_row($resultp)) { ?>
							<option value="<?php echo $imgsec[0]; ?>" <?php if ($_GET['type'] == $imgsec[0]) { ?> selected="selected" <?php } echo ">".$imgsec[1]; ?></option> 
		<?php } ?>
						</select>
		<?php //Image Section Dropdown End ?>
						<a href="<?php echo $thisfile; ?>?action=editsections">Edit Sections</a>
					</div> 
		<?php } ?>
					<div>
						<div class="entrya"><label for="image">Browse To Image:</label></div>
						<div style="float:left"><input name="image" id="image" type="file" /></div>
					</div><br>
					<div style="clear: both">
						<div class="entrya"><label for="title">Caption:</title></div>
						<div><input type="text" id="title" name="title" /></div><br>
						<div class="submit"><input style="width: 100px" type="submit" value="Upload Image" /></div>
					</div>
					</form>
				</div>
				<h2>Edit/Delete Image:</h2>
		<?php
		$eu = ($start - 0);
		$current = $eu + $limit;
		$back = $eu - $limit;
		$next = $eu + $limit;
		$resultq = mysqli_query($db,"SELECT * FROM $imgdb ORDER BY imageid ASC LIMIT $eu, $limit");
		$resultr = mysqli_query($db,"SELECT * FROM $imgdb");
		$nume = @mysqli_num_rows($resultr);
		echo "			<div class=\"edirow\">";
		$imgr = 0;
		if ($nume == 0) { echo "<div style=\"padding-left: 240px;\">There are currently no images in the gallery.</div>"; }
		else {
			while ($images = mysqli_fetch_row($resultq)) {
				if (mb_strwidth(stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES))) >= 34) {
					$caption = rtrim(mb_strimwidth(stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)), 0, 30))."..."; 
				}
				else { $caption = stripslashes(htmlspecialchars_decode($images[1], ENT_QUOTES)); }
				echo "				<div class=\"pimg\"><div><div><div>
				<img src=\"../".$setimgpath."s".$images[0].".".$images[3]."\" alt=\"".$caption."\" /><br>".$caption."<br><a href=\"$thisfile?action=edit&amp;id=$images[0]&amp;start=".$start."\">Edit</a> | <a href=\"$thisfile?action=del&amp;id=$images[0]&amp;start=$start\">Delete</a>
				</div></div></div></div>\n";
				$imgr++;
				if ($imgr == 4) { echo "			</div><div class=\"edirow\">\n"; $imgr = 0; }
			}
		}
		echo "			</div>";
		if (($imgr < 3) && ($imgr != 0)) { echo "			<!--[if IE]><br><![endif]-->\n"; }
		include('pagenumbers.php');
	}
?>
<!-- LL Multi-section Image Gallery V2.0 Final - 2015-01-25 -->
<!-- Page Created by Rob Nesbitt Copyright 2017 Lifelong Designs -->
<!-- This site is valid HTML5. All pages created and edited exclusively in Notepad++. -->