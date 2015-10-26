<?php
	ob_start();
	session_start();

	include("db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");
	
	function checkUsername($username,$link)
	{ 
		$sql = "SELECT * FROM users WHERE " .
		"username = '$username' "; 

		$user_check = mysql_query($sql,$link) or die(mysql_error());
		$result = mysql_num_rows($user_check);
	
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
				<li>Forgot Password</li>
		  </ul>
		</div>	

    	<br>

		<div align="center">
				<?php
					if (isset($_POST['submit'])) { // Handle the form.
					
					if (empty($_POST['email'])) { // Validate the username.
					$email = FALSE;
					echo '<p><font color="red" size="+1">You forgot to enter your email address!</font></p>';
					} else {
					$email = mysql_real_escape_string($_POST['email']);
					
					// Check for the existence of that email.
					$query = "SELECT id, email FROM users WHERE email='$email'";
					$result = mysql_query ($query);
					$row = mysql_fetch_array ($result, MYSQL_NUM);
					if ($row) {
					$id = $row[0];
					$email = $row[1];
					} else {
					echo '<p><font color="red" size="+1">The submitted email is not in our database!</font></p>';
					$email = FALSE;
					}
					
					}
					
					if ($email) { // If everything's OK.
					
					// Create a new, random password.
					$passwd = substr ( md5(uniqid(rand(),1)), 3, 10);
					
					// Make the query.
					$query = "UPDATE users SET password='$passwd' WHERE id='$id'"; 
					$result = mysql_query ($query); // Run the query.
					if (mysql_affected_rows() == 1) { // If it ran OK.
					
					// Send an email.
					$body = "Your password to log into NanoEthics Bank has been temporarily changed to '$passwd'. Please log-in using this password and your username. At that time you may change your password to something more familiar.";
					mail ($email, 'Your temporary password.', $body, 'From: csep@iit.edu');
					echo '<h5>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Please click on <a href="changepasswd.php">change password</a> once you recieve your temporary password. </h5>';
					exit();
					
					} else { // If it did not run OK.
					
					// Send a message to the error log, if desired.
					$message = '<p><font color="red" size="+1">Your password could not be changed due to a system error. We apologize for any inconvenience.</font></p>';
					
					}
					mysql_close(); // Close the database connection.
					
					} else { // Failed the validation test.
					echo '<p><font color="red" size="+1">Please try again.</font></p>';
					}
					
					} // End of the main Submit conditional.
			?>
			</div>

			<div align="center">
				<h1>Reset Your Password</h1>
				<h4><p>Enter your email below and your password will be reset.</p><h4>
				<form action="forgotpasswd.php" method="post">
				<fieldset>
				<p><b>Email Address:</b> <input type="text" name="email" size="30" maxlength="30" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>" /></p>
				</fieldset>
				<div align="center"><input type="submit" name="submit" value="Reset My Password" /></div>
				</form><!-- End of Form --> 
			</div>

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