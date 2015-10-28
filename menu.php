            <ul>
<?php
	for ($x = 0; $x < count($_SESSION['myContent']->mnuTitle); $x++) {
		echo "
                <li><a ";
		if ($x == $_SESSION['myContent']->pIdx)
		{
			echo "class='selected'";
		}
		echo "href='index.php?p=".$x."'>".$_SESSION['myContent']->mnuTitle[$x]."</a></li>";
	}
	if (isset($_SESSION['logged']) and $_SESSION['logged']->authentication == "Successful") {
		echo "
				<li><a href='index.php?p=logout'>Sign Out</a></li>";
	} else {
		echo "
				<li><a ";
		if ($_SESSION['myContent']->pIdx == 999)
		{
			echo "class='selected'";
		}
		echo "href='index.php?p=login'>Sign In</a></li>";
	}
?>
            </ul>