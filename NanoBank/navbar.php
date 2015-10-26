<?php
/*
Below goes an example of how to use this class:
===============================================
<?php 
$nav = new navbar;
$nav->numrowsperpage = 3;
$sql = "SELECT * FROM links ";
$result = $nav->execute($sql, $db, "mysql");
$rows = mysql_num_rows($result);
for ($y = 0; $y < $rows; $y++) {
  $data = mysql_fetch_object($result);
  echo $data->url . "<br>\n";
}
echo "<hr>\n";
$links = $nav->getlinks("all", "on");
for ($y = 0; $y < count($links); $y++) {
  echo $links[$y] . "&nbsp;&nbsp;";
}
?>
*/

class navbar {
  // Default values for the navigation link bar
  var $numrowsperpage = 10;
  var $str_previous = "Previous ";
  var $str_next = "Next";
  var $str_Less = "<< ";
  var $str_Gretar = " >>";
  // Variables used internally
  var $file;
  var $total_records;
  
  // The next function runs the needed queries.
  // It needs to run the first time to get the total
  // number of rows returned, and the second one to
  // get the limited number of rows.
  //
  // $sql parameter :
  //  . the actual SQL query to be performed
  //
  // $db parameter :
  //  . the database connection link
  //
  // $type parameter :
  //  . "mysql" - uses mysql php functions
  //  . "pgsql" - uses pgsql php functions
  function execute($sql, $db, $type = "mysql") {
    global $total_records, $row, $numtoshow;

    $numtoshow = $this->numrowsperpage;
   
	if (!isset($_GET['row'])) $row = 0;
	else $row = $_GET['row'];
    $start = $row * $numtoshow;
    if ($type == "mysql") {
     // echo " the sql statement is --".$sql."and Db is --".$db;		
      $query_result = mysql_query($sql, $db);
      //$total_records = mysql_num_rows($query_result);
      $sql .= " LIMIT $start, $numtoshow";
      $query_result = mysql_query($sql, $db);
    } elseif ($type == "pgsql") {
      $query_result = pg_Exec($db, $sql);
      $total_records = pg_NumRows($query_result);
      $sql .= " LIMIT $numtoshow, $start";
      $query_result = pg_Exec($db, $sql);
    }
    return $query_result;
  }

