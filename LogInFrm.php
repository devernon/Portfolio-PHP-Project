<?php
	if ($_SESSION['logged']->authentication == "LogIn" or $_SESSION['logged']->authentication == "Failed") {
		if ($_SESSION['logged']->authentication == "Failed") {
			echo "
		<h1>".$_SESSION['logged']->failedMSG."</h1>";
		}
		echo "
		<form name='login' method='post' action='index.php?p=login'>
            <span class='lay4col-lbl'>&nbsp;</span><label class='lay4col-lbl' align='right'>".$_SESSION['logged']->usertxt.":</label><input class='lay4col-fld' type='text' name='user' /><br class='clr' />
            <span class='lay4col-lbl'>&nbsp;</span><label class='lay4col-lbl' align='right'>".$_SESSION['logged']->passtxt.":</label><input class='lay4col-fld' type='password' name='pword' /><br class='clr' />
            <span class='lay4col-lbl'>&nbsp;</span><span class='lay4col-lbl'>&nbsp;</span><input class='lay4col-btn' type='submit' name='l' value='".$_SESSION['logged']->btntxt."' /><input class='lay4col-btn' type='submit' name='l' value='".$_SESSION['logged']->newtxt."' /><br class='clr' />
         </form>";
	} elseif ($_SESSION['logged']->authentication == "Register") {
		if (isset($_SESSION['registrywarning'])) {
			echo "
		<h1>".$_SESSION['registrywarning']."</h1>";
			unset($_SESSION['registrywarning']);
		}
		echo "
		<form name='register' method='post' action='index.php?p=login'>
            <label class='lay2col-lbl' align='right'>Full Name</label><input class='lay4col-fld' type='text' name='fname' value='".$_SESSION['logged']->uname."' /><br class='clr' />
			<label class='lay2col-lbl' align='right'>".$_SESSION['logged']->usertxt.":</label><input class='lay4col-fld' type='text' name='user' value='".$_SESSION['logged']->user."' /><br class='clr' />
            <label class='lay2col-lbl' align='right'>".$_SESSION['logged']->passtxt.":</label><input class='lay4col-fld' type='password' name='pword1' /><br class='clr' />
			<label class='lay2col-lbl' align='right'>Confirm ".$_SESSION['logged']->passtxt.":</label><input class='lay4col-fld' type='password' name='pword2' /><br class='clr' />
            <span class='lay2col-lbl'>&nbsp;</span><input class='lay4col-btn' type='submit' name='s' value='Register' /><input class='lay4col-btn' type='submit' name='s' value='Cancel' /><br class='clr' />
         </form>";
	} elseif ($_SESSION['logged']->authentication == "Successful") {
		echo "<h1 align='center'>".$_SESSION['logged']->successfulMSG."</h1>";
	} else {
?>
<h1>Page Error</h1>
<?php
	}
?>