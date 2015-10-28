<?php
	if (!isset($_SESSION['mySlides'])) {
		$_SESSION['mySlides'] = new slideshow_images;
	}
	$c = $_SESSION['mySlides']->current_img;
	$showLink = "&d=on'>Start";
	if (isset($_REQUEST['d'])) {
		$t = count($_SESSION['mySlides']->images) - 1;
		switch ($_REQUEST['d']) {
			case "first":
				$c = 0;
				break;
			case "prev":
				if ($c == 0) {
					$c = $t;
				} else {
					$c--;
				}
				break;
			case "next":
				if ($c == $t) {
					$c = 0;
				} else {
					$c++;
				}
				break;
			case "last":
				$c = $t;
				break;
			case "on":
				$showLink = "&d=off'>Stop";
					if ($c == $t) {
						$c = 0;
					} else {
						$c++;
					}
					echo "
<script type='text/JavaScript'>
	timedRefresh(5000);
</script>";
				break;
			case "off":
				break;
		}
		$_SESSION['mySlides']->current_img = $c;
	}
	extract($_SESSION['mySlides']->images[$c]);
	echo "
<div id='image_holder'>
	<image src='".$file."' name='mySlides' width='600' height='450'>
</div>
<div id='image_controls'>
	<label class='image_title'><b>".$title."</b></label>
    <label class='image_caption'><i>".$caption."</i></label><br /><hr />
	<a href='index.php?p=".$_SESSION['myContent']->pIdx."&d=first'><<-First Image</a>
    <a href='index.php?p=".$_SESSION['myContent']->pIdx."&d=prev'><-Previous Image</a>
    <a href='index.php?p=".$_SESSION['myContent']->pIdx.$showLink." Slideshow</a>
    <a href='index.php?p=".$_SESSION['myContent']->pIdx."&d=next'>Next Image-></a>
    <a href='index.php?p=".$_SESSION['myContent']->pIdx."&d=last'>Last Image->></a>
</div>";
?>