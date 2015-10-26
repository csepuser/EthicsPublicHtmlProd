<?php


  $author= $_REQUEST['author'] ;
  $title = $_REQUEST['title'] ;
  $recipient = $_REQUEST['recipient'];
  $datey = $_REQUEST['datey'];		//date of the year
  $source = $_REQUEST['source']; 
  $search = $_REQUEST['search'];
  $minMonth = $_REQUEST['minMonth'];
  $maxMonth = $_REQUEST['maxMonth'];


print"<body>";
print"<div id=\"page\">";
print"<!--#include virtual=\"newlayout/header_wrapper.php\" -->";
print"  <div id=\"scroll\"></div>";

print"<div id=\"logo\">";
 print"       <h1>C<SPAN STYLE=\"color: #800000\">S</span><br>";
  print"      <SPAN STYLE=\"color: #800000\">E</span>P</h1>";
print"</div>";
	 print"<div id=\"topnavcontainer\">";
     print"<div id=\"banner\">";
	 print"              <h1><SPAN STYLE=\"color: #800000\">Center</span> for the <SPAN STYLE=\"color: #800000\">Study</span>";
	 print"             of <SPAN STYLE=\"color: #800000\">Ethics</span> in the <SPAN STYLE=\"color: #800000\">Professions</span> at";
     print"            <SPAN STYLE=\"color: #800000\">IIT</span></h1>";    
	 print"</div>";
     print"</ul>";
     print"</div>";

/////////////////$$$$$$$$$$$$$
//lets keep track of 
$andingStuff = false;

//lets do the logic for the radio button
$matchall_status = 'unchecked';
$matchsome_status = 'unchecked';

$selected_radio = $_POST['search'];

if ($selected_radio == 'matchall') 
{
$matchall_status = 'checked';
}
else if ($selected_radio == 'matchsome') 
{
$matchsome_status = 'checked';
}

//connect to the database
$link = mysql_connect("localhost","csep","march28");
  mysql_select_db("csep", $link);

//this  is for the match all option
if($matchall_some != 'checked')
{	
//we are going to formulate a query for each, and then merge!
  //formulate a query
   $query = "SELECT fileName FROM metadata WHERE";
  if($author != "")
  {
     $query .= " authors like '%";
	 $query .= $author;
	 $query .="%'";
	 $andingStuff = true;
  }

  if($title != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " subject like '%";
	 $query .= $title;
	 $query .="%'";
	 $andingStuff = true;
  }
  if($recipient != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " recipients like '%";
	 $query .= $recipient;
	 $query .="%'";
	 $andingStuff = true;
  }
  if($source != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " source like '%";
	 $query .= $source;
	 $query .="%'";
	 $andingStuff = true;
  }

  if($datey != "" || $minMonth != "" || $maxMonth != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
    if($dately != "")
    {
     $query .= " YEAR(daySent) = '";
	 $query .= $datey;
	 $query .="'";
	 $andingStuff = true;
    }
   if($minMonth != "" || $maxMonth != "")
  {
	if($minMonth == "99")
		$minMonth = "01";
	if($maxMonth == "99")
		$maxMonth = "12";
	if($dately != "")
		$query .=" and ";

        if($minMonth != "" )
	{
		$query .= " MONTH(daySent) <= '";
	        $query .= $minMonth;
         	$query .="'";
         	$andingStuff = true;

	} 
       if($minMonth != "" && $maxMonth != "")
 	{
		$query .=" and ";

	}

	if($maxMonth != "" )
        {
                $query .= " MONTH(daySent) >= '";
                 $query .= $minMonth;                
                $query .="'";
                $andingStuff = true;
        }

}
  }

   $query .= " limit 50; ";
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);
  echo $daysent; 