  // This function creates a string that is going to be
  // added to the url string for the navigation links.
  // This is specially important to have dynamic links,
  // so if you want to add extra options to the queries,
  // the class is going to add it to the navigation links
  // dynamically.
  function build_geturl()
  {
    global $REQUEST_URI, $REQUEST_METHOD, $HTTP_GET_VARS, $HTTP_POST_VARS;

    //list($fullfile, $voided) = explode("?", $REQUEST_URI);
	$fullfile = explode("?", $REQUEST_URI);
	//list($fullfile, $voided) = explode("?", $_SERVER['QUERY_STRING']);
    $this->file = $fullfile;
    $cgi = $REQUEST_METHOD == 'GET' ? $HTTP_GET_VARS : $HTTP_POST_VARS;
    reset ($cgi);
	$query_string= " ";
    while (list($key, $value) = each($cgi)) {
      if ($key != "row")
        $query_string = "&" . $key . "=" . $value;
    }
    return $query_string;
  }
/*--------------------------------------------------Original----------------------*/
  // This function creates an array of all the links for the
  // navigation bar. This is useful since it is completely
  // independent from the layout or design of the page.
  // The function returns the array of navigation links to the
  // caller php script, so it can build the layout with the
  // navigation links content available.
  //
  // $option parameter (default to "all") :
  //  . "all"   - return every navigation link
  //  . "pages" - return only the page numbering links
  //  . "sides" - return only the 'Next' and / or 'Previous' links
  //
  // $show_blank parameter (default to "off") :
  //  . "off" - don't show the "Next" or "Previous" when it is not needed
  //  . "on"  - show the "Next" or "Previous" strings as plain text when it is not needed
  /*function getlinks($option = "all", $show_blank = "off") 
  {
    global $total_records, $row, $numtoshow;

    if (!isset($_GET['row'])) $row = 0;
	else $row = $_GET['row'];

    $extra_vars = $this->build_geturl();
	
	if (!isset($_GET['cmd'])) $cmd = 0;
	else
	{
	  $cmd = $_GET['cmd'];
	  $extra_vars = $extra_vars . "&cmd=" . $cmd;
	}
	if (!isset($_GET['words'])) $words = 0;
	else
	{
//	  $words = htmlspecialchars(stripslashes($_REQUEST['words']));
	  $words = urlencode(stripslashes($_REQUEST['words']));
//	  echo $words;
 	  $extra_vars = $extra_vars . "&words=" . $words;
	} 
	if (!isset($_GET['mode'])) $mode = 0;
	else
	{
	  $mode = $_GET['mode'];
	  $extra_vars = $extra_vars . "&mode=" . $mode;
	}
	if (!isset($_GET['searchTitle'])) $title = 0;
	else
	{
	  $title = $_GET['searchTitle'];
	  $extra_vars = $extra_vars . "&searchTitle=" . $title;
	}
	if (!isset($_GET['searchPublisher'])) $publisher = 0;
	else
	{
	  $publisher = $_GET['searchPublisher'];
	  	  $extra_vars = $extra_vars . "&searchPublisher=" . $publisher;
	}
	if (!isset($_GET['searchAuthor'])) $author = 0;
	else
	{
	  $author = $_GET['searchAuthor'];
	  	  $extra_vars = $extra_vars . "&searchAuthor=" . $author;
	}
	if (!isset($_GET['searchIndex'])) $index = 0;
	else
	{
	  $index = $_GET['searchIndex'];
	  	  $extra_vars = $extra_vars . "&searchIndex=" . $index;
	}
    if (!isset($_GET['searchDate'])) $date = 0;
	else
	{
	  $date = $_GET['searchDate'];
	  	  $extra_vars = $extra_vars . "&searchDate=" . $date;
	}


	
    $file = $this->file;
    $number_of_pages = ceil($total_records / $numtoshow);
    $subscript = 0;
    for ($current = 0; $current < $number_of_pages; $current++) 
	{
      if ((($option == "all") || ($option == "sides")) && ($current == 0)) 
	  {
        if ($row != 0)
          $array[0] = '<A HREF="' . $file . '?row=' . ($row - 1) . $extra_vars . '">' . $this->str_previous . '</A>';
        elseif (($row == 0) && ($show_blank == "on"))
          $array[0] = $this->str_previous;
      }

      if (($option == "all") || ($option == "pages")) 
	  {
        if ($row == $current)
          $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
        else
          $array[++$subscript] = '<A HREF="' . $file . '?row=' . $current . $extra_vars . '">' . ($current + 1) . '</A>';
      }

      if ((($option == "all") || ($option == "sides")) && ($current == ($number_of_pages - 1))) 
	  {
        if ($row != ($number_of_pages - 1))
          $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($row + 1) . $extra_vars . '">' . $this->str_next . '</A>';
        elseif (($row == ($number_of_pages - 1)) && ($show_blank == "on"))
          $array[++$subscript] = $this->str_next;
      }
    }
    return $array;
  }*/
  /*-----------------------------------------------------------End of the Original-----------------------------------*/
  
  
  
  
  
  
  
  
  
   // This function creates an array of all the links for the
  // navigation bar. This is useful since it is completely
  // independent from the layout or design of the page.
  // The function returns the array of navigation links to the
  // caller php script, so it can build the layout with the
  // navigation links content available.
  //
  // $option parameter (default to "all") :
  //  . "all"   - return every navigation link
  //  . "pages" - return only the page numbering links
  //  . "sides" - return only the 'Next' and / or 'Previous' links
  //  . "Signs" -Gretar and Less than links
  
