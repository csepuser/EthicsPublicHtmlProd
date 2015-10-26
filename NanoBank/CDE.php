<?php ob_start(); ?>
<?php
	session_start();
	include 'CDEutil.php';
	
	 parseXMLStr();

printxmlResponse('codes');

function parseXMLStr()
{
	global $HTTP_RAW_POST_DATA, $xmlResponse, $xmlMessage, $result, $con;
	
	if(dbConnect() == FALSE)
	{
		$xmlMessage .= "<status>Fail</status>";
		$xmlMessage .= "<info>Could not connect to the database</info>";
		return FALSE;
	}

	$fp = fopen("./Log/codes.xml", "w+");
	fwrite($fp, $HTTP_RAW_POST_DATA);
	fclose($fp);

	$xmldoc = domxml_open_file("./Log/codes.xml");
	$noderoot = $xmldoc->document_element();
	
	if($noderoot->tagname = "insert")
	{
		$childnodes = $noderoot->child_nodes();
		
		foreach ($childnodes as $value) 
		{
			if($value->tagname == "area")
				$area = $value->get_content();
			else if($value->tagname == "assoc_code")
				$assoc_code = $value->get_content();
			else if($value->tagname == "paper_code")
				$paper_code = $value->get_content();
			else if($value->tagname == "assoc_desc")
				$assoc_desc = $value->get_content();
			else if($value->tagname == "paper_desc")
				$paper_desc = $value->get_content();
			else if($value->tagname == "location")
				$location = $value->get_content();
		}
		if(dbOperations($area , $assoc_code , $paper_code , $assoc_desc , $paper_desc , $location) == FALSE)
		{
			$xmlMessage .= "<status>Fail</status>";
			$xmlMessage .= "<info>Registration failed, try registering again</info>";
			$result = FALSE;
		}
	}
	else
	{
		$xmlMessage .= "<status>Fail</status>";
		$xmlMessage .= "<info>Wrong XMLRequest Format</info>";
		$result = FALSE;
	}

	dbClose();
	return $result;
}

function dbOperations($area , $assoc_code , $paper_code , $assoc_desc , $paper_desc , $location)
{
	global $HTTP_RAW_POST_DATA, $xmlResponse, $xmlMessage, $result, $con;	
	$str = "'" . $area . "','" . $assoc_code . "','" . $paper_code . "','" . $assoc_desc . "','" . $paper_desc . "','" . $location . "'";
	$sql = "INSERT INTO codes VALUES(" . $str . ")";
	
	if(mysql_query($sql, $con)==1)
	{
		$xmlMessage .="<info>Operation successful : You are registered!</info>";
		return TRUE;
	}	
	else
	{
		$xmlMessage .="<info>Operation Failed!</info>";
		return FALSE;
	}	
}
?>