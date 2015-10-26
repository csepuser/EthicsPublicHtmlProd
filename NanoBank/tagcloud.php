<?php
  ob_start();
 require('jSearchString.php');
 //require('tagcloud2.php');
?>
<?php
    session_start(); 
	include("./db.php");
	
	$link=mysql_connect($dbh,$user,$pass);
	if(!link) 
        die ("Couldnt connect to MySql");
	mysql_select_db("$db") or die (mysql_error());

  
?>
<?
 /* Remove duplicate entries from the table*/
 function remove_duplicate()
 {
    $sql="CREATE TABLE new_table AS SELECT * FROM tagclouds WHERE 1 GROUP BY search_terms";
    $result=mysql_query($sql);
	if($result)
	{
	 $sql="DROP TABLE tagclouds";
	 $result=mysql_query($sql);
	 if($result)
	 {
	  $sql="RENAME TABLE new_table TO tagclouds";
	  $result=mysql_query($sql) or die(mysql_error());
	 }
	 else
	 {
	  die(mysql_error());
	 }
	}
	else 
	{
	 die(mysql_error());
	} 
 }
 
 /* generate tag clouds from the database*/
 // connect to database at some point

// In the SQL below, change these three things:
// thing is the column name that you are making a tag cloud for
// id is the primary key
// my_table is the name of the database table

$query = "SELECT value,search_terms AS tag FROM tagclouds GROUP BY search_terms ORDER BY value DESC LIMIT 5";

$result = mysql_query($query);

// here we loop through the results and put them into a simple array:
// $tag['thing1'] = 12;
// $tag['thing2'] = 25;
// etc. so we can use all the nifty array functions
// to calculate the font-size of each tag
while ($row = mysql_fetch_array($result)) {

    $tags[$row['tag']] = $row['quantity'];
}

// change these font sizes if you will
$max_size = 250; // max font size in %
$min_size = 100; // min font size in %

// get the largest and smallest array values
$max_qty = max(array_values($tags));
$min_qty = min(array_values($tags));

// find the range of values
$spread = $max_qty - $min_qty;
if (0 == $spread) { // we don't want to divide by zero
    $spread = 1;
}

// determine the font-size increment
// this is the increase per tag quantity (times used)
$step = ($max_size - $min_size)/($spread);

// loop through our tag array
foreach ($tags as $key => $value) {

    // calculate CSS font-size
    // find the $value in excess of $min_qty
    // multiply by the font-size increment ($size)
    // and add the $min_size set above
    $size = $min_size + (($value - $min_qty) * $step);
    // uncomment if you want sizes in whole %:
    // $size = ceil($size);

    // you'll need to put the link destination in place of the #
    // (assuming your tag links to some sort of details page)
 //   echo '<a href="./index.php?cmd=search&words='. urlencode(trim($key)).'&mode=normal" style="font-size: '.$size.'%"';
    // perhaps adjust this title attribute for the things that are tagged
 //   echo ' title="'.$value.' things tagged with '.$key.'"';
 //   echo '>'.$key.'</a> ';
    // notice the space at the end of the link
}

?>
   
 
<html>
<head>
<title>Tag Clouds</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php
 if(isset($_SESSION['Search']))
 {
   
  $searchword=(isset($_POST['searchwords']) ?  htmlspecialchars(stripslashes($_REQUEST['searchwords'])) : '');
  $parsedString=new jSearchString();
  $parsedString=$parsedString->parseString($searchword);
  echo $parsedString;
  $tag_array=explode(';',$parsedString);
     
  /* foreach($tag_array as $tag_word)
  {
       
    $query="SELECT search_terms, MATCH (search_terms) AGAINST ($tag_word) AS count FROM tagclouds ";
	if(mysql_query($query,$link )!=true)
	{    
	  $sql="UPDATE tagclouds SET value=value+1 where search_terms="."'$tag_word'" ;
	  //echo $sql;
	  $result=mysql_query($sql) or die(mysql_error());
    }
   }
  foreach($tag_array as $tag_word)
  {
       
    $query="SELECT search_terms, MATCH (search_terms) AGAINST ($tag_word) AS count FROM tagclouds ";
	if(mysql_query($query,$link )==true)
	{
	  next($tag_array);
	  remove_duplicate();
    } 
	else
	{
	  $sql="INSERT INTO `tagclouds`( 
                               `search_terms` 
								 ) 
	 							 VALUES ( 								  
								 '".$tag_word."')";   
     mysql_query($sql,$link) or die("Bad query on detail: ".mysql_error()); 
	 remove_duplicate();
	}
   }  
  
   remove_duplicate();  
*/
} 
 
 
?>
<form action="tagcloud.php" method="post">
<table>
 <tr>
 <td><input type="text" name="searchwords"></td>
 <td><input type="submit" name="Search"></td>
 </tr>
</table>
</form>  
<?
  

 
?> 
</body>
</html>