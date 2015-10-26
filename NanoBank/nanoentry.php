<?php
	session_start();
	
	$user="csep";
	$pass="ec1976!";
	$db="nanoethicsbank";
	$dbh="myst-my-p.cns.iit.edu";
	$baseurl="../uploaded";
	$baseurl1="uploaded";
	$tbl_bank="bank";
	
	$link= @mysql_connect($dbh,$user,$pass);
	if(!$link)
        	die('Could not connect: ' . mysql_error());
	@mysql_select_db("$db") or die (mysql_error());	
	
/**
 *@author Anurag Kabra
 *This function fetches index_terms from the table and adds it into an array. It also takes care of the ';' seperated user tags
 */
 	function getIndexTermsList()
	{
		$sql_index_query = "Select DISTINCT index_terms from bank";

		include("db.php");
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
				if (strcasecmp($token,'""') != 0)
				{
					if (array_search(trim($token),$array_index) > 0)
					{
					}
					else
						array_push($array_index,trim($token));
				}
					
				$token = trim(strtok(";"));
			}
		}
		rsort($array_index);		 
		return $array_index;
	}

	/** Check if the btn_insert is clicked - to avoid it first time*/
	if(isset($_POST['btn_insert']) && $_SESSION['edit'] == true)
	{
		$str_insert_bank = "INSERT INTO bank (`bookid`, `title`, `author`,`title_periodical`,`publisher`,`volume`,`issue`,`abstract`,`index_terms`,`keywords`) VALUES ('', '" . $_POST['title'] . "', '" . $_POST['author'] . "', '" . $_POST['title_periodical'] . "', '" . $_POST['publisher'] . "', '" . $_POST['volume'] . "', '" . $_POST['issue'] . "', '" . $_POST['abstract'] . "', '" . $_POST['index_terms'] . "', '" . $_POST['notes'] . "')";
		$result_insert_bank = mysql_query($str_insert_bank) or die("Bad query: ".mysql_error());
		
		$lastid = mysql_insert_id();
		$str_insert_details = "INSERT INTO details (`bookid`, 
													`title_sub`,
													`title_uniform`,
													`conference`,
													`year_produced`,
													`date_produced`,
													`year_published`,
													`date_published`,
													`place_published`,
													`edition`,
													`edition_other`,
													`page_start`,
													`page_others`,
													`description_physical`,
													`includes`,
													`source`,
													`publication_type`,
													`format`,
													`isbn`,
													`annotation`,
													`language`,
													`url_source`,
													`url_organization`,
													`index_terms`,
													`series`,
													`issn`,
													`author_corporate`,
													`title_original`,
													`notes`,
													`full_text`
													) VALUES ('"
													. $lastid . "', '" 
													. $_POST['title_sub'] . "', '"
													. $_POST['title_uniform'] . "', '"
													. $_POST['conference'] . "', '"
													. $_POST['year_produced'] . "', '"
													. $_POST['date_produced'] . "', '"
													. $_POST['year_published'] . "', '"
													. $_POST['date_published'] . "', '"
													. $_POST['place_published'] . "', '"
													. $_POST['edition'] . "', '"
													. $_POST['edition_other'] . "', '"
													. $_POST['page_start'] . "', '"
													. $_POST['page_others'] . "', '"
													. $_POST['description_physical'] . "', '"
													. $_POST['includes'] . "', '"
													. $_POST['source'] . "', '"
													. $_POST['publication_type'] . "', '"
													. $_POST['format'] . "', '"
													. $_POST['isbn'] . "', '"
													. $_POST['annotation'] . "', '"
													. $_POST['language'] . "', '"
													. $_POST['url_source'] . "', '"
													. $_POST['url_organization'] . "', '"
													. $_POST['index_terms'] . "', '"
													. $_POST['series'] . "', '"
													. $_POST['issn'] . "', '"
													. $_POST['author_corporate'] . "', '"
													. $_POST['title_original'] . "', '"
													. $_POST['notes'] . "', '"
	    											. $_POST['full_text'] . "')";
         
		mysql_query($str_insert_details) or die("Bad query on detail: ".mysql_error());	    
	}
	else if (isset($_POST['btn_update']))
	{
		// Updating Bank table
		$str_update_bank = "UPDATE bank SET title='" . $_POST['title'] . "',author='" . $_POST['author'] . "',title_periodical='" . $_POST['title_periodical'] . "',publisher='" . $_POST['publisher'] . "',volume='" . $_POST['volume'] . "',issue='" . $_POST['issue'] . "',abstract='" . $_POST['abstract'] . "',index_terms='" . $_POST['index_terms'] . "',keywords='" . $_POST['notes'] . "' WHERE bookid=".$_GET['bookid'];
		//echo $str_update_bank;
		$result_update_bank = mysql_query($str_update_bank);

		// Updating Details table
		$str_update_details = "UPDATE details SET title_sub='"
															. $_POST['title_sub'] . "', title_uniform='" 
															. $_POST['title_uniform'] . "', conference='" 
															. $_POST['conference'] . "', year_produced='"
															. $_POST['year_produced'] . "', date_produced='"
															. $_POST['date_produced'] . "', year_published='"
															. $_POST['year_published'] . "', date_published='"
															. $_POST['date_published'] . "', place_published='"
															. $_POST['place_published'] . "', edition='"
															. $_POST['edition'] . "', edition_other='"
															. $_POST['edition_other'] . "', page_start='"
															. $_POST['page_start'] . "', page_others='"
															. $_POST['page_others'] . "', description_physical='"
															. $_POST['description_physical'] . "', includes='"
															. $_POST['includes'] . "', source='"
															. $_POST['source'] . "', publication_type='"
															. $_POST['publication_type'] . "', format='"
															. $_POST['format'] . "',isbn='"
															. $_POST['isbn'] . "', annotation='"
															. $_POST['annotation'] . "', language='"
															. $_POST['language'] . "', url_source='"
															. $_POST['url_source'] . "', url_organization='"
															. $_POST['url_organization'] . "', index_terms='"
															. $_POST['index_terms'] . "', series='"
															. $_POST['series'] . "', issn='"
															. $_POST['issn'] . "', author_corporate='"
															. $_POST['author_corporate'] . "', title_original='"
															. $_POST['title_origninal'] . "', notes='"
															. $_POST['notes'] . "', full_text='"
															. $_POST['full_text'] . "' WHERE bookid=" 
															. $_GET['bookid'];											
		
		//send mail to csep@iit.edu 
		   if($_SESSION['neb_user']!="csep"){
		   
		   $message1 ="the following user : "   .$_SESSION['neb_user']."<br>"  ;
		   $message1.="  added notes to bookid :" .$_GET['bookid']  ;
		   $message2 ="Tag :".$_POST['notes'];
		   $message =" $message1 <br> $message2";
		   $subject ="User tags updated";
		   $headers  = 'MIME-Version: 1.0' . "\r\n";
           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		   mail('laas@iit.edu',$subject,$message,$headers);
	       }
		   else{
		   }		
		mysql_query($str_update_details);
	}
	if (($_SESSION['edit_keyword'] == true ) && isset($_GET['bookid']))
	{
		$bookid = $_GET["bookid"];
		$query = sprintf("SELECT * FROM `bank` WHERE `bookid`= %d",$bookid);
		$result_id=mysql_query($query) or die("Bad query: ".mysql_error());
		$row=mysql_fetch_array($result_id);
		
		$query = sprintf("SELECT * FROM `details` WHERE `bookid`= %d",$bookid);
		$result_id=mysql_query($query) or die("Bad query: ".mysql_error());
		$row_details=mysql_fetch_array($result_id);
	}
