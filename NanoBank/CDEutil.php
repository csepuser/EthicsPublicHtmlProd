<?php
	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate");
	$xmlResponse = "<?xml version='1.0' encoding='ISO-8859-1'?>";
	$xmlMessage="";
	$con=Null;
	$result=TRUE;
	function getscriptname()
	{
		echo __FILE__;
	}

	function printxmlResponse($logname)
	{
		global $HTTP_RAW_POST_DATA, $xmlResponse, $xmlMessage, $result, $con;

		echo $xmlResponse;
		if ($xmlMessage != "")
		{
			$xmlMessage = "<message>" . $xmlMessage . "</message>";
			echo $xmlMessage;
		}
		
		$fp = fopen("./Log/".$logname."Response.xml", "w+");
		fwrite($fp, $xmlResponse);
		fwrite($fp, $xmlMessage);
		fclose($fp);
	}

	function printxmlRequest($logname)
	{
		global $HTTP_RAW_POST_DATA, $xmlDoc, $xmlResponse, $xmlMessage, $result, $con;

		$fp = fopen("./Log/".$logname."Request.xml", "w+");
		fwrite($fp, $HTTP_RAW_POST_DATA);
		fclose($fp);
		$xmlDoc = domxml_open_file("./Log/".$logname."Request.xml");
	}

	//connects to the database as root???
	function dbConnect()
	{
		global $HTTP_RAW_POST_DATA, $xmlDoc, $xmlResponse, $xmlMessage, $result, $con;
		
		include("./db.php");
		$con = mysql_connect($dbh,$user,$pass);
		
		if (!$con)
		{
			$xmlMessage .= "<info> DBConnection not established </info>";
			return FALSE;
		}
		else
		{
			mysql_select_db("$db");
			return TRUE;
		}

	}

	//closes the conneciton to the database
	function dbClose()
	{
		global $HTTP_RAW_POST_DATA, $xmlDoc, $xmlResponse, $xmlMessage, $result, $con;
		mysql_close($con);
		return TRUE;
	}
?>