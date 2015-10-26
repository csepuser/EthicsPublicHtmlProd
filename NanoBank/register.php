 
<?php
	
	error_reporting(0); 
    session_start();
	// database connect script.
	include("db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");
?>

<html>
<head>
	<title>CSEP - Nano Ethics Bank </title>
    <link rel="stylesheet" type="text/css" href="stylesneb_1006.css" />
    <link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />	
</head>

<body>
<div id="container">
<div id="header"> <img id="neb_logo" src="Nanoheader8.jpg"/></div>
<div id="top_nav_container"> 
    <ul>
    	<li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;&nbsp;</li>
    	<li><a href="http://ethics.iit.edu/NanoEthicsBank/index.php">NanoEthicsBank</a>&gt;&gt;&nbsp;</li>
    	<li>New User</li>
	</ul>
</div>

<br>

<?php
// if form has been submitted
if (isset($_POST['submit']))
{
	/* check they filled in what they supposed to, 
	passwords matched, username
	isn't already taken, etc. */

	if (!$_POST['uname'] | !$_POST['passwd'] | !$_POST['passwd_again'] | !$_POST['email'] | !$_POST['name'] | !$_POST['institution'] ){
		die('You did not fill in a required field. Please click back and fill the missing information');
	}

	// check if username exists in database.
	if (!get_magic_quotes_gpc()) {
		$_POST['uname'] = addslashes($_POST['uname']);
	}


	$query = "SELECT username FROM users WHERE username = '".$_POST['uname']."'";
	$name_check = mysql_query($query,$link) or die(mysql_error());

	$name_checkk = mysql_num_rows($name_check);

	if ($name_checkk != 0) {
		die('Sorry, the username: <strong>'.$_POST['uname'].'</strong> is already taken, please pick another one.');
	}

	// check passwords match

	if ($_POST['passwd'] != $_POST['passwd_again']) {
		die('Passwords did not match.');
	}

	// check e-mail format

	if (!preg_match("/.*@.*..*/", $_POST['email']) | preg_match("/(<|>)/", $_POST['email'])) {
		die('Invalid e-mail address.');
	}

	// no HTML tags in username, website, location, password

	$_POST['uname'] = strip_tags($_POST['uname']);
	$_POST['passwd'] = strip_tags($_POST['passwd']);
	$_POST['website'] = strip_tags($_POST['website']);
	$_POST['location'] = strip_tags($_POST['location']);
	$_POST['name'] = strip_tags($_POST['name']);
	$_POST['institution'] = strip_tags($_POST['institution']);
	$_POST['purpose'] = strip_tags($_POST['purpose']);

	// check show_email data
	if ($_POST['show_email'] != 0 & $_POST['show_email'] != 1) {
		die('Nope');
	}

	/* the rest of the information is optional, the only thing we need to 
	check is if they submitted a website, 
	and if so, check the format is ok. */
//	if ($_POST['website'] != '' & !preg_match("/^(http|ftp):///", $_POST['website'])) {
//		$_POST['website'] = 'http://'.$_POST['website'];
//	}

	// now we can add them to the database.
	// encrypt password

	//$_POST['passwd'] = md5($_POST['passwd']);

	if (!get_magic_quotes_gpc()) {
		$_POST['passwd'] = addslashes($_POST['passwd']);
		$_POST['email'] = addslashes($_POST['email']);
		$_POST['website'] = addslashes($_POST['website']);
		$_POST['location'] = addslashes($_POST['location']);
	}

	$regdate = date('m d, Y');

	$insert = "INSERT INTO users (
			username, 
			password, 
			regdate, 
			email, 
			location, 
			last_login,
			edit,
			edit_keyword,
		    name,
			institution,
			purpose) 
			VALUES (
			'".$_POST['uname']."', 
			'".$_POST['passwd']."', 
			'$regdate', 
			'".$_POST['email']."', 
			'".$_POST['location']."', 
			'Never',
			'0',
			'1',
			'".$_POST['name']."',
			'".$_POST['institution']."',
			'".$_POST['purpose']."' )";
	$add_member = mysql_query($insert);
?>

<h1>Registered</h1>
<p>Thank you, your information has been added to our database, you may now <a href="login.php" title="Login">log in</a>.</p>

<?php
	} else {	// if form hasn't been submitted
?>

<div align="center">
<h1>Register User</h1>
<br/>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<table align="center" border="1" cellspacing="0" cellpadding="3">
	<tr><td>Username*:</td><td>
	<input type="text" name="uname" maxlength="40"  >
	</td></tr>
	<tr><td>Password*:</td><td>
	<input type="password" name="passwd" maxlength="50"  >
	</td></tr>
	<tr><td>Confirm Password*:</td><td>
	<input type="password" name="passwd_again" maxlength="50"  >
	</td></tr>
	<tr><td>E-Mail*:</td><td>
	<input type="text" name="email" maxlength="100"  >
	</td></tr>
	<tr><td>Location:</td><td>
	<input type="text" name="location" maxlength="150"  >
	</td></tr>
	<tr><td>Name*:</td><td>
	<input type="text" name="name" maxlength="150"  >
	</td></tr>
	<tr><td>Institution*:</td><td>
	<input type="text" name="institution" maxlength="150"  >
	</td></tr>
	<tr><td>Purpose</td>
      <td> 
        <input type="text" name="purpose" maxlength="150"  >
	</td></tr>
	<tr><td colspan="2" align="right">
	<input type="submit" name="submit" value="Sign Up">
	</td></tr>
</table>
</form>
</div>

<?php

}

?>
<br>
<div id="footer"> 
	<ul>
    	<li><a href="http://ethics.iit.edu/search.php">Search CSEP</a></li>		
    	<li><a href="http://ethics.iit.edu/sitemap.html">Site Map</a></li>		
    	<li><a href="http://ethics.iit.edu/contactus.html">Contact CSEP</a></li>
	</ul>
</div>

</div>
</body>
</html>