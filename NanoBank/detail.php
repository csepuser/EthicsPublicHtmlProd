<?php
	include("db.php");
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
			die ("Couldnt connect to MySql");
	mysql_select_db("$db");
?>


<html>
	<head>
		<title>Nano Bank</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="newlayout/stylesneb_1006.css" rel="stylesheet" type="text/css">
		<link rel="shortcut icon" href="newlayout/favicon.ico" >
	</head>
<body>

<div id="container">
		<div id="header">
			<img id="neb_logo" src="Nanoheader8.jpg"/>
		</div>
   <div id="top_nav_container">
        		<ul>
		   			  <li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;&nbsp;</li>
					  <li><a href="../NanoEthicsBank/">NanoEthicsBank</a>&gt;&gt;&nbsp;</li>
                      <li id="nav_blank"><a>Record in Detail</a></li>
			    </ul>
			<div style="clear:both;"></div>
   </div>
<br>


<?php
	$bookid = $_GET["bookid"];
	$query = sprintf("SELECT * FROM `bank` WHERE `bookid`= %d",$bookid);
	$result_id=mysql_query($query) or die("Bad query: ".mysql_error());
	$row=mysql_fetch_array($result_id);	

	$query = "SELECT * FROM `details` WHERE `bookid`= " . $bookid;
	$result_id=mysql_query($query) or die("Bad query: " . mysql_error());
	$row_details=mysql_fetch_array($result_id);
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

<p>&nbsp;  </p>
<div id="content">
<table width="100%" border="1" bgcolor="#FFFFFF" align="center">
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Title</strong></div></td>
    <td width="100%"><div align="left"> 
        <?= $row["title"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Sub Title</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["title_sub"]?>
        &nbsp;</div>
	</td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Author</strong></div></td>
    <td width="70%"><div align="left">
	<? 
	  separateAuthors($row["author"]);
	 ?> 
        &nbsp;</div></td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Periodical</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["title_periodical"]?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Uniform Title</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["title_uniform"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Publisher</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["publisher"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Volume</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["volume"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Issue</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["issue"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Conference</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["conference"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Year Produced</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["year_produced"]?>
        &nbsp;</div>
	</td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Date Produced</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["date_produced"]?>
        &nbsp;</div>
	</td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Year Published</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["year_published"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Date Published</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["date_published"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Place of Publication</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["place_published"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Edition</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["edition"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Other Editions</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["edition_other"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Page Start</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["page_start"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Other Pages</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["page_others"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Physical Description</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["description_physical"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Includes</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["includes"]?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Source</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["source"]?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Page Start</strong> 
        &nbsp;</div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["page_start"]?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Type of Publication</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["publication_type"]?>
        &nbsp;</div></td>
  </tr>

  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Format</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["format"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>ISBN/ISSN</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["isbn"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Abstract</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["abstract"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Annotation</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["annotation"]?>
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Language</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["language"]?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Source URL</strong></div></td>
    <td width="70%"><div align="left"> 
        <? echo '<a href=' . $row_details["url_source"] .' target="_blank">' . $row_details["url_source"] . '</a>'?>
        &nbsp;</div></td>
  </tr>
 
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>URL of Organization</strong></div></td>
    <td width="70%"><div align="left"> 
	    <? echo '<a href=' . $row_details["url_organization"] . ' target="_blank">' . $row_details["url_organization"] . '</a>'?> 
        &nbsp;</div></td>
  </tr>
  
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Subject</strong></div></td>
    <td width="70%"><div align="left"> 
	    <?
		   separateIndexTerms($row_details["index_terms"]);
		 ?>
          &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Series</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["series"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>ISSN</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["issn"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Corporate Author</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["author_corporate"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Title Original</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["title_original"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>User Tags</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row["keywords"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <td width="30%" height="30"><div align="left"><strong>Full Text</strong></div></td>
    <td width="70%"><div align="left"> 
        <?= $row_details["full_text"]?>
        &nbsp;</div></td>
  </tr>
  <tr> 
    <?php
    print ("<td align='left' height='30'> <strong> File </strong>: &nbsp; </td>");
    print ("<td align='left'>");
	if (isset ($row_details["file"]))
	{
		print ("<a href=./docs/".$row_details["file"]." >");
		print ($row_details["file"]);
		print ("</a>");
	}
	print("&nbsp;");
    print ("</td>");
?>
  </tr>
</table>
<br>
</div>

	<div id="footer"> 
			<?php
				// this is a commom footer file 
				include("Footer.php");
			?>
	</div>


</body>
</html>
