<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css"/>
</head>
<body>
<h1>Attendance <br ><span >Managment</span><br > System</h1>
<img id="logo"src ="logo.png" >
<div id = "stud">
<img id="st_image"src ="stud.png" >
<p>Student Login</p>
</div>
<div id = "teach">
<img id="te_image"src ="teach.png" >
<p>Teacher Login</p>
</div>
<header>
<div id="name">Attendance Managment System</div>
<div>
<p>Admin Login</p>
<img id="ad_image"src ="admin.png" >
</div>
</header>
<form name = "contactform" action="" method = "post" id="orderform"">
	<fieldset>
		<label for="name">Username</label>
			<input name ="fname" type="text" placeholder="Enter Your Full Name"/><p id="test"></p><br>
		<label for="password">Password</label>
			<input name="fpassword" type="password" placeholder="Enter Your Password" /><p id="ptest"></p><br>
		<input id="submit" name = "Submit" type="submit" value="Log IN"/>
		<img id="log_image"src ="log.png" >
	</fieldset>		
</form>
<?php

ob_start();
session_start();
$dbServer='localhost';
$dbUser='root';
$dbPass='01031988'; //MySQL password.
$dbName='dbteacher';
$link = mysql_connect("$dbServer", "$dbUser", "$dbPass") or die("Could not connect to MySQL");
//print "<h1>Connected to MySQL successfully</h1>";
mysql_select_db("$dbName") or die("Could not Select Database");
//print "<h2>Database selected successfully</h2>";
if (isset($_POST["Submit"]))
	{	
		// Defining $myusername and $mypassword 
		$myusername=$_POST['fname']; 
		$mypassword=$_POST['fpassword']; 

// To protect MySQL injection
		$myusername = stripslashes($myusername);
		$mypassword = stripslashes($mypassword);
		$myusername = mysql_real_escape_string($myusername);
		$mypassword = mysql_real_escape_string($mypassword);
		$pass = md5($mypassword);
		$sql="SELECT * FROM  teacherlogin WHERE username='$myusername' AND password = '$pass'";
		$attend3 = mysql_query($sql,$link) or die("Could not Select DATA from the Table");
		$raw = mysql_fetch_array($attend3);
		if (!$raw)
		{
			echo '<p id = "err">User Not Valid</p>';	
		}
		else
		{
			$sql = "SELECT class FROM teacherinfo WHERE tid = {$raw['tid']}";
		$attend3 = mysql_query($sql,$link) or die("<h2>Could not Select DATA from the Table</h2>");
		//print "<h2>table selected successfully</h2>";
		$raw = mysql_fetch_array($attend3);
			if (!$raw)
			{
				echo '<p id = "err">Not database Is associated with this id now</p>';	
			}
			else
			{
				$_SESSION['name']=$myusername;
				$_SESSION['pass']=$mypassword;
				$_SESSION['login']=true;
				$_SESSION['window_forward']=true;
				$_SESSION['class']=$raw['class'];
				header("location:page1.php");
			}
		}
	}
else
	{
	}

ob_end_flush();
?>
	<footer>
		<p id="fp1">C2013 All Right Reserved</p>
		<p id="fp2">This site is created in HTML5 CSS3 JavaScript Jquery and designed by Rachit Bhardwaj</p>
		</footer>
</body>
</html>