<?php
	$myDB = new mSQL;
	if (isset($_POST['l']) and $_POST['l'] == "Submit") {
		echo "save entry";	
		if ($_POST['name'] <> "") {
			$rs = $myDB->insertQ("guestbook",array("edate","name","email","comments"),array(date("Y-m-d H:i:s"),$_POST['name'],$_POST['email'],$_POST['comment']));
			if ($rs) {
				echo "
	&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><b>Guestbook Entry Submitted</b></span><br class='clr' />";
			} else {
				echo "
	&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><b>Error while saving Guestbook Entry</b></span><br class='clr' />";
			}
		} else {
			echo "
	&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><b>Name Field may not be left blank.</b></span><br class='clr' />";
		}
		echo "<hr>";
	}
	if (isset($_REQUEST['s']) and $_REQUEST['s'] == "sign") {
		echo "
	<form name='guestbook' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."'>
		<label class='lay4col-lbl' align='right'>Name:</label><input class='lay2col-fld' type='text' name='name'><br class='clr' />
		<label class='lay4col-lbl' align='right'>E-Mail:</label><input class='lay2col-fld' type='text' name='email'><br class='clr' />
		<label class='lay4col-lbl' align='right'>Comments:</label><textarea class='lay2col-txt' name='comment' cols='70'></textarea><br class='clr' />
		<label class='lay4col-lbl' align='right'>&nbsp;</label><input class='lay4col-btn' type='submit' name='l' value='Submit'><br class='clr' />
	</form>
	<hr>";
	} else {
		echo "
	&nbsp;&nbsp;&nbsp;&nbsp;<span class='fpstlk'><a href='index.php?p=".$_SESSION['myContent']->pIdx."&s=sign'>Sign Guestbook</a></span><br class='clr' /><hr>";
	}
	$res = $myDB->selectQ("guestbook","*","","edate DESC");
	if ($res) {
		foreach ($res as $row) {
			echo "
	<label class='lay3col-lbl' align='right'>Date and Time:</label><span class='lay2col-fld'><b>".date("F j, Y H:i:s T",strtotime($row["edate"]))."</b></span><br class='clr' />
	<label class='lay3col-lbl' align='right'>Name:</label><span class='lay2col-fld'><b>".$row["name"]."</b></span><br class='clr' />
	<label class='lay3col-lbl' align='right'>E-Mail:</label><span class='lay2col-fld'><b>".$row["email"]."</b></span><br class='clr' />
	<label class='lay3col-lbl' align='right'>Comments:</label><span class='lay2col-fld'><b>".$row["comments"]."</b></span><br class='clr' />
	<hr>";
		}
	}
?>