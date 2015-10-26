<?
function get_tagClouds()
 { 
  $parsedString=new jSearchString();
  $parsedString=$parsedString->parseString($_GET['words']);
  $parsedString=trim($parsedString );
  //echo $parsedString;
	  if($parsedString != NULL)
	  {
		$tag_array=explode('Ç',$parsedString);
		//$tag_array = trim($tag_array);
		//update the database 
			foreach($tag_array as $tag_word)
			{ 
			  $tag_word=trim($tag_word);
			  $query="SELECT search_terms, MATCH (search_terms) AGAINST ($tag_word) AS count FROM tagclouds ";
				  if(mysql_query($query)!=true)
				  {    
					$sql="UPDATE tagclouds SET value=value+1 where search_terms="."'$tag_word'" ;
					//echo $sql;
					$result=mysql_query($sql) or die(mysql_error());
				  }
				  if($tag_word == NULL  || strlen($tag_word)<= 2 )
				  {
					next($tag_array);
				  }
				  else
				  {
					  //echo $tag_word;
		               $sql="INSERT INTO `tagclouds`( 
												   `search_terms` 						      
													 ) 
													 VALUES ( 								  
													 '".$tag_word."')";  
					mysql_query($sql) or die("Bad query on detail: ".mysql_error()); 
					remove_duplicate(); 
				  }	
			 }
	   }  
 }
 
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
  
/* Function for  generating the tagclouds from the database */
    function  gen_tagClouds(){
	/*limit the query results to 5*/
	$query = "SELECT value,search_terms AS tag FROM tagclouds GROUP BY search_terms ORDER BY value DESC LIMIT 25";

	$result = mysql_query($query);

  
	while ($row = mysql_fetch_array($result)) {
     
	  $tags[$row['tag']] = $row['value'];
	
	}
	 
	$max_size =120;  
	$min_size = 57;  
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
	
	foreach ($tags as $key => $value) 
	{
	// calculate CSS font-size
    // find the $value in excess of $min_qty
    // multiply by the font-size increment ($size)
    // and add the $min_size set above
//	$size = 7
     $size = $min_size + (($value - $min_qty) * $step);
    // uncomment if you want sizes in whole %:
      $size = ceil($size);
      $size = $size * 1.25;

    // you'll need to put the link destination in place of the #
    // (assuming your tag links to some sort of details page)
	//*****************************************************
    echo '<a href="./index.php?cmd=search&words='. urlencode(trim($key)).'&mode=normal" style="font-size: '.$size.'%"';
    // perhaps adjust this title attribute for the things that are tagged
    echo ' title="'.$value.' times records searched for '.$key.'"';
	echo '<br><br>';
    echo '&nbsp;'.$key.'&nbsp;</a> ';
	
	//****************************************************
    // notice the space at the end of the link
   }
  } 
/*
 * If a delete button is pressed then delete row from both table (bank and details)
 */
if(isset($_GET['delete']))
{
	if ($_SESSION['edit'] == true)
	{
		$del_bank = "DELETE FROM bank WHERE bookid='".$_GET['delete']."'";
		$del_check = mysql_query($del_bank,$link) or die(mysql_error());
		$del_details = "DELETE FROM details WHERE bookid='".$_GET['delete']."'";
		$del_check = mysql_query($del_details,$link) or die(mysql_error());
	}
}
?>