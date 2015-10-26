<?php

/*
note:
this is just a static test version using a hard-coded countries array.
normally you would be populating the array out of a database

the returned xml has the following structure
<results>
	<rs>foo</rs>
	<rs>bar</rs>
</results>
*/
	//session_start();
	require_once("db.php");
	
	//get the input from the txt field
	$input= strtolower($_GET['input']);
	$len = strlen($input);
	$aResults = array();
	$dbResult=array();
	
	//connect to the database and run the query
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db") or die (mysql_error());
	
	//$sql = "select title from test.bank where title like \"".$input."%\" limit 10 ";
	$sql ="SELECT bookid, title, author, title_periodical, publisher, volume, abstract, index_terms, keywords,
						   MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
						   AGAINST ('$input') AS score FROM bank 
						   WHERE MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
						   AGAINST ('$input') ORDER BY score DESC LIMIT 10";
	//echo $sql;
	$result= mysql_query($sql);
	
	while($rows=mysql_fetch_array($result))
	{
		
		$dbResult[]= $rows['title'];
        //echo $rows;  
	}
	
	mysql_close($link);
	//print_r($dbResult);
	
	
	if ($len)
	{
		for ($i=0;$i<count($dbResult);$i++)
		{
			// had to use utf_decode, here
			// not necessary if the results are coming from mysql
			//
			if (strtolower(substr(utf8_decode($dbResult[$i]),0,$len)) == $input)
				$aResults[] = array("id"=>($i+1) ,"value"=>htmlspecialchars($dbResult[$i])); 
		}
	}

	//print_r($aResults);
	
	 
	
	
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0	
	
	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($aResults);$i++)
		{
			$arr[] = "{\"id\": \"".$dbResult[$i]['id']."\", \"value\": \"".$dbResult[$i]['value']."\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($dbResult);$i++)
		{
			echo "<rs id=\"".$i."\" info=\"".trim(htmlspecialchars($dbResult[$i]))."\">".trim(htmlspecialchars($dbResult[$i]))."</rs>";
			//echo "<rs>".$dbResult[$i]."</rs>";
		}
		echo "</results>";
	}
	

?>