<?php function img_create($bigimg, $imgid, $imgft, $imgpath, $thmbabv, $thmbw, $thmbh) { //This function will create a thumbnail and place the images in the folder specified.
		$imageInfo = getimagesize($bigimg);
		$orw = $imageInfo[0];
		$orh = $imageInfo[1];
		if (($orw <= $thmbw) && ($orh <= $thmbh)) {
			$ndh = $orh;
			$ndw = $orw;
		}
		else {
			if (($thmbabv == "l") || ($thmbabv == "m")) {
				if ($orh <= $orw) {
					$op = ($thmbh / $orh);
					$ndh = $thmbh;
					$ndw = round($orw * $op);
					if ($ndw > $thmbw) {
						$op = ($thmbw / $orw);
						$ndw = $thmbw;
						$ndh = round($orh * $op);
					}
				}
				else {
					$op = ($thmbw / $orw);
					$ndw = $thmbw;
					$ndh = round($orh * $op);
					if ($ndh > $thmbh) {
						$op = ($thmbh / $orh);
						$ndh = $thmbh;
						$ndw = round($orw * $op);
					}
				}
			}
			elseif (($thmbabv == "s") || ($thmbabv == "sec") || ($thmbabv == "vidsec")) {
				$ndh = $thmbh;
				$ndw = $thmbw;
			}
		}
		$thumb = imagecreatetruecolor($ndw, $ndh);
		if ($imgft == 'image/jpeg') {
			$timg = ImageCreateFromJPEG($bigimg);
			imagecopyresampled($thumb, $timg, 0, 0, 0, 0, $ndw, $ndh, $orw, $orh);
			imagejpeg($thumb,'../'.$imgpath.$thmbabv.$imgid.'.jpg');
			$ptype = "jpg";
		}
		elseif ($imgft == 'image/png') {
			$timg = ImageCreateFromPNG($bigimg);
			imagecolortransparent($thumb, imagecolorallocate($timg, 0, 0, 0));
			imagealphablending($thumb, false);
			imagesavealpha($thumb, true);
			imagecopyresampled($thumb, $timg, 0, 0, 0, 0, $ndw, $ndh, $orw, $orh);
			imagepng($thumb,'../'.$imgpath.$thmbabv.$imgid.'.png');
			$ptype = "png";
		}
		elseif ($imgft == 'image/gif') {
			$timg = ImageCreateFromGIF($bigimg);
			imagecolortransparent($thumb, imagecolorallocate($timg, 0, 0, 0));
			imagealphablending($thumb, false);
			imagesavealpha($thumb, true);
			imagecopyresampled($thumb, $timg, 0, 0, 0, 0, $ndw, $ndh, $orw, $orh);
			imagegif($thumb,'../'.$imgpath.$thmbabv.$imgid.'.gif');
			$ptype = "gif";
		}
		imagedestroy($thumb); imagedestroy($timg);
		return ($ptype);
	}
?>