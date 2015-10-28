<?php
	$myWeather = new yahoo_weather;
	if (isset($_POST['l']) and $_POST['l'] == "Submit") {
		$woeid_results = $myWeather->get_woeid($_POST['newLocation']);
		if (!$woeid_results or count($woeid_results) == 1) {
			if (!$woeid_results) {
				echo "<b><i>No Results For: ".$_POST['newLocation']."</i></b><hr>";
			} else {
				$myWeather->get_weather($woeid_results[0][3]);
			}
			$showme = True;
		} else {
			$showme = False;
		}
	} elseif (isset($_POST['k']) and $_POST['k'] == "Submit") {
		$myWeather->get_weather($_POST['location']);
		$showme = True;
	} else {
		if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful") {
			if (isset($_REQUEST['save'])) {
				$_SESSION['logged']->uwoeid = $_REQUEST['save'];
				$userDB = new mSQL;
				$result = $userDB->updateQ("users","username = '".$_SESSION['logged']->user."'",array("user_woeid"),array($_REQUEST['save']));
			}
			if (!is_null($_SESSION['logged']->uwoeid)) {
				$myWeather->get_weather($_SESSION['logged']->uwoeid);
			} else {
				$myWeather->get_weather($myWeather->default_woeid);
			}
		} else {
			$myWeather->get_weather($myWeather->default_woeid);
		}
		$showme = True;
	}
	if ($showme) {
		echo "
	<h1>".$myWeather->title."</h2>
	<div id='weather'>".$myWeather->weather_data."</div>
	<form name='new_location' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."'>
	<label><b>Change Location</b> <i>Enter City and State or Zip Code</i></label><br>
	<input type='text' name='newLocation' size='50'><input type='submit' name='l' value='Submit'>
	</form>";
		if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful" and $myWeather->woeid <> $_SESSION['logged']->uwoeid) {
			echo "
	<span><a href='index.php?p=".$_SESSION['myContent']->pIdx."&save=".$myWeather->woeid."'>Click Here To Save Current Location as Your Default Location</a></span>";
		}
	} else {
		echo "
<form name='multi_results' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."'>
	<label><b>There were multiple results to your request. Please choose one.</b></label><br />
	<select name='location' size='15' style='width: 250px;'>";
	foreach ($woeid_results as $results) {
		echo "
    	<option value='".$results[3]."'>".$results[0].", ".$results[1].", ".$results[2]."</option>";
	}
	echo "
    </select>
    <input type='submit' name='k' value='Submit' />
</form>";
	}
?>