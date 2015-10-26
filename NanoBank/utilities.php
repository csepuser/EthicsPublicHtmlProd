<?php ob_start(); ?>
<?php
	session_start();

	include("./db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");

	$edit = 0;
	$edit_keyword = 0;

	function checkLogin($username, $password, $link)
	{
		global $edit;
		global $edit_keyword;
		
		$password = md5($password);
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
<title>Nano Bank - Help</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="newlayout/styles.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="newlayout/favicon.ico" >
</head>
</head>

<body>

<?php
	//include("newlayout/header_wrapper.php");
?>

<div id="scroll"></div>
<!--
<div id="logo"> 
	<h1>C<SPAN STYLE="color: #800000">S</span><br>
	<SPAN STYLE="color: #800000">E</span>P</h1>
</div>
<div id="topnavcontainer"> 

	<div id="banner"> 
		<h1><SPAN STYLE="color: #800000">Center</span> for the <SPAN STYLE="color: #800000">Study</span> 
		of <SPAN STYLE="color: #800000">Ethics</span> in the <SPAN STYLE="color: #800000">Professions</span> at
		<SPAN STYLE="color: #800000">IIT</span></h1>
	</div>

</div>
-->
<br />
<br />

<div id="page">
  <div id="breadcrumbs">Nano Ethics Bank - Help</div>
</div>
<br />
<div id="page">
  <div id="breadcrumbs">Boolean Search</div>
</div>

<p align="justify"> Boolean searching is a tool that allows users to define their 
  searches in a more exact way by constructing logical relationships among search 
  terms. While not needed for simple searches, Boolean searching can help eliminate 
  unwanted search results and even rank search results to favor one term over 
  another. Unlike some databases which use "AND" "OR" and "NOT," the NanoEthics 
  Bank (NEB) uses "+," "-," and spaces to allow users to create search equations.</p>
<p align="justify">To switch from normal to Boolean searching, find the drop down 
  box right below the search box and switch the mode to Boolean.</p>
<p align="justify"><strong>Or&#8221; searches</strong><br>
  To search for material that includes any of a number of words, enter the words 
  with only a space between them. This search is helpful when you are not sure 
  which term might be used in an article, such as the words &#8220;college&#8221; 
  and &#8220;university.&#8221; <br>
  The search equation would look like this: <br>
  &#8216;college university&#8217; <br>
  and would bring up all records containing either the word college, the word 
  university or records containing both words (represented by the area where the 
  two circles overlap). </p>
<p align="justify">&nbsp;</p>
<p align="justify"><br>
</p>
<!--
<br>
<br>
<h2> Boolean Searching </h2>
<br>
-->
<div align="center">
<form name="form1" method="post" action="login.php">
  </form>
</div>

<br>
<div id="footer"> 
	<ul>
		
      
    <li><a href="http://ethics.iit.edu/search.php">Search CSEP</a></li>
		
    <li><a href="http://ethics.iit.edu/sitemap.html">Site Map</a></li>
		
    <li><a href="http://ethics.iit.edu/contactus.html">Contact CSEP</a></li>
	</ul>
</div>
</body>
</html>

