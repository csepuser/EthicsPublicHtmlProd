<?php
	/**
	 * Update Page.php
	 * To update the contents of the pages on the website
	 */
	// session_start( );
	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Center for the Study of Ethics in the Professions</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" >
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/jScrollPane.css" media="all" />
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/style_sea.css" media="all" />
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/superfish.css" media="screen" />

	</head>
	<body>
<?php
	require_once( "./include/Vars_new.php" );
	require_once( "./include/Utils-Misc.php" );
	//require_once( "./include/ErrorMessages.php" );
	//require_once( "./include/adodb/adodb.inc.php" );
    //require_once( "./include/fckeditor/fckeditor.php" );
	
	$headerImage = $http_site_root."images//resourceGuides.jpg";
	//SessionCheck( );
    
    // instantiate new FckEditor
	$fckEditor = new FckEditor('updatePage');
	$fckEditor->Height = '512' ;
	
	$fckEditor->BasePath = $FCKEditorBasePath;
	$fckEditor->Value = "";
	
	// instantiate variables to designate target page
	$tabId = "";
	$subTabName = "";
	$tabName = "";
	$subSubTabName = "";
	
	$sqlPageContent= "";
	$rstPageContent= "";
	
	// open new database connection
	$con = &AdoNewConnection( $system_db_dbtype );
	$con->Connect( $system_db_server, $system_db_username, $system_db_password, $system_db_dbname );
	
	
	$sqlPageContent = "SELECT
							subTabName
						FROM
							csep2.sea";
											
	$rstPageContent = $con->Execute( $sqlPageContent );
	
	$pagemenu ="<form action=\"\">";
	$pagemenu.="<select name=\"page\">";
	if( $rstPageContent && !$rstPageContent->EOF )
	{
			$subTabName = $rstPageContent->fields['subTabName'];
			$pagemenu.="<option value=".$subTabName.">".$subTabName."</option>";
			
	}
	$rstPageContent->Close( );	
	$pagemenu.="</select>";		
	$pagemenu.="</form>";	
				
	

    
	

?>
<?php require_once( "./common/sea_header.php" );?>
<?php echo $pagemenu ?>
<tr height="100%">
	<td align="center" class="text">
		<table border="0" cellpadding="3" cellspacing="1" width="100%" height="100%">
			<tr>

				<td width="80%" valign="top" class="text" align="center">
					<form action="UpdatePage-2.php" method="post">
						<table border="0" cellpadding="3" cellspacing="2" bgcolor="#DCDCDC" width="100%" align="center">
							<tr>
								<td colspan="6" class="tableheader" align="Center">
									<font size="2" face="Verdana">
									Update Page
									</font>
								</td>
							</tr>
                            <?php
								//if( $_POST['msg'] == "dataExists" )
								{
							?>
							<tr>
								<td colspan="6" class="errormessage" align="center">
									<?=$dataExists?>
								</td>
							</tr>
							<?php
								}
							?>
							<tr bgcolor="#FFFFFF" align="left">
								<td align="right" class="textbold" width="10%" nowrap>
									Tab Name:
								</td>
								<td align="left" class="text" width="30%">
									<?=$selectMenu?>
								</td>
								<?php
									if( $tabNSubTab[0] == "subTab" )
									{
								?>
								<td align="right" class="textbold" width="20%" nowrap>
									Subtab Name:
								</td>
								<td align="left" class="text" width="30%" nowrap>
									<input type="text" name="subTabName" id="subTabName" value="<?=$subTabName?>" onKeyPress="UpdateURL( );" onBlur="UpdateURL( );">
								</td>
								<?php
									}
									elseif( $tabNSubTab[0] == "subSubTab" ) 
									{
								?>
								
								<td align="right" class="textbold" width="10%" nowrap>
									SubSubtab Name:
								</td>
								<td align="left" class="text" width="10%" nowrap>
									<input type="text" name="subSubTabName" id="subSubTabName" value="<?=$subSubTabName?>" onKeyPress="UpdateURL( );" onBlur="UpdateURL( );">
								</td>
								
								<?php
									}
									else
									{
								?>
								<td align="right" class="textbold" width="10%" nowrap>
									New Tab Name:
								</td>
								<td align="left" class="text" width="10%" nowrap>
									<input type="text" name="tabName" id="tabName" value="<?=$tabName?>" onKeyPress="UpdateURL( );" onBlur="UpdateURL( );">
								</td>
								<?php
									}
								?>
								<td align="right" class="textbold" width="10%" nowrap>
									URL:
								</td>
								<td align="left" class="text" width="50%">
									<input type="text" name="url" id="url" value="<?=$url?>" readonly>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td colspan="6" align="center">
									<?=$fckEditor->Create( )?>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td colspan="6" align="center">
									<br><input type="submit" class="button2" name="btnSubmit" id="btnSubmit" value="Update Page" onclick="return Validate( );">
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</td>
</tr>
<form name="UpdatePage" action="UpdatePage.php" method="post">
	<input type="hidden" name="tabNSubTabValue" id="tabNSubTabValue">
</form>
<script type="text/javascript" language="JavaScript">
	
	function Trim( sString )
	{
		while( sString.substring( 0, 1  ) == " " )
		{
			sString = sString.substring( 1, sString.length );
		}
		
		while( sString.substring( sString.length - 1, sString.length ) == " " )
		{
			sString = sString.substring( 0, sString.length - 1 );
		}
		
		return sString;
	}
	
	function Validate( )
	{
		if( Trim( document.getElementById( "tabNSubTabMenu" ).value ) == "" )
		{
			alert( "Please select Tab Name!!!" );
			document.getElementById( "tabNSubTabMenu" ).focus( );
			return false;
		}
		
		try
		{
			if( Trim( document.getElementById( "tabName" ).value ) == "" )
			{
				alert( "New Tab Name is required!!!" );
				document.getElementById( "tabName" ).focus( );
				return false;
			}
		}
		catch( error )
		{
			if( Trim( document.getElementById( "subTabName" ).value ) == "" )
			{
				alert( "Sub Tab is required!!!" );
				document.getElementById( "subTabName" ).focus( );
				return false;
			}
		}
	}
	
	function PostPage( )
	{
		document.getElementById( "tabNSubTabValue" ).value = document.getElementById( "tabNSubTabMenu" ).value;
		document.UpdatePage.submit( );
	}
	
	function UpdateURL( )
	{
		try
		{
			document.getElementById( "url" ).value = "http://ethics.iit.edu/index1.php/"+document.getElementById( "tabName" ).value;
		}
		catch( error )
		{
			var tabNSubTab = document.getElementById( document.getElementById( "tabNSubTabMenu" ).value ).innerHTML.split( "-" );
			
			try
			{
				document.getElementById( "url" ).value = "http://ethics.iit.edu/index1.php/"+Trim( tabNSubTab[0] )+"/"+document.getElementById( "subTabName" ).value;
			}
			catch( error )
			{
			
			}
		}
	}
	
</script>
<?php
            require_once("./common/Footer.php");
 ?>
</body>
</html>