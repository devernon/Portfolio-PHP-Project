<div id='portfolio'>
  <table width='720' border='0' cellspacing='0' cellpadding='2'>
    <tr>
      <td colspan='2'><b>Listed are a sample of the websites that I have created through the years. All the sites are hosted locally on my server to show the actual site I created. Some of the actual sites are no longer active or the clients have changed their sites from my original.</b></td>
    </tr>
<?php
	$myDB = new mSQL;
	$res = $myDB->selectQ("portfolio","*","","ID ASC");
	if ($res) {
		foreach ($res as $row) {
			echo "
    <tr>
      <td colspan='2'><hr></td>
    </tr>
    <tr>
      <td width='10%'>";
	  		if ($row["link"] != "#")
			{
				echo "<a href='".$row["link"]."' target='_blank'><img width='300' height='207' src='images/".$row["image"]."'></a>";
			} else {
				echo "<img width='300' height='207' src='images/".$row["image"]."'>";
			}
			echo "</td>
      <td width='90%'><b>".$row["title"]."</b><br>".$row["description"]."</td>
    </tr>";
		}
	}
?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>

</div>