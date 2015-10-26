<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<?php
		$sql_index_query = "Select DISTINCT index_terms from bank";

		include("./db.php");
		$link=mysql_connect($dbh,$user,$pass);
			if( !link)
        die ("Couldnt connect to MySql");
		mysql_select_db("$db");

		$result_index = mysql_query($sql_index_query, $link) or die(mysql_error());
		
		$array_index = array();
		while($row_index = mysql_fetch_object($result_index))
		{
			$row_data = $row_index->index_terms;

			$token = trim(strtok($row_data,";"));
			while ($token != false)
			{
				echo $token;
				echo "<br />";
				if (array_search(trim($token),$array_index) > 0)
				{
					echo "Dup: -> " . $token . "<br />";
				}
				else
					array_push($array_index,trim($token));
				$token = strtok(";");
			}
		}
		sort($array_index);
		array_unique($array_index);
?>		
	
<?php
   function separateIndexTerms()
   {
       $str=array("Rahul","Trehan");
	   $token = strtok($str, ";");

       while ($token !== false)
       { 
         $str=array("$token<br />");
         $token = strtok(";");
	   }
	   echo $str;   
   }
?>


</body>
</html>
