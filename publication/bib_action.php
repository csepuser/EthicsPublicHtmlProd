<?php
session_start();   
  
  header("Expires: Mon, 31 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Cache-control: private");
  header("Pragma: no-cache");
  
  // trimming
  
  $_SESSION['Name'] = trim($_POST['Name']);
  $_SESSION['Email'] = trim($_POST['Email']);
  $_SESSION['profession'] = trim($_POST['Profession']);
  
  $name = $_POST['Name'];
  $email = $_POST['Email'];
  $address =$_POST['Address'];
  $profession = $_POST['Profession'];
  $articles = " ";
  $Mailfor = "csep@iit.edu";
  
  $check=$_POST['check'];
  foreach ($check as $statename)
    { $articles = $articles . "<br><br>" . "- " .$statename; }
  
  $body ="<html><p><b>Name:</b><br>
   &nbsp;&nbsp;&nbsp;$name &#60;<a href=\"mailto:$email\">$email</a>&#62;<br>
<b>Address:</b><br>
   &nbsp;&nbsp;&nbsp;$address<br>
<b>Profession:</b><br>
   &nbsp;&nbsp;&nbsp;$profession<br>
<b>Articles:</b><br><br>
   &nbsp;&nbsp;&nbsp;$articles</p></html>";
   
   mail($Mailfor, "Article Request - CSEP", $body);
   
   header("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . "/bib.html")
   
?>
