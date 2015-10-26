<?php
function searchForm()
	{
	  // Re-usable form				  
	  // variables setup for the form.
	  $normal="";
	  $boolean="";
	  $searchwords = (isset($_GET['words']) ?  htmlspecialchars(stripslashes($_REQUEST['words'])) : '');
	  
	  	  if (isset($_GET['mode'])) {
	  		$normal = (($_GET['mode'] == 'normal') ? ' selected="selected"' : '' );
	  		$boolean = (($_GET['mode'] == 'boolean') ? ' selected="selected"' : '' );
			$tags = (($_GET['mode'] == 'tag') ? 'selected="selected"':'');
	  } 	
		   echo '<form name="search" method="get" action="'.$_SERVER['PHP_SELF'].'">';
		   echo '<input type="hidden" name="cmd" value="search" />';
				  echo'<table border=1 width=100% bordercolorlight="#DBDBDB"  cellpadding="0"  cellspacing="0" 	>';
					  echo '<tr > ';
					  echo '<td width=20% bgcolor="#DBDBDB" ><a href="./asearch.php" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Advanced Search</font></a><br><a href="http://ethics.iit.edu/index1.php/Programs/NanoEthicsBank" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">About the NEB </a>';
					  echo '<td  width=45% align=center bgcolor="#FFFFFF">';
					  echo '<table bgcolor="#FFFFFF"><tr><td align=left>';
					  echo '<strong> Search : &nbsp;</strong>'; 
					  echo '<input type="text" name="words" id="words" value="" style="width:250px" /> ';
					  echo '<input type="submit" value="Search" /> <a href="genhelp.htm" onClick="return popup(this)" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;"> Help </a></td></tr>';
					  echo '<tr><td align=left>';
					  echo '<strong> Mode &nbsp;&nbsp; : &nbsp;</strong><select name="mode" id="mode" onChange="lookMode(window.document.search.mode.options[selectedIndex].text);">
							<option value="normal"'.$normal.'> Normal</option>
							<option value="boolean"'.$boolean.'>Boolean</option>					
							</select> <a name="help" id="mydiv" href="help.htm" onClick="return popup(this)" style="display:none ; position:absolute; top: 185px; left: 220px; width: 30px;"> Help </a>'; 
					  echo '<br>';
					  echo  '</td></tr></table>';
					  echo '</td>';
					  
					// to check if user has logged in   
					if ($_SESSION['edit_keyword'] == true)
					{
						echo '<td align="right"  width="14%"   bgcolor="#DBDBDB"><br><a href="http://ethics.iit.edu/askalibrarian.php" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Ask a Librarian </a>
							  <br><a href="logout.php" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Logout </a><br><br></td>';
					}
					else
					{
						echo '<td align="right"  width="14%"   bgcolor="#DBDBDB"><br><a href="http://ethics.iit.edu/askalibrarian.php" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Ask a Librarian </a><br>
					  	  	  <a href="./login.php" style=" font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">Login for User Tags</a><br><br></td>';
					}
					
					
					echo '</tr>';
				  echo '</table>';
		echo '</form>';
	}

	// Create the navigation switch
	  $cmd = (isset($_GET['cmd']) ? $_GET['cmd'] : '');
      $countrows = '0' ;
      switch($cmd)
	  {
		  default:
		  	$sql = "SELECT *  FROM bank";
		  	searchForm();
		  
		 	 break;
		/*  */	
		  case "search":
		  	searchForm();
		 	 echo '<br>';
		 	 $searchstring = mysql_escape_string($_GET['words']);
			switch($_GET['mode'])
			{
			  /* Normal Mode */
			  case "normal":
				  if ($searchstring!='')
					 {
						 $sql = "SELECT bookid, title, author, title_periodical, publisher, volume, abstract, index_terms, keywords,
						   MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
						   AGAINST ('$searchstring') AS score FROM bank 
						   WHERE MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
						   AGAINST ('$searchstring') ORDER BY score DESC";
					}
				 else
					{
						$sql="select * from bank";
					}
				  
				 $result=mysql_query($sql);
				 $rows = mysql_num_rows($result);
				 if($rows > 0)
				  {
					 	

				  }
				  break;
			  /* Boolean Mode */
			  case "boolean":
				  if($searchstring!='')
					  {	 
					   $sql = "SELECT bookid, title, author, title_periodical, publisher, volume, abstract, index_terms, keywords, 
						   MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
						   AGAINST ('$searchstring' IN BOOLEAN MODE) AS score FROM bank 
						   WHERE MATCH(title, author, title_periodical, publisher, volume, issue, abstract, index_terms, keywords) 
	
						   AGAINST ('$searchstring' IN BOOLEAN MODE) ORDER BY score DESC";
				 	}
				 else
				 	{
						$sql="select * from bank";
					 }    
					
				$result=mysql_query($sql);
				$rows = mysql_num_rows($result);
				
				if($rows > 0)
					{

					}
				 break;
				
			}
			break;
		}
?>