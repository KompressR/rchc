<?php	if ($limit < $nume) {
			echo "			<div class=\"pagenumbers\">\n";
			if($back >=0) {
				echo "			<a href=\"".$thisfile."?start=".$back."\" rel=\"prev\">PREV</a>";
			}
			$i=0;
			$l=1;
			for ($i=0;$i < $nume;$i=$i+$limit) {
				if($i <> $eu) { echo " <a href=\"".$thisfile."?start=".$i."\">".$l."</a>"; }
				else { echo " ".$l;} 
				$l=$l+1;
			}
			if($current < $nume) { echo " <a href=\"".$thisfile."?start=".$next."\" rel=\"next\">NEXT</a>"; }
			echo "<br></div>";
		}
?>