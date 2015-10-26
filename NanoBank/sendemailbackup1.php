<?php


  $author= $_REQUEST['author'] ;
  $title = $_REQUEST['title'] ;
  $recipient = $_REQUEST['recipient'];
  $datey = $_REQUEST['datey'];		//date of the year
  $source = $_REQUEST['source']; 
  $search = $_REQUEST['search'];

 # echo $_POST['author']; 
 # echo $_POST['title']; 
 # echo $_POST['recipient'];
 # echo $_POST['datey']; 
 # echo $_POST['source']; 


//lets keep track of 
$andingStuff = false;

//lets do the logic for the radio button
$matchall_status = 'unchecked';
$matchsome_status = 'unchecked';



$selected_radio = $_POST['search'];

if ($selected_radio == 'matchall') {
$matchall_status = 'checked';

}
else if ($selected_radio == 'matchsome') {
$matchsome_status = 'checked';

}
else
	{
	print("match none");
	}




//connect to the database
$link = mysql_connect("localhost","csep","march28");
  mysql_select_db("csep", $link);

//this  is for the match all option
if($matchall_status == 'checked')
{
	#print("IN THE MATCHALL /n");
//we are going to formulate a query for each, and then merge!
  //formulate a query
   $query = "SELECT fileName FROM metadata";
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
	// $query .= $source;
	 $query .="'";
	 $andingStuff = true;
  }

   $query .= " limit 10; ";
   #echo $query;
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);


 //   $rowdata = mysql_fetch_array($result);
   // $daySent=$rowdata["daySent"];
  #  $val = $rowdata["Num"];
  echo $daysent;
  #  print("");

print("");
  print("");
    if($rows == 0)
	  print("Very sorry, but your search did not match any results");
  for($i = 0; $i < $rows; $i++)
   {
    $rowdata = mysql_fetch_array($result);
   #$name.="http://hum.iit.edu:8080/aire/sea/2/"; 
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
   #$name+=$rowdata["fileName"];
   #echo $name;
   #echo $shortname;
	$shortname = $rowdata["fileName"];	
#	echo $name;
  #  $val = $rowdata["Num"];
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

#  print("
# Count is $rows");
}
else		//this is when it can match any
{
#print("IN THE MATCHSOME /n");
//we are going to formulate a query for each, and then merge!
  //formulate a query
   $query = "SELECT  fileName from metadata "; 
#$query .= " , fileName FROM metadata;";
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
	// $query .= $source;
	 $query .="'";
	 $andingStuff = true;
  }

   $query .= " limit 10; ";
   #echo $query;
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);


 //   $rowdata = mysql_fetch_array($result);
   // $daySent=$rowdata["daySent"];
  #  $val = $rowdata["Num"];
  echo $daysent;
  #  print("");

print("");
  print("");
  if($rows == 0)
	  print("Very sorry, but your search did not match any results");
 
 for($i = 0; $i < $rows; $i++)
   {
   $rowdata = mysql_fetch_array($result);
   #$name.="http://hum.iit.edu:8080/aire/sea/2/";
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
   #$name+=$rowdata["fileName"];
   #echo $rowdata;
   echo $name;
   echo $shortname;
        $shortname = $rowdata["fileName"];
       echo $shortname;
  #  $val = $rowdata["Num"];
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
#$query .= " , fileName FROM metadata;";
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
        // $query .= $source;
         $query .="'";
         $andingStuff = true;
  }
///////here
   $query .= " limit ";#
   $query .= 10-$rows1;
   $query .= "; ";
   #echo $query;
  $result = mysql_query($query,$link);
  $rows = mysql_num_rows($result);


 //   $rowdata = mysql_fetch_array($result);
   // $daySent=$rowdata["daySent"];
  #  $val = $rowdata["Num"];
  echo $daysent;
  #  print("");

print("");
  print("");
  if($rows == 0)
          print("Very sorry, but your search did not match any results");

 for($i = 0; $i < $rows; $i++)
   {
    $rowdata = mysql_fetch_array($result);
   #$name.="http://hum.iit.edu:8080/aire/sea/2/";
   $name="http://hum.iit.edu/~csep/NanoEthicsBank/2/";
   #$name+=$rowdata["fileName"];
   echo $name;
   echo $shortname;
        $shortname = $rowdata["fileName"];
#       echo $name;
  #  $val = $rowdata["Num"];
    print("");
        print'<pre>';
        print'<a href=';
        print$name;
        print$shortname;
        print'>';
        print$shortname;
        print'</a>';
        $newl = "\n\n";

   #}
}


}
#  print("
 #Count is $rows");
}
?>