  // $show_blank parameter (default to "off") :
  //  . "off" - don't show the "Next" or "Previous" when it is not needed
  //  . "on"  - show the "Next" or "Previous" strings as plain text when it is not needed
 	function getlinks($option = "all", $show_blank = "off") 
  	{
    global $total_records, $row, $numtoshow;

	
    if (!isset($_GET['row'])) $row = 0;
	else $row = $_GET['row'];

    $extra_vars = $this->build_geturl();
	
	if (!isset($_GET['cmd'])) $cmd = 0;
	else
	{
	  $cmd = $_GET['cmd'];
	  $extra_vars = $extra_vars . "&cmd=" . $cmd;
	}
	if (!isset($_GET['words'])) $words = 0;
	else
	{
//	  $words = htmlspecialchars(stripslashes($_REQUEST['words']));
	  $words = urlencode(stripslashes($_REQUEST['words']));
//	  echo $words;
 	  $extra_vars = $extra_vars . "&words=" . $words;
	} 
	if (!isset($_GET['mode'])) $mode = 0;
	else
	{
	  $mode = $_GET['mode'];
	  $extra_vars = $extra_vars . "&mode=" . $mode;
	}
	if (!isset($_GET['searchTitle'])) $title = 0;
	else
	{
	  $title = $_GET['searchTitle'];
	  $extra_vars = $extra_vars . "&searchTitle=" . $title;
	}
	if (!isset($_GET['searchPublisher'])) $publisher = 0;
	else
	{
	  $publisher = $_GET['searchPublisher'];
	  	  $extra_vars = $extra_vars . "&searchPublisher=" . $publisher;
	}
	if (!isset($_GET['searchAuthor'])) $author = 0;
	else
	{
	  $author = $_GET['searchAuthor'];
	  	  $extra_vars = $extra_vars . "&searchAuthor=" . $author;
	}
	if (!isset($_GET['searchIndex'])) $index = 0;
	else
	{
	  $index = $_GET['searchIndex'];
	  	  $extra_vars = $extra_vars . "&searchIndex=" . $index;
	}
    if (!isset($_GET['searchDate'])) $date = 0;
	else
	{
	  $date = $_GET['searchDate'];
	  	  $extra_vars = $extra_vars . "&searchDate=" . $date;
	}
    if(!isset($_GET['searchPeriodical'])) $periodical=0;
    else
    {
      $periodical=$_GET['searchPeriodical'];
        $extra_vars=$extra_vars . "&searchPeriodical=" . $periodical;
    }  


	
    //$file = $this->file;
    $file=$_SERVER['PHP_SELF'];
    $number_of_pages = ceil($total_records / $numtoshow);
	
    $subscript = 0;
	
    for ($current = 0; $current < $number_of_pages; $current++) 
	{
		
			if ((($option == "all") || ($option == "sides")) && ($current == 0)) 
			  {
				if ($row != 0)
				  $array[0] = '<A HREF="' . $file . '?row=' . ($row - 1) . $extra_vars . '">' . $this->str_previous . '</A>';
				elseif (($row == 0) && ($show_blank == "on"))
				  $array[0] = $this->str_previous;
			  }
		
			if ((($option == "all") || ($option == "signs")) && ($current == 0)) 
			  {
				if ($row != 0)
				  $array[0] = '<A HREF="' . $file . '?row=' . ($row - 1) . $extra_vars . '">' . $this->str_Less . '</A>';
				elseif (($row == 0) && ($show_blank == "on"))
				  $array[0] = $this->str_Less;
			  }
		 
		   if (($option == "all") || ($option == "pages")) 
			  {
				/*if ($row == $current)
				  $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
				else
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . $current . $extra_vars . '">' . ($current + 1) . '</A>';*/
				if ($row == $current)
				  $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
				else
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . $current . $extra_vars . '">' . ($current + 1 ) . '</A>';				  
			  }
		
			
			   if ((($option == "all") || ($option == "sides")) && ($current == ($number_of_pages - 1))) 
			  {
				/*if ($row != ($number_of_pages - 1))
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($row + 1) . $extra_vars . '">' . $this->str_next . '</A>';
				elseif (($row == ($number_of_pages - 1)) && ($show_blank == "on"))
				  $array[++$subscript] = $this->str_next;*/
				if ($row != ($number_of_pages - 1))
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($row + 1) . $extra_vars . '">' . $this->str_next . '</A>';
				elseif (($row == ($number_of_pages - 1)) && ($show_blank == "on"))
				  $array[++$subscript] = $this->str_next;
			  }	
		   
		   	   if ((($option == "all") || ($option == "signs")) && ($current == ($number_of_pages - 1))) 
			  {
				/*if ($row != ($number_of_pages - 1))
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($row + 1) . $extra_vars . '">' . $this->str_next . '</A>';
				elseif (($row == ($number_of_pages - 1)) && ($show_blank == "on"))
				  $array[++$subscript] = $this->str_next;*/
				if ($row != ($number_of_pages - 1))
				  $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($row + 1) . $extra_vars . '">' . $this->str_Gretar . '</A>';
				elseif (($row == ($number_of_pages - 1)) && ($show_blank == "on"))
				  $array[++$subscript] = $this->str_Gretar;
			  }
	    }
    	return $array;
	  }
}
?>
