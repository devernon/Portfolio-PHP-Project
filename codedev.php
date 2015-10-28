<?php
	if (isset($_REQUEST['spage'])) {
		$page = $_REQUEST['spage'];
	} else {
		$page = "index.php";
	}
	echo "
<form id='codesam' name='codeform' method='post' action='index.php?p=".$_SESSION['myContent']->pIdx."'>
  <label for='select'>Select Page:</label>
  <select name='spage' id='select'>";
	$myDB = new mSQL;
	$res = $myDB->selectQ("codesamples","*","","ID ASC");
	if ($res) {
		foreach ($res as $row) {
			echo "
    <option>".$row["page"]."</option>";
			if ($page == $row["page"]) {
				$pdf = $row["pdf"];
			}
		}
	}
	echo "
  </select>
  <input type='submit' value='View'>
</form>
<h3>".$page."</h3>
<embed type='application/pdf' src='pdf/".$pdf."' width='720' height='500'>";
?>