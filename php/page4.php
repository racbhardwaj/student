<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="page4.css"/>
<script>
</script>
</head>
<body>
<header>
<div id="name">Attendance Managment System</div>
</header>
<form id='select' method = 'post' action = ''name="select">
<select name="attendance" >
<option value="">Select Option For Sorting:</option>
<option value="">All</option>
<option value="present">Present</option>
<option value="absent">Absent</option>
<option value="onleave">Onleave</option>
</select>
<input id="submit" type ="submit" name = "Submit" Value = "SUBMIT" />
<input id = "reset" type ="reset" name = "Reset" Value = "RESET" onCLick="window.location.reload()" />
<input id ="logout" type = "submit" name = "logout" value = "logout"/>
<?php
session_start();
$dbServer='localhost';
$dbUser='root';
$dbPass='01031988'; //Enter MySQL password.
$dbName='class_'.$_SESSION['class'];
$link = mysql_connect("$dbServer", "$dbUser", "$dbPass") or die("Could not connect to MySQL");
//print "<h1>Connected to MySQL successfully</h1>";
mysql_select_db("$dbName") or die("Could not Select Database");
//print "<h2>Database selected successfully</h2>";
$select_date = "SELECT DISTINCT att_date FROM attendance"; 
$attend2 = mysql_query($select_date,$link) or die("Could not Select DATA from the Table");
echo "<select name = 'date'>";
echo " <option value=''>Select Date</option>";
while ($rawdate = mysql_fetch_array($attend2))
	{	
		echo "  <option value='{$rawdate['att_date']}'>{$rawdate['att_date']}</option>";
	}
echo "</select>";
if ($_SESSION['login']==true)
{	$x=0;
if (isset($_POST["Submit"]))
	{	
	 $q=$_POST["attendance"];
	$y=$_POST["date"];
	$select_att = "SELECT * FROM attendance  WHERE att_date = '$y' "; 
	$attend3 = mysql_query($select_att,$link) or die("Could not Select DATA from the Table");
echo "<form id = action='' method='post'>";
echo "<fieldset>";
echo "<table border='1'>";
echo "	<tr>";
echo "		<th rowspan='2'>Student Name</th>";
echo "		<th  rowspan='2'>Student Id</th>";
echo "		<th colspan = '3'>Attendance</th>";
echo "		<th  rowspan='2'>Details</th>";
echo "	</tr>";
echo "	<tr>";
echo "		<th>Present</th>";
echo "		<th>Absent</th>";
echo "		<th>On Leave</th>";
echo "	</tr>";
$x = 0;

print (Date("l F d, Y"))."<br >";
while ($raw = mysql_fetch_array($attend3))
	{	
		if ($raw[$q]==true)
		{
		echo "<tr>";
		echo "<td>{$raw['student_name']}</td>";
		echo "<td>{$raw['student_id']}</td>";
		echo "<td>{$raw['present']}</td>";
		echo "<td>{$raw['absent']}</td>";
		echo "<td>{$raw['onleave']}</td>";
		echo "<td><a href = '#'>Details</a></td>";
		echo "</tr>";
		}
		else if ($q =="")
		{
		echo "<tr>";
		echo "<td>{$raw['student_name']}</td>";
		echo "<td>{$raw['student_id']}</td>";
		echo "<td>{$raw['present']}</td>";
		echo "<td>{$raw['absent']}</td>";
		echo "<td>{$raw['onleave']}</td>";
		echo "<td><a href = '#'>Details</a></td>";
		echo "</tr>";
			

		}
		else
		{
		}
	}
echo "</table>";
echo "</fieldset>";
echo "</form>";
$_SESSION['window_forward']=false;
	}
else if (isset($_POST["logout"]))
	{
		session_destroy();
		header("location:index.php");
	}
else
	{
	}

}
else
{
echo"<br >Please Login See Your Account<br >";
}
mysql_close($link);
?>

</form>
<script>
document.getElementByTagName("TD")[0] = {$raw['student_id']};
</script>
<footer>
		<p id="fp1">C2013 All Right Reserved</p>
		<p id="fp2">This site is created in HTML5 CSS3 JavaScript Jquery and designed by Rachit Bhardwaj</p>
		</footer>
</body>
</html>