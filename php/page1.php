<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="page1.css"/>
</head>
<body>
<header>
<a id='p4' href="page4.php" />Show Details</a>
<div id="name">Attendance Managment System</div>
</header>
<?php
session_start();
if ($_SESSION['login']==true)
{
$dbServer='localhost';
$dbUser='root';
$dbPass='01031988'; //MySQL password.
echo "<p id='class'>Class {$_SESSION['class']}</p>";
$dbName='class_'.$_SESSION['class'];
$link = mysql_connect("$dbServer", "$dbUser", "$dbPass") or die("Could not connect to MySQL");
//print "<h1>Connected to MySQL successfully</h1>";
		mysql_select_db("$dbName") or die("Could not Select Database");
//print "<h2>Database selected successfully</h2>";
$select_att = 'SELECT DISTINCT student_id, student_name FROM attendance ORDER BY student_name ASC'; 
$attend3 = mysql_query($select_att,$link) or die("Could not Select DATA from the Table");
//echo "DATA selected Successfully<br >";
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
$total_student = 0;
echo"<p id = 'date'>Today's Date".(Date(" Y-m-d"))."</p><br >";
$cur_date = Date(" Y-m-d");
while ($raw = mysql_fetch_array($attend3))
	{
		
		echo "<tr>";
		echo "<td>{$raw['student_name']}</td>";
		echo "<td>{$raw['student_id']}</td>";
		echo "<td><input value = 'rpresent' type = 'radio' name='att[$total_student]'/></td>";
		echo "<td><input value = 'rabsent' type = 'radio' name='att[$total_student]'/></td>";
		echo "<td><input value = 'rleave' type = 'radio'name='att[$total_student]'/></td>";
		echo "<td><a href = '#'>Details</a></td>";
		echo "</tr>";
		$total_student++;
	}
echo "</table>";
echo "<input id='submit' type='submit' name='Submit' value = 'Save'/>";
echo "<input id='logout' type = 'submit' name = 'logout' value = 'logout'/>";
echo "</fieldset>";
echo "</form>";
$filled  = 0;
if (isset($_POST["Submit"]))
	{	
		if($_SESSION['window_forward']==true)
		{
	echo "<div class='err'>";
	for ($input_att = 0; $input_att < $total_student; $input_att++)
		{
			if (!isset($_POST['att'][$input_att]))
			{
				echo "<p>Take attendance for Student ID : 2013000".$input_att."</p>";
					
				echo ($_POST['att'][$input_att]);
				
			}
			else
			{
				switch($_POST['att'][$input_att]) 
				{
					case "rpresent":
						 $value1[$input_att] = 1;
						$value2[$input_att] = 0;
						$value3[$input_att] = 0;
						break;
					case "rabsent":
						$value1[$input_att] = 0;
						$value2[$input_att] = 1;
						$value3[$input_att] = 0;
						break;
					case "rleave":
						 $value1[$input_att] = 0;
						$value2[$input_att]= 0;
						$value3[$input_att]= 1;
						break;
					default:
						$value = "No radio button has been selected<br >";
						
				}
				$filled++;
			}
		}
		
		$select_att = 'SELECT DISTINCT student_id, student_name FROM attendance ORDER BY student_name ASC';
		$attend3 = mysql_query($select_att,$link) or die("Could not Select DATA from the Table");
		$i =0;
		if ($filled ==$total_student)
		{
		while ($raw = mysql_fetch_array($attend3))
				{	
					
				$att_date = $cur_date;
				$student_id = $raw['student_id'];
				$student_name =	$raw['student_name'];
				$present = $value1[$i];
				$absent = $value2[$i];
				$leave =  $value3[$i];
				$email = "rac.don007@gmail.com";
				$ins_att= "INSERT INTO attendance ".
						"(att_date, student_id, student_name, present, absent, onleave, student_email)".
						"VALUES".
					 "('$att_date','$student_id','$student_name','$present','$absent','$leave','$email')";
				$attend2 = mysql_query($ins_att,$link) or die("<p>Could not Insert DATA into the Table Check is it already exist</p>");
					$i++;
					if ($absent == true)
					{
							$to = "racbhardwaj@gmail.com";
							$from = "rac.don007@gmail.com";
							$subject = "Test mail";
							$message = "Hello! {$raw['student_name']} is absent today ".$cur_date;
							$headers = "From:" . $from;
							mail($to,$subject,$message,$headers) or die("Could not Send");
							echo "Mail Sent.";
					}
				}
			echo "<p>Attendance is Inserted Successfully</p><br >";
		}
		else
		{
		echo "<p>Please take all the attendence</p><br >";
		}
		}
		else if($_SESSION['window_forward']==false)
		{ 
			echo "<p>attendence is already taken</p><br >";
		}
		else
		{ 
		}
	}
else if (isset($_POST["logout"]))
	{
		session_destroy();
		header("location:index.php");
	}
else
{

}
mysql_close($link);
}
else
{
echo"<br >Please Login See Your Account<br >";
}
?>

<footer>
		<p id="fp1">C2013 All Right Reserved</p>
		<p id="fp2">This site is created in HTML5 CSS3 JavaScript Jquery and designed by Rachit Bhardwaj</p>
		</footer>
</body>
</html>