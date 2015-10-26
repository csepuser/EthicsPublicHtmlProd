<?php 
	ob_start(); 
	session_start();

	$user="csep";
	$pass="ec1976!";
	$db="nanoethicsbank";
	$dbh="myst-my-p.cns.iit.edu";
	$baseurl="../uploaded";
	$baseurl1="uploaded";
	$tbl_bank="bank";

	$link=mysql_connect($dbh,$user,$pass);
	if( !$link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");

	$edit = 0;
	$edit_keyword = 0;

	$userName = $_POST['username'];
	$password = $_POST['password'];

	echo $userName;
	echo $password;

	function checkLogin($username, $password, $link)
	{
		global $edit;
		global $edit_keyword;		
		$sql = "SELECT * FROM users WHERE " .
		"username = '$username' AND " .
		"password = '$password'";

		$pass_check = mysql_query($sql,$link) or die(mysql_error());
		$result = mysql_num_rows($pass_check);	
		if ( $result != 0)
		{
			$edit = mysql_result($pass_check,0,"edit");
			$edit_keyword = mysql_result($pass_check,0,"edit_keyword");
			return true;
		}
		else
		{
			return false;
		}
	} 
?>

<html>
<head>
<title>Nano Bank - Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="newlayout/stylesneb_1006.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="newlayout/favicon.ico" >
</head>
</head>

<body>
<div id="container">
		<div id="header">
			<img id="neb_logo" src="Nanoheader8.jpg"/>
		</div>

	<div id="top_nav_container">
		<ul>
			<li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;</li>
			<li><a href="./index.php">NanoEthicsBank</a> &gt;&gt;</li>
			<li id="nav_blank"><a>Login</a></li>
		</ul>
	
	</div>

<br>
<?php

	if (isset($_POST['Submit']))
	{
		if (false == checkLogin($_POST['username'],$_POST['password'],$link))
		{
			echo "<p align=center><font color=#FF0000 size=+1> Illegal Username or Password! Authentication failed </font> </p>";	
		}
		else
		{
			if ($edit == 1)
			{
				$_SESSION['edit'] = true;
				$_SESSION['edit_keyword'] = true;
			}
			else if ($edit_keyword == 1)
			{
				$_SESSION['edit'] = false;
				$_SESSION['edit_keyword'] = true;
			}
			else
			{
				$_SESSION['edit'] = false;
				$_SESSION['edit_keyword'] = false;
			}
			$_SESSION['login'] = true;
			$_SESSION['neb_user'] = $_POST['username'];
			header('Location: ./index.php');
		}
	}
?>

<h4><p align = "center">Please enter your username and password to add 
     <a href="http://ethics.iit.edu/index1.php/Programs/NanoEthicsBank/Selection%20&%20Indexing#tags">tags</a> 
     to records. 
     
     <!-- If you have not created a login, <a href="register.php">create one</a> -->.</p> </h4>
 
<div align="center">
<form name="form1" method="post" action="login.php">
	<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td width="100" align="right">Username:</td>
			<td><input name="username" type="text" id="username"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="100"  align="right">Password:</td>
			<td><input name="password" type="password" id="password"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td><a href="changepasswd.php">Change Password</a></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
		 	<td></td>
		  	<td><a href="forgotpasswd.php">Forgot Password ?</a>  </td>
		</tr> 
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="100">&nbsp;</td>
			<td><input type="submit" name="Submit" value="Submit"></td>
		</tr>
	</table>
</form>


<br>
<div id="footer"> 
	<?php
		// this is a commom footer file 
		include("Footer.php");
	?>
</div>
</div>
</body>
</html>