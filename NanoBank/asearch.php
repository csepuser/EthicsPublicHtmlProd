<?php
	session_start();
	include("db.php");
	
	$link=mysql_connect($dbh,$user,$pass);
	if( !link)
        die ("Couldnt connect to MySql");
	mysql_select_db("$db");
?>

<?php 
	/* Inlcude the navigation library */
	include("./navbar.php");

	$nav = new navbar;
	/* Number of rows to display */
	$nav->numrowsperpage = 10;
?>
<SCRIPT TYPE="text/javascript">

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
</script>
<?php
/*General function for creating the selection list*/

	
/**
 * This function fetches index_terms from the table and adds it into an array.
 */
 	function getIndexTermsList()
	{
		$sql_index_query = "Select DISTINCT index_terms from bank where index_terms!=''";

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
					if (array_search(trim($token),$array_index) > -1)
					{
					}
					else
					{
						array_push($array_index,trim($token));
					}
				}
					
				$token = trim(strtok(";"));
			}
		}
		rsort($array_index);
		$array_index=array_unique($array_index);
		return $array_index;
	}
?>
<?php
	function getPeriodicalList()
	{
		$sql_index_query = "Select DISTINCT title_periodical from bank where title_periodical!=''";

		include("./db.php");
		$link=mysql_connect($dbh,$user,$pass);
			if( !link)
        die ("Couldnt connect to MySql");
		mysql_select_db("$db");
		
		$result_periodical = mysql_query($sql_index_query, $link) or die(mysql_error());
		
		$array_index = array();
		while($row_index = mysql_fetch_object($result_periodical))
		{
			$row_data = $row_index->title_periodical;
             
			 $token = trim(strtok($row_data,";"));
			while ($token != false)
			{
				if (strcasecmp($token,'""') != 0)
				{
					if (array_search(trim($token),$array_index) > -1)
					{
					}
					else
					{
						array_push($array_index,trim($token));
					}
				}
					
				$token = trim(strtok(";"));
			}
		}
		rsort($array_index);
		$array_index=array_unique($array_index);
		return $array_index;
	}
?>

<?php
  function getDateList()
	{
		$sql_index_query = "Select DISTINCT  year_published from details where year_published!=''";

		include("./db.php");
		$link=mysql_connect($dbh,$user,$pass);
			if( !link)
        die ("Couldnt connect to MySql");
		mysql_select_db("$db");
		
		$result_date = mysql_query($sql_index_query, $link) or die(mysql_error());
		
		$array_date = array();
		while($row_date = mysql_fetch_object($result_date))
		{
			$row_data = $row_date->year_published;
			$token = trim(strtok($row_data,";"));
			while ($token != false)
			{
				if (strcasecmp($token,'""') != 0)
				{
					if (array_search(trim($token),$array_date) > 0)
					{
					}
					else
					{
						array_push($array_date,trim($token));
					}
				}
					
				$token = trim(strtok(";"));
			}
		}
		rsort($array_date);
		//array_unique($array_index);
		return $array_date;
	}
?>

