<?php 
	ob_start();
    session_start();

    // database connect script.
	include("db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");
    	
	function checkUser($username,$password,$link)
	{
	     //$password = md5($password);
		 $sql = "SELECT * FROM users WHERE " .
		 "username = '$username' AND " .
		 "password = '$password'";

		$pass_check = mysql_query($sql,$link) or die(mysql_error());
		$result = mysql_num_rows($pass_check);
	
		if ( $result != 0)
		{			 
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
<title>CSEP - Nano Ethics Bank </title>
    <link rel="stylesheet" type="text/css" href="stylesneb_1006.css" />
    <link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" src="AutoSuggest.js" ></script>
	<link rel="stylesheet" href="autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />	
</head>

<body>
<div id="container">
<div id="header"> <img id="neb_logo" src="Nanoheader8.jpg"/></div>
	<div id="top_nav_container"> 
		<ul>
			<li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;&nbsp;</li>
			<li><a href="http://ethics.iit.edu/NanoEthicsBank/index.php">NanoEthicsBank</a>&gt;&gt;&nbsp;</li>
			<li>Change Password</li>
		</ul>
	</div>
<br>

<?php
 // if the form is submitted
 if(isset($_POST['Submit']))
 {
    /* check if all the fields are filled or not */
	if (!$_POST['username'] | !$_POST['password_old'] | !$_POST['password'] | !$_POST['password_again'] ){
		die('Please fill the required information.');
	}
	/* check the username that has been entered exist in database or not*/
	if(false== checkUser($_POST['username'],$_POST['password_old'],$link)){
       echo 'invalid username or password';
	}
	else{
	    if ($_POST['password'] != $_POST['password_again']) {
		   die('Passwords did not match.');
		}
		$password= $_POST['password'];
		$username= $_POST['username'];
		$query  = "UPDATE users SET password='$password' WHERE username='$username'";
		$result = mysql_query($query);		
	   echo '<h4>Your password has been changed. <a href="login.php">Click here</a> to log-in</h4>';
	  }	  	
 }
?>
 
<br>
<br>

<div align="center">
<h3>Enter the required Information to change your Password.</h3
<br/>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"">
	<table width="400" border="0" cellspacing="0" cellpadding="3">
		
		<tr>
        <td width="200" align="right">Username (*):</td>
		  <td><input name="username" type="text" id="username"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>		
		<tr>
		    <td width="200" align="right">Old Password (*):</td>
			<td><input name="password_old" type="password" id="password_old"></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
        	<td width="200"  align="right">New Password (*):</td>
			<td><input name="password" type="password" id="password"></td>			 
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>		
		<tr>
       		<td width="200" align="right">Confirm Password (*):</td>
		 	<td><input name="password_again" type="password" id="password_again"></td>
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
</div>

<br/> 
<br/>

	<div id="footer"> 
		<?php
			// this is a commom footer file 
			include("Footer.php");
		?>
	</div>
</div>
</body>
</html>