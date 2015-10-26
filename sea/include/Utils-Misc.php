<?php
	/**
	 * Utils-Misc.php - this file contains non-UI utility functions for the
	 * Application
	 *
	 * Functions in this file may be used throughout the Application.
	 * Almost all files in the system include this file.
	 *
	 * $Id: Utils-Misc.php,
	 */
	
	/**
	 * Check to see if there is a session initialized,
	 * and send to login if there isn't one.
	 *
	 * @param string $target the page the user was trying to go to
	 * @return integer user_id of the logged in user
	 */
	
	//include_once ("usersOnline.class.php");
	
	function SessionCheck($target='')
	{
		global $http_site_root;
		if (!($_SESSION['sessionUserId'] > 0))
		{
			if( strlen( $target ) > 0 )
			{
				echo "<script>location.href='$http_site_root"."Login.php?target=$target'</script>";
				exit( );
			}
			else
			{
				echo "<script>location.href='$http_site_root"."Login.php'</script>";
				exit( );
			}
		}
	}
	
	function delete($dir, $pattern = "*.*")
	{
		$deleted = false;
		$pattern = str_replace(array("\*","\?"), array(".*","."),
													preg_quote($pattern));
			if (substr($dir,-1) != "/") $dir.= "/";
			if (is_dir($dir)) {
			$d = opendir($dir);
				while ($file = readdir($d))
				{
					if (is_file($dir.$file) && ereg("^".$pattern."$", $file))
					{
						if (unlink($dir.$file))    $deleted[] = $file;
					}
				}
				closedir($d);
				return $deleted;
			}
			else return 0;
	}
	
	/**
	 * Return the filesize in human readable string
	 *
	 * @param  integer $file_size
	 * @return string  file size rounded and typed with size
	 */
	function pretty_filesize($file_size) {
		$a = array("B", "KB", "MB", "GB", "TB", "PB");
		$pos = 0;
	
		while ($file_size >= 1024) {
			$file_size /= 1024;
			$pos++;
		}
		return round($file_size,2)." ".$a[$pos];
	}
	
	/**
	 * Get the contents of the CSV file as an array
	 *
	 * @param  string  $file           path to the uploaded file
	 * @param  boolean $hasFieldNames  should we get the description list off
	 * 								   the first line
	 * @param  char    $delimiter      delimiter for the CSV file
	 * @param  char    $enclosure      are the fields enclosed in anything
	 * 								   (like quotes)
	 *
	 * @return array   $result        array in the form of rows with keys and values
	 *
	 * @todo to support MS Outlook import, revise the $keys array to rtrim,
	 * strtolower, and str_replace space with underscore
	 */
	function CSVtoArray($file, $hasFieldNames=false, $delimiter=',', $enclosure='')
	{
		$result_arr = Array();
	
		if (!substr_count($file,"http://"))
		{
			//urls don't have a filesize, so, don't check it.
			$size = filesize($file) +1;
		}
		$handle = fopen($file, 'r');
		if (!$handle)
		{
			echo "Unable to open file: $file \n";
			echo "Please correct this error.";
			exit;
		}
	
		if ($hasFieldNames) $keys = fgetcsv($handle, 4096, $delimiter);
	
		//trim,strtolower, and strreplace keys for Outlook support
		//create a temporary array to put things in
		$cleankeys = array();
		foreach ($keys as $key)
		{
			//munge the array key
			$key = str_replace(' ', '_', trim(strtolower($key)));
			$key =  preg_replace("/[-#\*.]/i",'', $key);
			//assign the munged key to the temp array
			$cleankeys[] = $key;
		}
		//copy the cleaned array to the $keys array
		$keys = $cleankeys;
	
		while ($row = fgetcsv($handle, 4096, $delimiter))
		{
			for($i = 0; $i < count($row); $i++)
			{
				if(array_key_exists($i, $keys))
				{
					$row[$keys[$i]] = $row[$i];
				}
			}
			$result_arr[] = $row;
		}
	
		fclose($handle);
	
		return $result_arr;
	
	} //end CSVtoArray fn
	
	/**
	 * Search for the var $name in $_SESSION, $_POST, $_GET,
	 * $_COOKIE, or $_SERVER and set it in provided var.
	 *
	 * example:
	 *    getGlobalVar('username',$username);
	 *  -- no quotes around last param!
	 *
	 * @param string $name variable to search for
	 * @param @$value value found to pass back
	 * @return boolean
	 *
	 * Returns FALSE if variable is not found.
	 * Returns TRUE if it is.
	 */
	function getGlobalVar( &$value, $name ) {
	
		if( isset($_SESSION[$name]) )
		{
			$value = $_SESSION[$name];
			return TRUE;
			break;
		}
		if( isset($_POST[$name]) )
		{
			$value = $_POST[$name];
			return TRUE;
			break;
		}
		if ( isset($_GET[$name]) )
		{
			$value = $_GET[$name];
			return TRUE;
			break;
		}
		if ( isset($_COOKIE[$name]) )
		{
			$value = $_COOKIE[$name];
			return TRUE;
			break;
		}
		if ( isset($_SERVER[$name]) )
		{
			$value = $_SERVER[$name];
			return TRUE;
			break;
		}
		return FALSE;
	}
	/* Function to generate random alphnumeric string */
	
	function get_rand_id($length)
	{
		if($length>0)
		{
			$rand_id="";
			for($i=1; $i<=$length; $i++)
			{
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1,36);
				$rand_id .= assign_rand_value($num);
			}
		}
		return $rand_id;
	}
	
	function assign_rand_value($num)
	{
	// accepts 1 - 36
		switch($num)
		{
			case "1":
			 $rand_value = "a";
			break;
			case "2":
			 $rand_value = "b";
			break;
			case "3":
			 $rand_value = "c";
			break;
			case "4":
			 $rand_value = "d";
			break;
			case "5":
			 $rand_value = "e";
			break;
			case "6":
			 $rand_value = "f";
			break;
			case "7":
			 $rand_value = "g";
			break;
			case "8":
			 $rand_value = "h";
			break;
			case "9":
			 $rand_value = "i";
			break;
			case "10":
			 $rand_value = "j";
			break;
			case "11":
			 $rand_value = "k";
			break;
			case "12":
			 $rand_value = "l";
			break;
			case "13":
			 $rand_value = "m";
			break;
			case "14":
			 $rand_value = "n";
			break;
			case "15":
			 $rand_value = "o";
			break;
			case "16":
			 $rand_value = "p";
			break;
			case "17":
			 $rand_value = "q";
			break;
			case "18":
			 $rand_value = "r";
			break;
			case "19":
			 $rand_value = "s";
			break;
			case "20":
			 $rand_value = "t";
			break;
			case "21":
			 $rand_value = "u";
			break;
			case "22":
			 $rand_value = "v";
			break;
			case "23":
			 $rand_value = "w";
			break;
			case "24":
			 $rand_value = "x";
			break;
			case "25":
			 $rand_value = "y";
			break;
			case "26":
			 $rand_value = "z";
			break;
			case "27":
			 $rand_value = "0";
			break;
			case "28":
			 $rand_value = "1";
			break;
			case "29":
			 $rand_value = "2";
			break;
			case "30":
			 $rand_value = "3";
			break;
			case "31":
			 $rand_value = "4";
			break;
			case "32":
			 $rand_value = "5";
			break;
			case "33":
			 $rand_value = "6";
			break;
			case "34":
			 $rand_value = "7";
			break;
			case "35":
			 $rand_value = "8";
			break;
			case "36":
			 $rand_value = "9";
			break;
		}
		return $rand_value;
	}

    /* Acces check for subtabs
     * Arguments :  Group ID, DBConnection Object, URL of subtab
     * Returns   :  Access mode of subtab for Group
     * 		    <w /r>  or <false> if Not Accesible to group
    */
	
    function AccessCheck( $con,  $groupId,  $subTabUrl )
    {
		$subTabUrl = eregi_replace( "Application1", "Application", $subTabUrl );
		if ( eregi( "(.*)(/Application.*)", $subTabUrl, $regs ) )
		{
			$subTabUrl = $regs[2];
		}
		//$con->debug = 1;
		$sqlSelectSubTabId = "" ;
		$sqlSelectSubTabId = "SELECT
					id
					FROM
					sub_tabs
					WHERE
					url =" . $con->qstr( $subTabUrl ,get_magic_quotes_gpc() );
		$rstSubTabId = $con->execute( $sqlSelectSubTabId );
	
		if ( $rstSubTabId && ! $rstSubTabId->EOF )
		{
			$sqlSelectAccessRight = "";
			$sqlSelectAccessRight = "SELECT
						accessRight
						FROM
						group_access
						WHERE
						subTabId = " .$rstSubTabId->fields['id'] ."
						AND
						groupId = " .$groupId  ;
			$rstAcessRight = $con->execute( $sqlSelectAccessRight );
			$rstSubTabId->close();
			
			if( $rstAcessRight  &&  !$rstAcessRight->EOF )
			{
			$rstAcessRight->close();
			return $rstAcessRight->fields['accessRight'] ;
			}
			else
			{
			return false;
			}
		}
    }

    /* Function for Hard Delete to Check Dependency
     * Arguments :  DBConnection Object, Table Name to Check with, Field Name, Value to be Compared
     * Returns   :  <1/0>  if <dependency exists/dependency does not exixts>
    */

    function Hard_Delete($con, $table, $field, $value)
    {
		$flag = 0;
		
		$sqlCheck = "SELECT
				*
				FROM
				$table
				WHERE
				$field = ".$con->qstr( $value, get_magic_quotes_gpc( ) );
		
		$rstCheck = $con->execute( $sqlCheck );
		
		if( $rstCheck && !$rstCheck->EOF )
		{
			$rstCheck->close();
			$flag = 1;
			
			return $flag;
		}
		else
		{
			return $flag;
		}
    }

    /* Function for Soft Delete to Check Dependency
     * Arguments :  DBConnection Object, Table Name to Check with, Field Name, Value to be Compared
     * Returns   :  <exists/notexists>  if <dependency exists/dependency does not exixts>
    */

    function Soft_Delete($con, $table, $field, $value)
    {
		$sqlCheck = "SELECT
				*
				FROM
				$table
				WHERE
				$field = ".$con->qstr( $value, get_magic_quotes_gpc( ) )." AND recordStatus = 'a' ";
		
		$rstCheck = $con->execute( $sqlCheck );
		
		$value = "exists";
		
		if( $rstCheck && !$rstCheck->EOF )
		{
			$rstCheck->close();
			return $value;
		}
		else
		{
			$value = "notexists";
			return $value;
		}
    }
	
    /* Function to find number of days, number of hours, number of minutes, number of seconds between
     * two timestamps
     * Arguments :  from timestamp to timestamp
     * Returns   :  number of days, hours, minutes and seconds seperated by tilde
     *
     * NOTE - PLEASE INCREMENT NUMBER OF DAYS BY ONE IN YOUR RESPECTIVE PHP PAGE FOR CORRECT DATE DIFFERENCE
     * ---------------------------------------------------------------------------------------------------
     *
    */
    function zen_date_diff($str_start, $str_end)
    {
        $str_start = strtotime($str_start); // The start date becomes a timestamp
        $str_end = strtotime($str_end); // The end date becomes a timestamp
		
        $nseconds = $str_end - $str_start; // Number of seconds between the two dates
        $ndays = round($nseconds / 86400); // One day has 86400 seconds
        $nseconds = $nseconds % 86400; // The remainder from the operation
        $nhours = round($nseconds / 3600); // One hour has 3600 seconds
        $nseconds = $nseconds % 3600;
        $nminutes = round($nseconds / 60); // One minute has 60 seconds, duh!
        $nseconds = $nseconds % 60;
		
        $value = $ndays.'~'.$nhours.'~'.$nminutes.'~'.$nseconds;
        return $value;
    }

    /* Function for getting subordinate designations
     * Arguments :  DBConnection Object, designation id
     * Returns   : <string>comma seaprated subordinate designation Ids</string>
    */
    function get_subordinate($con,$designationId)
    {
		$temp = array();
		$temp[0] = "";
		$strarray = array();
		array_push($strarray ,$user_id);
		$sql_get_users = "SELECT
					designationId
				FROM
					designation_hierarchy
				WHERE
					reportingDesignationId=".$designationId;
		$rst_user_id = $con->execute($sql_get_users);
		if($rst_user_id)
		{
			while(!$rst_user_id->EOF)
			{
			array_push($strarray ,$rst_user_id->fields[0]);
			array_push($strarray ,get_subordinate($con, $rst_user_id->fields[0]));
			$rst_user_id->movenext();
			}
			$rst_user_id->close();
			return implode(',',array_unique(explode(",",implode(",", array_diff($strarray,$temp)))));
		}
		else
		{
			array_push($strarray ,"");
			return implode(',',array_unique(explode(",",implode(",", array_diff($strarray,$temp)))));
		}
    }

    /* Function to convert date in the form of yyyy-mm-dd
     * Arguments :  date
     * Returns   : <string>hyphen seperated date in the form of yyyy-mm-dd</string>
    */
    function to_database($date)
    {
		$temp = explode('/',$date);
		$date = $temp[2].'-'.$temp[1].'-'.$temp[0];
	
		return $date;
    }

    /* Function to convert date in the form of dd/mm/yyyy
     * Arguments :  date
     * Returns   : <string>slash seperated date in the form of dd/mm/yyyy</string>
    */
    function from_database($date)
    {
		$temp = explode('-', $date);
		$date = $temp[2].'/'.$temp[1].'/'.$temp[0];
	
		return $date;
    }

    /* Export the recordset to an Excel file
     * Arguments :
     * 	$fileName : Name of the output file
     * 	$sheetName: Name of the output sheet
     * 	$rst: Output recordset
     * Returns   :
     * 	1 upon successful creation of the file
     * 	0 upon failure
    */
    function ExportToExcel ( $fileName, $sheetName, $rst )
    {
		$columnHeaders = Array ( );
		
		/* Creating a workbook */
		$workbook = new Spreadsheet_Excel_Writer( $fileName );
		
		/* Creating a worksheet */
		$worksheet =& $workbook->addWorksheet( $sheetName );
		$worksheet1 =& $workbook->addWorksheet("REG");
		$worksheet2 =& $workbook->addWorksheet("MGT");
		$worksheet3 =& $workbook->addWorksheet("RET");
		$worksheet4 =& $workbook->addWorksheet("CNS");
		
		$monthArray = Array("01"=> "Jan", "02"=>"Feb","03"=>"Mar","04"=>"Apr",
					"05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug",
					"09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
		
		$row = 0;
		$col = 0;
		
		$rowREG = 0;
		$rowMGT = 0;
		$rowRET = 0;
		$rowCNS = 0;
		
		$colREG = 0;
		$colMGT = 0;
		$colRET = 0;
		$colCNS = 0;
		
		//Set color
		//setBgColor
		$workbook->setCustomColor( 12, 255, 151, 95 );
		
		$format = &$workbook->addFormat(
						array(
							  'Align' => 'center',
							  'Bold' => 1,
							  'Border' => 1
							)
						);
		
		$format->setFontFamily('Trebuchet MS');
		$format->setFgColor( 12 );
		
		$formatNormal =& $workbook->addFormat(
							array(
								'Border'=> 1,
								'Align' => 'left'
								)
							);
		
		$formatNormal->setFontFamily('Trebuchet MS');
		
		/* Freeze Panes */
		$array = Array ( 1, 0, 1, 6 );
		$worksheet->freezePanes( $array );
		
		$row = 0;
		$col = 0;
		
		if( $rst && !$rst->EOF )
		{
			$columnHeaders = $rst->FieldTypesArray( );
			
			/* The actual data */
			for ( $i = 0; $i < count( $columnHeaders  ); $i++ )
			{
				$worksheet->write( $row, $col, $columnHeaders[$i]->name, $format );
				$worksheet1->write( $row, $col, $columnHeaders[$i]->name, $format );
				$worksheet2->write( $row, $col, $columnHeaders[$i]->name, $format );
				$worksheet3->write( $row, $col, $columnHeaders[$i]->name, $format );
				$worksheet4->write( $row, $col, $columnHeaders[$i]->name, $format );
				
				$worksheet->setColumn( $i, $i, 20 );
				$worksheet1->setColumn( $i, $i, 20 );
				$worksheet2->setColumn( $i, $i, 20 );
				$worksheet3->setColumn( $i, $i, 20 );
				$worksheet4->setColumn( $i, $i, 20 );
				
				$col++;
			}
			
			$rowREG++;
			$rowMGT++;
			$rowRET++;
			$rowCNS++;
			
			while( !$rst->EOF )
			{
				$row++;
				
				$col = 0;
				$colREG = 0;
				$colMGT = 0;
				$colRET = 0;
				$colCNS = 0;
				
				$flag1 = 0;
				$flag2 = 0;
				$flag3 = 0;
				$flag4 = 0;
				
				$empNum = Array( );
				
				for (  $i = 0 ; $i < count( $columnHeaders  ) ; $i++ )
				{
					$value = $rst->fields[$i];
					$value2 = $value;
					
					if ( ( !isset( $value ) ) OR ( $value == "" ) )
					{
						$worksheet->write( $row, $col++, "", $formatNormal );
						
						$value2 = "";
					}
					else
					{
						if ( eregi( "(<a href.*>)(.*)(</a>)", $value, $regs ) )
						{
							$worksheet->write( $row, $col++, $regs[2], $formatNormal );
							$value2 = $regs[2];
						}
						else if ( eregi( "(<font.*>)(.*)(</font>)", $value, $regs ) )
						{
							$worksheet->write( $row, $col++, $regs[2], $formatNormal );
							$value2 = $regs[2];
						}
						else if( ereg("([0-9]{2})(/)([0-9]{2})(/)([0-9]{4})", $value, $regs2))
						{
							$dateValue=$regs2[1]."-".$monthArray[$regs2[3]]."-".$regs2[5];
							$worksheet->write( $row, $col++, $dateValue, $formatNormal );
						}
						else
						{
							$worksheet->write( $row, $col++, $value, $formatNormal );
						}
						
						if ( $i == 0 && eregi( "([a-zA-Z]{3})(.*)", $value2, $empNum ) )
						{
							$value2 = $empNum[2];
						}
					}
					
					if ( $empNum[1] == "REG" )
					{
						$worksheet1->write( $rowREG, $colREG++, $value2, $formatNormal );
						$flag1 = 1;
					}
					
					if ( $empNum[1] == "MGT" )
					{
						$worksheet2->write( $rowMGT, $colMGT++, $value2, $formatNormal );
						$flag2 = 1;
					}
					
					if ( $empNum[1] == "RET" )
					{
						$worksheet3->write( $rowRET, $colRET++, $value2, $formatNormal );
						$flag3 = 1;
					}
					
					if ( $empNum[1] == "CNS" )
					{
						$worksheet4->write( $rowCNS, $colCNS++, $value2, $formatNormal );
						$flag4 = 1;
					}
				}
				$rst->MoveNext( );
				
				if ( $flag1 )
				{
					$rowREG++;
				}
				
				if ( $flag2 )
				{
					$rowMGT++;
				}
				
				if ( $flag3 )
				{
					$rowRET++;
				}
				
				if ( $flag4 )
				{
					$rowCNS++;
				}
				
				}
			$rst->close( );
		}
		
		// Let's send the file
		$workbook->close( );
    }

    /* Bind XSL to XML and generate html output
     * Arguments :
     * 	$url : URL where xml is
     * 	$xslFile: Path to xsl
     * Returns   :
     * 	$html: html output
    */
    function RegionInfo ( $url, $xslFile , $param , $showRegion)
    {	
		$remoteXMLFile = fopen ( $url, "r" );
		
		if ( !$remoteXMLFile )
		{
			echo "<p>Unable to open remote file.\n";
			exit;
		}
		
		$xmlData = "";
		
		while ( !feof ( $remoteXMLFile ) )
		{
			$xmlData .= fgets ( $remoteXMLFile, 1024 );
		}
		
		fclose( $remoteXMLFile );
		
		$html = "";
		
		if (PHP_VERSION >= 5)
		{
			$arguments = array(
			   '/_xml' => $xmlData,
			   '/_xsl' => file_get_contents($xslFile)
			);
			
			$xsltproc = xsltCreate( );
			$html = xsltProcess(
			   $xsltproc,
			   'arg:/_xml',
			   'arg:/_xsl',
			   null,
			   $arguments
			);
			
			xsltFree($xsltproc);
		}
		else
		{
			$xsltHandle = xslt_create( ) or die( "Can't create XSLT handle!" );
			
			// Open the XML and XSL files
			$xslStyleSheet = fopen( $xslFile, "r" ) or die( "Can't open XSL file" );
			
			// Read in the XML and XSL contents
			$xslContent = fread( $xslStyleSheet, filesize( $xslFile ) );
			
			$arg = array( '/_xml' => $xmlData,
						  '/_xsl' => $xslContent );
			
			$param = array('regionName'=>$param,
						   'showRegion' => $showRegion);
			
			// Perform the XSL transformation
			$html = @xslt_process( $xsltHandle, 'arg:/_xml', 'arg:/_xsl', NULL, $arg, $param );
			
			// Free up the resources
			@xslt_free( $xsltHandle );
		}
		
		return $html;
    }

    function FetchRelationshipString2( $con, $sessionUserId, $count = 300 )
    {
		$temp = array( );
		$temp[0] = "";
		$strarray = array( );
		
		array_push( $strarray, $sessionUserId );
		
		$sqlGetUsers = "select
					employeeId
					FROM
					professional_details
					where
					supervisor = $sessionUserId AND
					recordStatus = 'a' ";
		
		$rstGetUsers = $con->execute( $sqlGetUses && $count > 0 );
		
		if( $rstGetUsers && !$rstGetUsers->EOF )
		{
			while( !$rstGetUsers->EOF )
			{
				array_push( $strarray , $rstGetUsers->fields[0] );
				array_push( $strarray , FetchRelationshipString2( $con, $rstGetUsers->fields[0], $count-- ) );
				
				$rstGetUsers->MoveNext( );
			}
			$rstGetUsers->Close( );
			
			return implode( ',', array_unique( explode( ",", implode( ",", array_diff( $strarray, $temp ) ) ) ) );
		}
		else
		{
			array_push( $strarray , "" );
			return implode( ',', array_unique( explode( ",", implode( ",", array_diff( $strarray, $temp ) ) ) ) );
		}
    }

    //get relation string
    function FetchRelationshipString( $con, $sessionUserId )
    {
		if( $_SESSION['relationString'] == '' )
		{
			$_SESSION['relationString'] = FetchRelationshipString2( $con, $sessionUserId );
		}
		return $_SESSION['relationString'];
    }
	
	function php_compat_htmlspecialchars_decode( $string, $quote_style = null )
	{
		if (!is_scalar($string))
		{
			user_error('htmlspecialchars_decode() expects parameter 1 to be string, ' .gettype($string) . ' given', E_USER_WARNING);
		
			return;
		}
		
		if (!is_int($quote_style) && $quote_style !== null)
		{
			user_error('htmlspecialchars_decode() expects parameter 2 to be integer, ' .gettype($quote_style) . ' given', E_USER_WARNING);
			
			return;
		}
		
		$from   = array('&amp;', '&lt;', '&gt;');
		
		$to     = array('&', '<', '>');
		
		if ($quote_style & ENT_COMPAT || $quote_style & ENT_QUOTES)
		{
			$from[] = '&quot;';
			$to[]   = '"';
			$from[] = '&#039;';
			$to[]   = "'";
		}
	 
		return str_replace($from, $to, $string);
	}
	
?>