<?php
/**
 * This function builds the query for Advance searching the database and initially the search is null
 * and so displays all the records.
 **/
	function buildAdvanceSearchQuery()
	{
		$flag_adv  = false;
		
		if (isset($_GET['searchDate'])&& trim($_GET['searchDate'])!=0)
		{
			$query = "SELECT * FROM bank , details where bank.bookid = details.bookid AND ";
		}
		else
		{
			$query = "SELECT * FROM bank where ";
		
		}
		if (strcmp(trim($_GET['searchTitle']),"") != 0)
		{
				$query .= "`title` LIKE '%" . trim($_GET['searchTitle']) . "%'";
				$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchAuthor']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
		    	$author = trim($_GET['searchAuthor']);
				$query .= " ( ";
				$tok = strtok($author, " \n\t");
				do
				{
					$query .= " `author` LIKE '%" . $tok . "%'";
					$tok = strtok(" \n\t");
					if ($tok !== false)
						$query .= "OR ";
					
				}
				while($tok !== false);
				$query .= " ) ";
				$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchAuthorCombine']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				$query .= "`author` LIKE '%" . trim($_GET['searchAuthorCombine']) . "%'";
				$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchPublisher']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				$query .= "`publisher` LIKE '%" . trim($_GET['searchPublisher']) . "%'";
				$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchDate']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				$query .= "`year_published` LIKE '%" . trim($_GET['searchDate']) . "%'";
		    	$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchKeywords']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				
				$keywords = trim($_GET['searchKeywords']);
				$tok = strtok($keywords, " \n\t");
				do
				{
					$query .= "`keywords` LIKE '%" . $tok . "%'";
					$tok = strtok(" \n\t");
					if ($tok !== false)
						$query .= "OR ";
				}
				while($tok !== false);	
				$flag_adv = true;
		}
			
		if (strcmp(trim($_GET['searchIndex']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				$query .= " bank.index_terms LIKE '%" . trim($_GET['searchIndex']) . "%'";
				$flag_adv = true;
		}
		if (strcmp(trim($_GET['searchPeriodical']),"") != 0)
		{
			if ($flag_adv == true)
				$query .= " AND ";
				$query .= "`title_periodical` LIKE '%" . trim($_GET['searchPeriodical']) . "%'";
				$flag_adv = true;
		}
		if ($flag_adv == false)
		{
			$query .= "`title` LIKE '%" . $tok . "%' OR `author` LIKE '%" . $tok . "%' OR `publisher` LIKE '%" . $tok . "%' ";
		}
		return $query;
	}
?>

<html>
	<head>
	<title> Nano Bank - Advance Search</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="stylesneb_1006.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="favicon.ico" >
	</head> 

<body>
	<div id="container">
		
  <div id="header"> <img id="neb_logo" src="Nanoheader8.jpg"/> </div>
       	<div id="top_nav_container">
        		<ul>
		   			  <li><a href="http://ethics.iit.edu">Home</a> &gt;&gt;&nbsp;</li>
					  <li><a href="../NanoEthicsBank/">NanoEthicsBank</a> &gt;&gt;&nbsp;</li>
                      <li><a>AdvancedSearch</a></li>
			    </ul>
			<div style="clear:both;"></div>
        </div>
    <br>    
    
        <form action="asearch.php" method="get" name="Search" id="Search">
            
          <table width="100%" border="0">
				<tr>
				  <td width="24%"><strong> Search Title </strong>: &nbsp;</td>
				  <td width="24%"><input name="searchTitle" type="text" maxlength="100" value="<? echo trim($_GET['searchTitle'])?>"></td>
				  <td width="28%"><strong>Search Publisher </strong>:</td>
				  <td width="24%"><input name="searchPublisher" type="text" maxlength="100" value="<? echo trim($_GET['searchPublisher'])?>"></td>
				</tr>
				<tr>
				  <td width="24%"><strong> Search Author </strong>: &nbsp; </td>
				  <?php
					  if (isset($_GET['searchAuthorCombine']))
							{
				  ?>
					  <td width="24%"><input name="searchAuthor" type="text" maxlength="100" value="<? echo trim($_GET['searchAuthorCombine'])?>"></td>
				  <?php
							}
							else
							{
				  ?>		  
					  <td width="24%"><input name="searchAuthor" type="text" maxlength="100" value="<? echo trim($_GET['searchAuthor'])?>"></td>
				  <?php
							}
				  ?>		  	
				  <td width="28%"><strong>Search User Tags</strong>:</td>
				  <td width="24%"><input name="searchKeywords" type="text" maxlength="100" value="<? echo trim($_GET['searchKeywords'])?>"></td>
				  <td><?  echo '<a href="advhelp.html" onClick="return popup(this)"> Help </a> '?></td>
				</tr>
				<tr>
				  <td width="24%"><strong> Search Date </strong>: </td>
				  <td width="24%"><select name="searchDate" style="width: 100px" size="1">
					   <option value="<? echo trim($_GET['searchDate'])?>"> <? echo trim($_GET['searchDate'])?></option>
					   <option value=""><option>
					   <?php
								 $index_list = getDateList();
								 $list_size = sizeof($index_list);
								 while ($list_size != 0)
								  {
									  $list_size--;
					   ?>
					   <option value=<?php echo '"' . $index_list[$list_size] . '"'; ?>> <?php echo $index_list[$list_size]; ?> </option>
					   <?php
								  }
					   ?>
					   </select>
					   </td>
				  <td width="28%"><strong> Subject </strong>:</td>
				  <td width="24%"><select name="searchIndex" style="width: 150px" size="1">				  
					  
					  <option value="<? echo trim($_GET['searchIndex'])?>"> <? echo trim($_GET['searchIndex'])?></option>
					  <option value=""><option>
					  <?php
								  $index_list = getIndexTermsList();
								  $list_size = sizeof($index_list);								 
								  while ($list_size != 0)
								  {
									  $list_size--;
					  ?>
					  <option value=<?php echo '"' . $index_list[$list_size] . '"'; ?>> 
					  <?php echo $index_list[$list_size]; ?> </option>
					  <?php
								  }
					  ?>
					  </select>
					  </td>
				</tr>
				<tr>
					<td width="24%"></td>
					<td width="24%"></td>
					<td width="28%"><strong> Periodical Title </strong>:</td>
					<td width="24%"><select name="searchPeriodical" style="width: 150px" size="1">					  
					  <option value="<? echo trim($_GET['searchPeriodical'])?>"> <? echo trim($_GET['searchPeriodical'])?></option>
					  <option value=""><option>
					  <?php
								  $index_list = getPeriodicalList();
								  $list_size = sizeof($index_list);								  
								  while ($list_size != 0)
								  {
									  $list_size--;
					  ?>
					  <option value=<?php echo '"' . $index_list[$list_size] . '"'; ?>> 
					  <?php echo $index_list[$list_size]; ?> </option>
					  <?php
								  }
					  ?>
					  </select>
					  </td>				
				</tr>
				<tr> 
					 <td colspan="4" align="left">
					 <div align="center">
					  <input type="submit" value="      GO      ">
					 </div>
					 </td>
				</tr>
		 </table>
        </form>
      
    
	<?php  
    	$data = buildAdvanceSearchQuery();
		$result_id = $nav->execute($data, $link, "mysql");
      	$num_rows = mysql_num_rows($result_id);
    ?>
     <div id="breadcrumbs">
    <?php 
    	$links = $nav->getlinks("sides", "on");
        echo '<table width="98%" align="center">';
  		echo '<tr>';
    	for ($y = 0; $y < count($links); $y++)
        {
        	if ($y/2 == 0)
            	echo "<td align=\"left\">";
        	else
        		echo "<td align=\"right\">";
        		echo $links[$y] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        		echo "</td>";
        }
        echo '</tr>';
		echo '</table>';
    ?>
    </div>
    
    <div id="center">
        <?php
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
						echo "<td align=\"right\">"    ;
						echo $links[$y+1] .  "&nbsp;&nbsp;" ;
						echo " </td>";			
                }
            }
            else
            {
                for ($y = 0; $y <4; $y++)
                {
                    if ($y/2 == 0)
                        echo "<td align=\"right\">"  ;
                    else
                        echo "<td align=\"right\">"    ;
						echo $links[$y+1] .  "&nbsp;&nbsp;" ;                
						echo " </td>";
                    
                }	
            }            
                $links = $nav->getlinks("signs", "on");
            
             /*To count number of data on current page*/
                for ($y = 0; $y < count($links); $y++)
                {
                    if ($y/2 == 0)
                        echo "<td align=\"left\">"  ;
                    else
                        echo "<td align=\"right\">"    ;
						echo $links[$y] .  "&nbsp;&nbsp;" ;                
						echo " </td>";                   
                }
        ?>
    </div>
    <br>
    <br>
	<div id="content">
