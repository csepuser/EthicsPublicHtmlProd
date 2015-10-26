<?php
 	ob_start();
 	require('jSearchString.php'); 

	error_reporting(0);
	session_start();
	
	$user="csep";
	$pass="ec1976!";
	$db="nanoethicsbank";
	$dbh="myst-my-p.cns.iit.edu";
	$baseurl="../uploaded";
	$baseurl1="uploaded";
	$tbl_bank="bank";
	
	$link=@mysql_connect($dbh,$user,$pass);

	if(!$link)
        die ("Couldnt connect to MySql");
	@mysql_select_db("$db") or die (mysql_error());

	include("./navbar.php");
	
	$nav = new navbar;
	$nav->numrowsperpage = 10;

 /* Function to parse the search string and update the database by Rahul Trehan*/
 function get_tagClouds()
 {
  
  $parsedString=new jSearchString();
  $parsedString=$parsedString->parseString($_GET['words']);
  $parsedString=trim($parsedString );
  if($parsedString != NULL)
  {
    $tag_array=explode('Ç',$parsedString);
	foreach($tag_array as $tag_word)
    { 
      $tag_word=trim($tag_word);
 	  $query="SELECT search_terms, MATCH (search_terms) AGAINST ($tag_word) AS count FROM tagclouds ";
	  if(mysql_query($query)!=true)
	  {    
	    $sql="UPDATE tagclouds SET value=value+1 where search_terms="."'$tag_word'" ;
	    $result=mysql_query($sql) or die(mysql_error());
      }
	  if($tag_word == NULL  || strlen($tag_word)<= 2 )
	  {
	    next($tag_array);
	  }
	  else
	  {
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
	 
	$max_size = 120;  
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
	
	foreach ($tags as $key => $value) {

    // calculate CSS font-size
    // find the $value in excess of $min_qty
    // multiply by the font-size increment ($size)
    // and add the $min_size set above
     $size = $min_size + (($value - $min_qty) * $step);
    // uncomment if you want sizes in whole %:
      $size = ceil($size);
        $size = $size * 1.25;
    // you'll need to put the link destination in place of the #
    // (assuming your tag links to some sort of details page)
	//*****************************************************
    echo '<a href="./popular_search.php?cmd=search&words='. urlencode(trim($key)).'&mode=normal" style="font-size: '.$size.'%"';
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

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>CSEP - Nano Ethics Bank </title>
    <link href="stylesneb_1006.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" >
	<script type="text/javascript" src="AutoSuggest.js" ></script>
	<link rel="stylesheet" href="autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />	
</head>

<SCRIPT TYPE="text/javascript">
<!--
/* To Display the Help lin*/
function popup(mylink)
{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
   		href=mylink;
	else
   		href=mylink.href;
	window.open(href, 'Help', 'width=600,height=400,scrollbars=yes');
	return false;
}

/* 
	To Display the Help link when boolean search is selected.
	The coordinates of "mode" are found using findX and findY functions.
*/
function lookMode(mode)
{
	var mydiv = document.getElementById("mydiv");
	if (mode == 'Boolean')
	{
		if (mydiv == null)
		{
			alert("Sorry can't find your div");
			return;
		}
		var left = findX("mode");
		left = left + 100;
		
		var top = findY("mode");
		top = top + 2;
		mydiv.style.display='block';
		mydiv.style.left = left;
		mydiv.style.top = top;
	}
	else
		mydiv.style.display='none';;
}

function getY(layerID)
{
	var iReturnValue = 0;
	elementid=document.getElementById(layerID)
	while( elementid != null )
	{
		iReturnValue += elementid.offsetTop;
		elementid = elementid.offsetParent;
	}
	alert("link:"+iReturnValue);
	return iReturnValue;
}
/*
Finds the the X coordinate of the object
*/
function findX(layerID)
{
	var curleft = 0;
	obj=document.getElementById(layerID);
	if(obj.offsetParent)
		while(1) 
		{
			curleft += obj.offsetLeft;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
		}
	else if(obj.x)
		curleft += obj.x;
		
	return curleft;
}

/*
Finds the the Y coordinate of the object
*/
function findY(layerID)
{
	var curtop = 0;
	obj=document.getElementById(layerID);
	if(obj.offsetParent)
		while(1)
		{
			curtop += obj.offsetTop;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
		}
	else if(obj.y)
		curtop += obj.y;
	return curtop;
}
function moveObject(event)
{
    var delta = 0; 
	if (!event) event = window.event;  
	 // normalize the delta
    if (event.wheelDelta)
	{
		// IE & Opera
      	delta = event.wheelDelta / 120;
	}
	else if (event.detail) // W3C
	{
		delta = -event.detail / 3;
	}
   var currPos=document.getElementById('scrolltable').offsetTop;
   //calculating the next position of the object
   currPos=parseInt(currPos)+(delta*10);
   //moving the position of the object 
   document.getElementById('scrolltable').style.top=currPos+"px";
}

//-->
</SCRIPT>

<body>
<div id="container">
<div id="header"> <img id="neb_logo" src="Nanoheader8.jpg"/> </div>

<div id="top_nav_container"> 
  <ul>
    <li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;&nbsp;</li>
    <li><a href="http://ethics.iit.edu/NanoEthicsBank/index.php">NanoEthicsBank</a>&gt;&gt;&nbsp;</li>
    <li>Popular Search</li>
  </ul>
  <div style="clear:both;"></div>
</div>

<div id="neb_search_form">
    <?php
		/* The function displaying the search form along with advance search option has been moved to a separate PHP 'nebsearch.php'*/
		include("nebsearchform.php");	
	?>
</div>

<div id="breadcrumbs"> 
	<?php			
	   
	   /* To execute a query navigation object's funtion is called.  The navigation is defined ib navbar,php */
		$result = $nav->execute($sql, $link, "mysql");
		$num_rows = mysql_num_rows($result);
	   /*To count total number of data*/
		$Countresult=mysql_query($sql);
		$TotalCount = mysql_num_rows($Countresult);
		$TotalCount2 = $TotalCount;
		$total_records=$TotalCount;
			
		echo '<table width="98%" align="center">';
		echo '<tr>';
		$links = $nav->getlinks("sides", "on");			
		/*To count number of data on current page*/
		for ($y = 0; $y < count($links); $y++)
		{
			if ($y/2 == 0)
				echo  "<td align=\"left\">"  ;
			else
				echo " <td align=\"right\">"    ;
			echo $links[$y] .  "&nbsp;&nbsp;" ;
			echo "</td>";			
		 }
		 echo '</tr>';
		 echo '</table>';
	?>
</div>
  
<div id="center"> 
	<?php
	
	  	// code to display the number of row links in the database	
	  	echo '<table align="center">';
	  	echo '<tr>';
		$links = $nav->getlinks("pages", "on");
		$Pagenumber=$row;
		$StartPageNumber=($Pagenumber-2);
		$EndPageNumber=($Pagenumber+3);
		
		if ($Pagenumber >2)
		{
			for ($y = $StartPageNumber; $y < $EndPageNumber; $y++)
			{
				if ($y/2 == 0)
					echo  "<td align=\"right\">"  ;
				else
					echo " <td align=\"right\">"    ;
				echo $links[$y+1] .  "&nbsp;&nbsp;" ;
				echo "</td>";			
			}
		}
		else
		{
			for ($y = 0; $y <4; $y++)
			{
				if ($y/2 == 0)
					echo  "<td align=\"right\">"  ;
				else
					echo " <td align=\"right\">"    ;
				echo $links[$y+1] .  "&nbsp;&nbsp;" ;		
			}
				echo "</td>";	
		}	
		$links = $nav->getlinks("signs", "on"); 
		 
		 /*To count number of data on current page*/
		for ($y = 0; $y < count($links); $y++)
		{
			if ($y/2 == 0)
				echo  "<td align=\"left\">"  ;
			else
				echo " <td align=\"right\">"    ;
			echo $links[$y] .  "&nbsp;&nbsp;" ;
			echo "</td>";
		} 
			
		//To present how many data are available on page and the total number of pages
		if ($TotalCount != 0)
		{ 
			if ($row == 0)	
			{
				$Firstrow=$row+'1';
			}
			else
			{
				$Firstrow=($row )*'10';
			}
			if($row == 0)
			{
				if ($TotalCount<'10')
				{
					$Lastrow=$TotalCount;
				}
				else
				{
					$Lastrow=($row+1)*10;
				}
			}
			else
			{
		  		if($row == (integer)($TotalCount/10))
				{
					$Lastrow=$TotalCount;
				}
				else
				{									
					$Lastrow=($row+1)*10;
				}	
			}
			echo "<td align=right ><strong>Result :&nbsp; " . $Firstrow . ' - &nbsp; '.$Lastrow .' of &nbsp;'.$TotalCount ."&nbsp;</strong>";
			echo '</td>';
			}
			echo '</tr>';
			echo '</table>';
	
	?>
</div>

<div id="content"> <br/>
    <table width="100%" cols="2" border="0">
      <COLGROUP WIDTH="82%">
      </COLGROUP>
      <COLGROUP WIDTH="18%">
      </COLGROUP>
      <td> 
        <?php
				/*Display the results from the query as well as the tagclouds on the side*/
				function one_wordwrap($string,$width){
					$s=explode(" ", $string);
				    foreach ($s as $k=>$v) {
					   $cnt=strlen($v);
					   if($cnt>$width) $v=wordwrap($v, $width, "<br />", true);
					   $new_string.="$v ";
					}
					return $new_string;
				}	 		
				while($row = mysql_fetch_object($result))
					{	  
					  $sql_date = "SELECT `date_published` ,file, `url_source` FROM `details`WHERE `bookid`=" . $row->bookid;
					  $dt_object = mysql_query($sql_date, $link);
					  $dt_published = mysql_fetch_object($dt_object);
					  echo '<table width="100%" align="center" bgcolor="#ffffff" cellspacing=5 cellpadding=1>';
					  echo '<tr><td>&nbsp;</td></tr>';
					  echo '<tr> <td>'  ;
					  echo '<strong>Title:<a href=detail.php?bookid=' . $row->bookid . ';> '.stripslashes(htmlspecialchars($row->title)). '</strong></a><br />';
					  echo '</td></tr>';
					  echo '<tr> <td>';	  
					  echo '<strong>Relevance:'. number_format($row->score, 1) ;
					  echo '</strong></td></tr>';
					  echo '<tr> <td>';
					  echo '<strong>Author(s): </strong> ' . stripslashes(htmlspecialchars(one_wordwrap($row->author,30))). '<br />';
					  echo '</td></tr>';
					  if (strcmp(trim($row->title_periodical),"") && isset($row->title_periodical))
						{
							echo '<tr> <td>';
							echo '<strong>Periodical&nbsp;&nbsp; : </strong> '.stripslashes(htmlspecialchars(one_wordwrap($row->title_periodical,30))). '<br />';
							echo '</td></tr>';
						}
					  if (strcmp(trim($row->title_publisher),"") && isset($row->title_publisher))
						{
							echo '<tr> <td>';
							echo '<strong>Publisher: </strong> '.stripslashes(htmlspecialchars(one_wordwrap($row->publisher,30))). '<br />';
							echo '</td></tr>';
						}
					  if (strcmp(trim($dt_published->date_published),"") && isset($dt_published->date_published))
						{
							echo '<tr> <td>';
							echo '<strong>Date Published: </strong> '.stripslashes(htmlspecialchars(one_wordwrap($dt_published->date_published,30))). '<br />';
							echo '</td></tr>';
						}
					  if (strcmp(trim($dt_published->url_source),"") && isset($dt_published->url_source))
						{
							echo '<tr> <td>';
							echo '<strong>URL Source : </strong> <a href='.stripslashes(htmlspecialchars($dt_published->url_source)).' target="_blank">' . stripslashes(htmlspecialchars(wordwrap($dt_published->url_source,30,"\n",true))). '<br />';
							echo '</td></tr>';
						}
					  echo '<tr> <td>';
					  echo '<table width=95%><tr><td>';	
					  echo '<p align="justify">' . '<strong> Abstract: </strong> ';  
					  echo stripslashes($row->abstract).'</p>';
					  echo '</td></tr></table>';
					  echo '</td></tr>';
					  if (strcmp(trim($dt_published->file),"") && isset($dt_published->file))
						{
							echo '<tr> <td>';			 
							echo '<strong>File: </strong>';
							print ("<a href=./docs/".$dt_published->file." >");
							print($dt_published->file);
							echo '</td></tr>';
							print ("</a>");
							print("&nbsp;");
							print ("</td>");
						}
					  if ($_SESSION['edit_keyword'] == true)
						{
							echo '<tr> <td align="center">';
							echo '<a href="nanoentry.php?bookid=' . $row->bookid.'"> Edit </a>';
							echo '&nbsp;';
							if ($_SESSION['edit'] == true)
								{
									$tst = "return confirm('Are you sure you want to delete')";
									echo '<a href="index.php?delete=' . $row->bookid.'" onClick="' . $tst . '"> Delete </a>';
								}
							echo '</td></tr>';
						}			  			
					  echo '<tr> <td>';	  
		 			echo '<hr size="1" />';
		  			echo '</td></tr>';		  			
					echo '</table>';
					}
			?>
      </td>
      <td valign="top"> <table valign="top" border="1" bgcolor="#DBDBDB" cellspacing="2" cellpadding="6" width=100% >
          <td align=center> <strong>Popular Search Terms</strong><br/> 
            <?php   
				gen_tagClouds();
			?>
          </td>
        </table></td>
    </table>
</div>
<?php
	echo '<table align="center">';
	echo '<tr>';
	/*Display links on the bottom of the page*/
	$links = $nav->getlinks("sides", "on");
   	for ($y = 0; $y < count($links); $y++)
	{
		/*To present result how many data are available on page*/
		if ($row == 0)	
		{
			$Firstrow=$row+'1';
		}
		else
		{
			$Firstrow=($row )*'10';
		}
		if($row == 0)
		{
			if ($TotalCount2<'10')
			{
				$Lastrow=$TotalCount2;
			}
			else
			{
			    $Lastrow=($row+1)*10;
			}
		}
		else
		{
		  if($row == (integer)($TotalCount2/10))
			{
				$Lastrow=$TotalCount2;
			}
			else
			{									
				$Lastrow=($row+1)*10;
			}	
		}
		
		if ($y/2 == 0)
		{	
		  echo "<td>";
		}
		else
		{
			echo " <strong>" . $Firstrow . ' to &nbsp;'.$Lastrow .' of &nbsp;'.$TotalCount2 ."</strong>&nbsp;";
			
			echo  "<td align='right' >" ;
		}
			
			echo $links[$y] . "&nbsp;&nbsp; " ;
			
	 }
		echo'</tr></table>';
	?>
				
<script type="text/javascript">
			var options = {
				script:"suggest_db.php?json=true&",
				varname:"input",
				json:true,
				callback: function (obj) { document.getElementById('testid').value = obj.id; }
			};
			var as_json = new AutoSuggest('testinput', options);
		
		
			var options_xml = {
				script:"suggest_db.php?",
				varname:"input"
			};
			var as_xml = new AutoSuggest('words', options_xml);
</script>
		
<div id="footer"> 
  <?php
		// this is a commom footer file 
		include("Footer.php");
	?>
</div>
<!-- Start of StatCounter Code -->
<script type="text/javascript" language="javascript">
<!-- 
var sc_project=2559837; 
var sc_invisible=0; 
var sc_partition=24; 
var sc_security="7d077772"; 
//-->
</script>
<script type="text/javascript" language="javascript" src="http://www.statcounter.com/counter/counter.js"></script>
<noscript>
<a href="http://www.statcounter.com/" target="_blank"><img  src="http://c25.statcounter.com/counter.php?sc_project=2559837&java=0&security=7d077772&invisible=0" alt="blog stats" border="0"></a> 
</noscript>
<!-- End of StatCounter Code -->
</div>
</body>
</html>