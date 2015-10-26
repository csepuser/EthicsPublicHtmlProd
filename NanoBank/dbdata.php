<?php
	include("db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
			die ("Couldnt connect to MySql");
	mysql_select_db("$db");
?>


<?php    
	/* This function separates the index terms and displays them separately 
	*/
	function separateIndexTerms($str)
   { 
      $temp_array=explode(";",$str,4);
	  foreach($temp_array as $value)
	  {
	   echo '<a href=./asearch.php?searchIndex=' . urlencode(trim($value))  . ' target="_blank">' .  trim($value) .'&nbsp'. '</a> ';
	  }    
     reset($temp_array);
   }
   
   function separateAuthors($str)
   { 
      $temp_array=explode(";",$str,4);
	  foreach($temp_array as $value)
	  {
	   echo '<a href=./asearch.php?searchAuthorCombine=' . urlencode(trim($value))  . ' target="_blank">' .  trim($value) .'&nbsp'. '</a> ';
	  }    
     reset($temp_array);
   }   
?>

<?php
	
	$query = sprintf("select * from bank b, details d where b.bookid = d.bookid");
	$result_id=mysql_query($query) or die("Bad query: ".mysql_error());
	while($row=mysql_fetch_array($result_id))
	{


		echo '<br><br>@article {';
		echo $row["bookid"];

		if (!empty($row["title"])){
			echo ',<br>title = {';
			echo $row["title"];
			echo '}';

		}

		if (!empty($row["year_published"])){
			echo ',<br>year = {';
			echo $row["year_published"];
			echo '}';
		}

		if (!empty($row["date_published"])){
			echo ',<br>month = {';
			echo $row["date_published"];
			echo '}';
		}

		if (!empty($row["publication_type"])){
			echo ',<br>type = {';
			echo $row["publication_type"];
			echo '}';
		}

		if (!empty($row["abstract"])){
			echo ',<br>abstract = {';
			echo htmlentities($row["abstract"]);
			echo '}';
		}

		if (!empty($row["isbn"])){
			echo ',<br>isbn = {';
			echo $row["isbn"];
			echo '}';
		}

		if (!empty($row["title_periodical"])){
			echo ',<br>journal = {';
			echo $row["title_periodical"];
			echo '}';
		}

		if (!empty($row["issue"])){
			echo ',<br>volume = {';
			echo $row["issue"];
			echo '}';
		}

		if (!empty($row["page_others"])){
			echo ',<br>pages = {';
			echo $row["page_others"];
			echo '}';
		}

		if (!empty($row["place_published"])){
			echo ',<br>address = {';
			echo $row["place_published"];
			echo '}';
		}

		if (!empty($row["conference"])){
			echo ',<br>booktitle = {';
			echo $row["conference"];
			echo '}';
		}

		if (!empty($row["url_source"])){
			echo ',<br>url = {';
			echo $row["url_source"];
			echo '}';
		}

		if (!empty($row["publisher"])){
			echo ',<br>publisher = {';
			echo $row["publisher"];
			echo '}';
		}

		if (!empty($row["issn"])){
			echo ',<br>issn = {';
			echo $row["issn"];
			echo '}';
		}
		echo '<br>}';
	}
?>


</body>
</html>