<?php
	for ($y = 0; $y < $num_rows; $y++)
	{
		$data = mysql_fetch_object($result_id);
		$bookid = $data->bookid;
		$title = $data->title;		
		$author = $data->author;
		$title_periodical = $data->title_periodical;
		$publisher = $data->publisher;		 
		$abstract = $data->abstract;
		
		$sql_date = "SELECT `date_published` , `url_source` FROM `details` WHERE `bookid`=" . $bookid;
		$dt_object = mysql_query($sql_date, $link);
		$dt_published = mysql_fetch_object($dt_object);
		
		  echo '<table width="100%" align="center">';
		  
		  echo '<tr> <td>';
		  echo '<strong>Title: <a href=detail.php?bookid=' . $bookid . ';> '.stripslashes(htmlspecialchars($title)). '</strong></a><br />';
		  echo '</td></tr>';
		  echo '<tr> <td>';
		  echo '<strong>Author(s): </strong> '.stripslashes(htmlspecialchars($author)). '<br />';
		  echo '</td></tr>';
		  if (strcmp(trim($title_periodical),"") && isset($title_periodical))
	  	  {
  	  		  echo '<tr> <td>';
			  echo '<strong>Periodical: </strong> '.stripslashes(htmlspecialchars($title_periodical)). '<br />';
			  echo '</td></tr>';
		  }
  		  if (strcmp(trim($publisher),"") && isset($publisher))
	  	  {
			echo '<tr> <td>';
		  	echo '<strong>Publisher: </strong> '.stripslashes(htmlspecialchars($publisher)). '<br />';
			echo '</td></tr>';
		  }
		  if (strcmp(trim($dt_published->date_published),"") && isset($dt_published->date_published))
	  	  {
  	  		echo '<tr> <td>';
      		echo '<strong>Date Published: </strong> '.stripslashes(htmlspecialchars($dt_published->date_published)). '<br />';
	  		echo '</td></tr>';
	  	  }
		  if (strcmp(trim($dt_published->url_source),"") && isset($dt_published->url_source))
	  	  {
		  	echo '<tr> <td>';
    	  	echo '<strong>URL Source: </strong> <a href=' . stripslashes(htmlspecialchars($dt_published->url_source)) .' target="_blank">' . stripslashes(htmlspecialchars($dt_published->url_source)). '<br />';
	  	  	echo '</td></tr>';
	  	  }
		  echo '<tr> <td>';	
		  echo '<p>' . '<strong> Abstract: </strong> '; 
		  echo stripslashes($abstract).'</p>';
		  echo '</td></tr>';
		  if ($_SESSION['edit_keyword'] == true)
	  	  {
			  echo '<tr> <td align="center">';
			  echo '<a href="nanoentry.php?bookid=' . $bookid.'"> Edit </a>';
			  echo '&nbsp;';
			  if ($_SESSION['edit'] == true)
		  	  {
	  		  	$tst = "return confirm('Are you sure you want to delete')";
			  	echo '<a href="index.php?delete=' . $bookid.'" onClick="' . $tst . '"> Delete </a>';
			  }
			  echo '</td></tr>';
		  }
		  echo '<tr> <td>';	  
		  echo '<hr size="1" />';
		  echo '</td></tr>';
	
		  echo '</table>';
    }
  ?>
</div>
    <br>
    <?php  
    	$links = $nav->getlinks("sides", "on");
    ?>

    <table width="100%">
      <tr>
    	<?php
    		for ($y = 0; $y < count($links); $y++)
    		{
    			if ($y/2 == 0)
    				echo "<td align=\"left\">";
    			else
    				echo "<td align=\"right\">";
    			echo $links[$y] . "&nbsp;&nbsp;";
    			echo "</td>";
    		}
    	?>
      </tr>
    </table>

    <br>
    <div id="footer"> 
    	<?php
		// this is a commom footer file 
		include("Footer.php");
	?>
    </div>
</div
></body>
</html>