?>

<html>
<head>
	<title>Nano Database Entry</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="newlayout/stylesneb_1006.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="newlayout/favicon.ico" >

	<script language="JavaScript">
	function swapOptions(the_array_name)
	{
		window.document.form_insert.index_terms.value = the_array_name;
	}
	</script>
</head>

<body>

<div id="container">
	<div id="header">
			<img id="neb_logo" src="Nanoheader8.jpg"/>
	</div>

<div id="top_nav_container">
	<ul>
		<li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;</li>
		<li><a href="./index.php">NanoEthicsBank</a> &gt;&gt;</li>
		<li>Insert Record</li>
	</ul>	
</div>

<div align="center" >
	<?php

		if ($_SESSION['edit_keyword'] == true && isset($_GET['bookid']))
		{	
			echo '<br>';
			print ("<form action=nanoentry.php?bookid=" . $_GET['bookid'] . " method='post' name='form_insert' id='form_insert'>");
			print ("<table width='100%' cellspacing='2' align='center'>");
			
			print ("<tr>");
			print ("<td width='40%' align='left'> <strong> Title </strong>: &nbsp; </td>");
			$title = htmlentities($row["title"],ENT_QUOTES);
			print ("<td align='left' width='100%'> <input name='title' type='text' value='". $title ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
		
			print ("<tr>");
			print ("<td width='20%' align='left'> <strong> Sub Title </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='title_sub' type='text' value='". htmlentities($row_details["title_sub"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
		
			print ("</tr>");
			print ("<tr>");
			print ("<td width='20%' align='left'> <strong> Authors </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='author' type='text' value='". $row["author"] ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
		
			print ("<tr>");
			print ("<td width='20%' align='left'> <strong> Title of Periodical </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='title_periodical' type='text' value='". htmlentities($row["title_periodical"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
		
			print ("<tr> ");
			print ("<td align='left' width='20%'> <strong> Uniform Title </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='title_uniform' type='text' value='". htmlentities($row_details["title_uniform"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Publisher </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='publisher' type='text' value='". htmlentities($row["publisher"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr> ");
			print ("<td align='left' width='20%'> <strong> Volume </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='volume' type='text' value='". $row["volume"] ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Issue </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='issue' type='text' value='". htmlentities($row["issue"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Conference </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='conference' type='text' value='". htmlentities($row_details["conference"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Year Produced </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='year_produced' type='text' value='". htmlentities($row_details["year_produced"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Date Produced </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='date_produced' type='text' value='". htmlentities($row_details["date_produced"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Year Published </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='year_published' type='text' value='". htmlentities($row_details["year_published"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Date Published </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='date_published' type='text' value='". htmlentities($row_details["date_published"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Place Published </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='place_published' type='text' value='". htmlentities($row_details["place_published"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr> ");
			print ("<td align='left' width='20%'> <strong> Edition </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='edition' type='text' value='". htmlentities($row_details["edition"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Other Editions </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='edition_other' type='text' value='". htmlentities($row_details["edition_other"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Start Page </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='page_start' type='text' value='". htmlentities($row_details["page_start"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Other Pages </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='page_others' type='text' value='". htmlentities($row_details["page_others"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Physical Description </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='description_physical' type='text' value='". htmlentities($row_details["description_physical"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Includes </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='includes' type='text' value='". htmlentities($row_details["includes"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Source </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='source' type='text' value='". htmlentities($row_details["source"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Type of Publication </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='publication_type' type='text' value='". htmlentities($row_details["publication_type"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Format </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='format' type='text' value='". htmlentities($row_details["format"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> ISBN / ISSN </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='isbn' type='text' value='". htmlentities($row_details["isbn"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Abstract </strong>: &nbsp; </td>");
			if ($_SESSION['edit'] == false)
				print ("<td align='left' width='100%'> <textarea name='abstract' readonly cols='47' rows='4'>" . $row["abstract"] . "</textarea> </td>");
			else
			print ("<td align='left' width='100%'> <textarea name='abstract' cols='47' rows='4'>" . $row["abstract"] . "</textarea> </td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Annotation </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='annotation' type='text' value='". htmlentities($row_details["annotation"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Language </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='language' type='text' value='". htmlentities($row_details["language"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> URL of Source </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='url_source' type='text' value='". $row_details["url_source"] ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> URL of Organization </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='url_organization' type='text' value='". $row_details["url_organization"] ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Subject </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='index_terms' type='text' value='". htmlentities($row_details["index_terms"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
		
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Corporate Author </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='author_corporate' type='text' value='". htmlentities($row_details["author_corporate"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='700'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr> ");
			print ("<td align='left' width='20%'> <strong> Original Title </strong>: &nbsp; ");
			print ("</td>");
			print ("<td align='left' width='100%'> <input name='title_original' type='text' value='". htmlentities($row_details["title_original"],ENT_QUOTES) ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> User Tags </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <textarea name='notes' cols='47' rows='1'>" . $row["keywords"] . "</textarea> </td>");
			print ("</tr>");
			
			print ("<tr>");
			print ("<td align='left' width='20%'> <strong> Full Text </strong>: &nbsp; </td>");
			print ("<td align='left' width='100%'> <input name='full_text' type='text' value='". $row_details["full_text"] ."' style='width: 400px;' maxlength='128' width='100%'");
			if ($_SESSION['edit'] == false)
				print (" readonly ");
			print (">");
			print ("</td>");
			print ("</tr>");
			
			print ("</table>");
			print ("<table width='100%'>");
			print ("<tr>");
			print ("<td>&nbsp;</td>");
			print ("</tr>");
			print ("<tr align='center'>");
			print ("<td width='100%' align='center'> <input name='btn_update' type='submit' value='UPDATE'> </td>");
			print ("</tr>");
			print ("</table>");
			print ("</form>");
		}
		else if ($_SESSION['edit'] == true && !isset($_GET['bookid']))
		{
		?>
		
		<form action="nanoentry.php" method="post" name="form_insert" id="form_insert">
		  <table width="100%" cellspacing="2" align="center">
			<tr> 
			  <td width="40%" align="left"> <strong> Title </strong>: &nbsp; </td>
			  <td align="left" width="100%"> <input name="title" type="text" style="width: 400px;" maxlength="250" width="100%"></td>
			</tr>
			<tr> 
			  <td width="20%" align="left"> <strong> Sub Title </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="title_sub" type="text" style="width: 400px;" maxlength="128" width="700"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Authors </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="author" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Title of Periodical </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="title_periodical" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Uniform Title </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="title_uniform" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Publisher </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="publisher" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Volume </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="volume" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Issue </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="issue" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Conference </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="conference" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Year Produced </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="year_produced" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Date Produced </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="date_produced" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Year Published </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="year_published" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Date Published </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="date_published" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Place Published </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="place_published" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Edition </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="edition" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Other Editions </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="edition_other" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Start Page </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="page_start" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Other Pages </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="page_others" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Physical Description </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="description_physical" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Includes </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="includes" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Source </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="source" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Type of Publication </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="publication_type" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Format </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="format" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> ISBN / ISSN </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="isbn" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Abstract </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <textarea name="abstract" cols="47" rows="4"></textarea> </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Annotation </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="annotation" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Language </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="language" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> URL of Source </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="url_source" type="text" maxlength="250" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Subject </strong>: &nbsp; </td>
				<td align="left" width="80%"> <input name="index_terms" type="text" maxlength="250" width="700" style="width: 200px;">
					  <select name="selectTerm" style="width: 195px" size="1" onChange="swapOptions(window.document.form_insert.selectTerm.options[selectedIndex].text);">
						  <option value=""> </option>
							<?php
								$index_list = getIndexTermsList();
								$list_size = sizeof($index_list);
								while ($list_size != 0)
								{
									$list_size--;
							?>
							
							<option value=<?php echo '"' . $index_list[$list_size] . '"'; ?>> <?php echo $index_list[$list_size] ; ?> </option>
							
							<?php
								}
							?>
					  </select>
				</td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> URL of Organization </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="url_organization" type="text" maxlength="250" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Corporate Author </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="author_corporate" type="text" maxlength="250" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Original Title </strong>: &nbsp; 
			  </td>
			  <td align="left" width="80%"> <input name="title_original" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
			<tr> 
				<td align="left" width="20%"> <strong> User Tags </strong>: &nbsp;
				</td>
			  <td align="left" width="80%"> <textarea name="notes" cols="47" rows="2"></textarea> </td>
			</tr>
			<tr> 
			  <td align="left" width="20%"> <strong> Full Text </strong>: &nbsp; </td>
			  <td align="left" width="80%"> <input name="full_text" type="text" maxlength="128" width="700" style="width: 400px;"> 
			  </td>
			</tr>
		  </table>
		  <table width="100%">
			<tr> 
			  <td>&nbsp; </td>
			</tr>
			<tr align="center"> 
			  <td width="100%" align="center"> <input name="btn_insert" type="submit" value="INSERT"> </td>
			</tr>
		  </table>
		</form>
		<?php
		}
		?>
	</div>

<div id="footer"> 
    <ul>
      <li><a href="http://ethics.iit.edu/askalibrarian.php">Ask a Librarian</a></li>
      <li><a href="http://ethics.iit.edu/searchcsep.php">Search CSEP</a></li>
      <li><a href="http://ethics.iit.edu/sitemap.html">Site Map</a></li>
      <li><a href="mailto:csep@iit.edu">Contact CSEP</a></li>
    </ul>
</div>
</div>
</body>
</html>