print("");
  print("");
    if($rows == 0)
	  print("Very sorry, but your search did not match any results");
  for($i = 0; $i < $rows; $i++)
   {
    $rowdata = mysql_fetch_array($result);
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
	$shortname = $rowdata["fileName"];	
    print("");
	print $i+1;
        print'.  ';
	print'<a href=';
	print$name;
	print$shortname;
	print'>';
	print$shortname;
	print'</a>';
	$newl = "\n\n";
	print'<pre>';
	
	
	echo $newl;
   }

}
else		//this is when it can match any
{
//we are going to formulate a query for each, and then merge!
  //formulate a query
   $query = "SELECT  fileName from metadata WHERE"; 
  if($author != "")
  {
     $query .= " authors like '%";
	 $query .= $author;
	 $query .="%'";
	 $andingStuff = true;
  }

  if($title != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " subject like '%";
	 $query .= $title;
	 $query .="%'";
	 $andingStuff = true;
  }
  if($recipient != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " recipients like '%";
	 $query .= $recipient;
	 $query .="%'";
	 $andingStuff = true;
  }
  if($source != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " source like '%";
	 $query .= $source;
	 $query .="%'";
	 $andingStuff = true;
  }

  if($datey != "")
  {
	  if($andingStuff == true)
		  $query .=" and ";
     $query .= " YEAR(daySent) = '";
	 $query .= $datey;
	 $query .="'";
	 $andingStuff = true;
  }
  if($datey != "" || $minMonth != "" || $maxMonth != "")
  {
          if($andingStuff == true)
                  $query .=" and ";
    if($dately != "")
    {
     $query .= " YEAR(daySent) = '";
         $query .= $datey;
         $query .="'";
         $andingStuff = true;
    }
   if($minMonth != "" || $maxMonth != "")
  {
        if($dately != "")
                $query .=" and ";

 if($minMonth == "99")
                $minMonth = "01";
        if($maxMonth == "99")
                $maxMonth = "12";
        
if($minMonth != "" )
        {
                $query .= " MONTH(daySent) <= '";
                 $query .= $minMonth;
                $query .="'";
                $andingStuff = true;

        }
       if($minMonth != "" && $maxMonth != "")
        {
                $query .=" and ";

        }

        if($maxMonth != "" )
        {
                $query .= " MONTH(daySent) >= '";
                 $query .= $minMonth;
                $query .="'";
                $andingStuff = true;

        }

}
  }

   $query .= " limit 50; ";
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);

  echo $daysent;

print("");
  print("");
  if($rows == 0)
	  print("Very sorry, but your search did not match any results");
 
 for($i = 0; $i < $rows; $i++)
   {
   $rowdata = mysql_fetch_array($result);
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
        $shortname = $rowdata["fileName"];
		print("");
        print'<pre>';
        print'<a href=';
        print$name;
        print$shortname;
        print'>';
        print$shortname;
        print'</a>';
        $newl = "\n\n";
        echo $newl;
 
}
$rows1 = $rows;
if($rows < 10)		//lets get some partial matches
{
  $query = "SELECT  fileName from metadata ";
  if($author != "")
  {
     $query .= " WHERE authors like '%";
         $query .= $author;
         $query .="%'";
         $andingStuff = true;
  }

  if($title != "")
  {
          if($andingStuff == true)
                  $query .=" or ";
     $query .= " subject like '%";
         $query .= $title;
         $query .="%'";
         $andingStuff = true;
  }
  if($recipient != "")
  {
          if($andingStuff == true)
                  $query .=" or ";
     $query .= " recipients like '%";
         $query .= $recipient;
         $query .="%'";
         $andingStuff = true;
  }
  if($source != "")
  {
          if($andingStuff == true)
                  $query .=" or ";
     $query .= " source like '%";
         $query .= $source;
         $query .="%'";
         $andingStuff = true;
  }

  if($datey != "")
  {
          if($andingStuff == true)
                  $query .=" or ";
     $query .= " YEAR(daySent) = '";
         $query .= $datey;
         $query .="'";
         $andingStuff = true;
  }
///////here
   $query .= " limit ";#
   $query .= 10-$rows1;
   $query .= "; ";
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);


 //  
  echo $daysent;

print("");
  print("");
  if($rows == 0)
          print("Very sorry, but your search did not match any results");

 for($i = 0; $i < $rows; $i++)
   {
    $rowdata = mysql_fetch_array($result);
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
   echo $name;
   echo $shortname;
        $shortname = $rowdata["fileName"];
    print("");
        print'<pre>';
        print'<a href=';
        print$name;
        print$shortname;
        print'>';       
        print'</a>';
        $newl = "\n\n";  
}
}
}
?>