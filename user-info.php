<?php
	$user = new mSQL;
	$luser = $user->selectQ("users","*","username = '".$_SESSION['logged']->user."'","");
	extract($luser[0]);
	$rdchk = array();
	for ($x=1; $x <= 5; $x++) {
		$rdchk[$x] = "";
	}
	$rdchk[$mnuschema] = " checked";
	if (isset($_SESSION['usermsg'])) {
		echo "<h3><b>".$_SESSION['usermsg']."</b></h3><hr>";
		unset($_SESSION['usermsg']);
	}
	echo "
<form name='userinfo' method='post' action='index.php?p=99'>
	<label class='lay2col-lbl' align='right'>Username:</label><span class='lay2col-fld'><b>".$username."</b></span><br />
	<label class='lay2col-lbl' align='right'>Full Name:</label><input class='lay2col-fld' type='text' name='fname' value='".$fullname."' /><br />
	<label class='lay2col-lbl' align='right'>Password:</label><input class='lay2col-fld' type='password' name='pword1' /><br />
	<label class='lay2col-lbl' align='right'>Confirm Password:</label><input class='lay2col-fld' type='password' name='pword2' /><br />
	<label class='lay2col-lbl' align='right'>E-Mail:</label><input class='lay2col-fld' type='text' name='email' value='".$email."' /><br />
	<label class='lay2col-lbl' align='right'>Home Phone:</label><input class='lay2col-fld' type='text' name='hphone' value='".$homephone."' /><br />
	<label class='lay2col-lbl' align='right'>Alternate Phone:</label><input class='lay2col-fld' type='text' name='aphone' value='".$altphone."' /><br />
	<label class='lay2col-lbl' align='right'>Address 1:</label><input class='lay2col-fld' type='text' name='addr1' value='".$address1."' /><br />
	<label class='lay2col-lbl' align='right'>Address 2:</label><input class='lay2col-fld' type='text' name='addr2' value='".$address2."' /><br />
	<label class='lay2col-lbl' align='right'>City:</label><input class='lay2col-fld' type='text' name='city' value='".$city."' /><br />
	<label class='lay2col-lbl' align='right'>State:</label><input class='lay2col-fld' type='text' name='state' value='".$state."' /><br />
	<label class='lay2col-lbl' align='right'>ZipCode:</label><input class='lay2col-fld' type='text' name='zip' value='".$zip."' /><br />
	<label class='lay2col-lbl' align='right'>&nbsp;</label>
	<div class='layradio'>
		<label class='layrlbl'>Color Schemes:</label>
		<input type='radio' id='radio1' name='mstyle' value='1'".$rdchk[1]."><label for='radio1'><img src='images/style1.png' width='150' height='100' alt='Style 1'></label>
		<input type='radio' id='radio2' name='mstyle' value='2'".$rdchk[2]."><label for='radio2'><img src='images/style2.png' width='150' height='100' alt='Style 2'></label><br>
		<input type='radio' id='radio3' name='mstyle' value='3'".$rdchk[3]."><label for='radio3'><img src='images/style3.png' width='150' height='100' alt='Style 3'></label>
		<input type='radio' id='radio4' name='mstyle' value='4'".$rdchk[4]."><label for='radio4'><img src='images/style4.png' width='150' height='100' alt='Style 4'></label>
		<input type='radio' id='radio5' name='mstyle' value='5'".$rdchk[5]."><label for='radio5'><img src='images/style5.png' width='150' height='100' alt='Style 5'></label>
	</div><br />
	<label class='lay2col-lbl' align='right'>&nbsp;</label><input class='lay4col-btn' type='submit' name='l' value='Save Changes'><br />
</form>";
?>