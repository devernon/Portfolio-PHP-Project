<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>David Vernon PHP Test</title>
</head>
<?php
class dataTable{
	private $data = array(
		array('name'=>'Blaine Jones','state'=>'AZ','company'=>'Media Solutions',
			'phone'=>array(
				'cell'=>'4805550001',
				'office'=>'4806391200'
			),
			'email'=>array(
				'primary'=>'bjones@mediasolutionscorp.com',
				'me@there.com'
			)
		),
		array('name'=>'Joe Smith','city'=>'Phoenix','phone'=>'4805551111','email'=>'jsmith@some_email.com'),
		array('name'=>'John Doe','city'=>'Chandler','company'=>'Doe Co.','email'=>array('jdoe@gmail.com','personal'=>'email@email.com'),'phone'=>'6025550002')
	);
	public function table()
	{
		return $this->data;	
	}
}
?>
<body>

<table border="1" cellspacing="0" cellpadding="5">

<tr>
<th>NAME</th>
<th>COMPANY</th>
<th>CITY</th>
<th>STATE</th>
<th>EMAIL</th>
<th>PHONE</th>
</tr>
<?php
	$data = new dataTable;
	$myData = $data->table();
	function prntData($a)
	{
		if(is_array($a))
		{
			foreach($a as $key=>$value)
			{
				if(is_string($key))
				{
					echo "<strong>$key: </strong>";
				}
				if (is_numeric($value))
				{
					echo "(" . substr($value,0,3) . ") " . substr($value,3,3) . "-" . substr($value,5,4);
				}
				else
				{
					echo $value;
				}
				if (next($a)==true)
				{
					echo "<br/>";
				}
			}
		}
		else
		{
			if(isset($a))
			{ 
				if (is_numeric($a))
				{
					echo "(" . substr($a,0,3) . ") " . substr($a,3,3) . "-" . substr($a,5,4);
				}
				else
				{
					echo $a;
				}
			}
			else
			{
				echo "&nbsp;";
			}
		}
	}
	for ($x=0; $x < count($myData); $x++)
	{
		echo "<tr>
<td valign='top' class='name'>";
		prntData($myData[$x][name]);
		echo "</td>
<td valign='top' class='company'>";
		prntData($myData[$x][company]);
		echo "</td>
<td valign='top' class='city'>";
		prntData($myData[$x][city]);
		echo "</td>
<td valign='top' class='state'>";
		prntData($myData[$x][state]);
		echo "</td>
<td valign='top' class='email'>";
		prntData($myData[$x][email]);
		echo "</td>
<td valign='top' class='phone'>";
		prntData($myData[$x][phone]);
		echo "</td>
</tr>";
	}
?>

</table>
</body>
</html>