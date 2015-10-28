<div id='map_container'>
	<ul>
<?php
	$indexitems = $_SESSION['myContent']->load_index();
	foreach ($indexitems as $item) {
    	if ($item[1] == "Y") {
			if ($items[2] == "Y") {
				if (isset($_SESSION["logged"]) && $_SESSION["logged"]->raccess == "Y") {
					$cmnts = "";
				} else {
					$cmnts = "&nbsp;&nbsp;<i>(Restricted availability to approved registered Users)</i>";
				}
			} else {
				if (isset($_SESSION["logged"]) && $_SESSION['logged']->authentication == "Successful") {
					$cmnts = "";
				} else {
		        	$cmnts = "&nbsp;&nbsp;<i>(Only available to Registered Users)</i>";
				}
			}
        } else {
        	$cmnts = "";
        }
    	if ($item[3] == -1) {
        	echo "
        <li>".$item[0].$cmnts."</li>";
        } else {
			echo "
		<li><a href='index.php?p=".$item[3]."'>".$item[0]."</a>".$cmnts."</li>";
       	}
	}
?>
	</ul>
</div>