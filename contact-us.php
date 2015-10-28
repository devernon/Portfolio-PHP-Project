<?php
	if (isset($_POST['l']) and $_POST['l'] == "Send") {
		$toemail = "david@dvernon.com";
		$subj = "Email Form From Website: ".$_POST['subject'];
		$body = $_POST['message']."\r\rMessage Sent From:\rName: ".$_POST['name']."\rEmail: ".$_POST['email']."\rRE: ".$_POST['subject'];
		if (check_email($_POST['email'])) {
			mail($toemail,$subj,$body,"From: no_reply@dvernon.com");
			echo "
	<h3>The following E-Mail was sent successfully.</h3>
	<label class='lay4col-lbl' align='right'>Your Name:</label><span class='lay2col-fld'>".$_POST['name']."</span><br class='clr' />
	<label class='lay4col-lbl' align='right'>Your E-Mail:</label><span class='lay2col-fld'>".$_POST['email']."</span><br class='clr' />
	<label class='lay4col-lbl' align='right'>Subject:</label><span class='lay2col-fld'>".$_POST['subject']."</span><br class='clr' /><br class='clr' />
	<label class='lay4col-lbl' align='right'>Message:</label><span class='lay2col-fld'>".$_POST['message']."</span><br class='clr' />";
		} else {
			echo "
	<h3>The Email Address You Entered Is Invalid.</h3>";
		}
	} else {
?>
	<div>
    You may email me directly at: <a href='mailto:david@dvernon.com'>david@dvernon.com</a><br>
    or you may use the form below.
    </div>
    <hr />
	<form name='guestbook' method='post' action='index.php?p=<?php echo $_SESSION['myContent']->pIdx; ?>'>
		<label class='lay4col-lbl' align='right'>Your Name:</label><input class='lay2col-fld' type='text' name='name'><br class='clr' />
		<label class='lay4col-lbl' align='right'>Your E-Mail:</label><input class='lay2col-fld' type='text' name='email'><br class='clr' />
		<label class='lay4col-lbl' align='right'>Subject:</label>
    		<select class='lay2col-fld' name='subject'>
            	<option selected>Questions Regarding Site Development</option>
                <option>Questions Regarding Application Development</option>
                <option>Request Resume or Code Samples</option>
                <option>Available Employement Opportunities You May Have</option>
                <option>Other Reason Not Listed Above</option>
            </select><br class='clr' />
		<label class='lay4col-lbl' align='right'>Message:</label><textarea class='lay2col-txt' name='message' cols='70'></textarea><br class='clr' />
		<label class='lay4col-lbl' align='right'>&nbsp;</label><input class='lay4col-btn' type='submit' name='l' value='Send'><br class='clr' />
	</form>
<?php
	}
?>