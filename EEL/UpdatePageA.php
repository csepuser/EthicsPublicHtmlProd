<?php
	/**
	 * Update Page.php
	 * To update the contents of the pages on the website
	 */
	 session_start( );
	echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Center for the Study of Ethics in the Professions</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" >
		<link href="http://ethics.iit.edu/beta/newlayout/csep_interior_style.css" rel="stylesheet" type="text/css">
		<script language="JavaScript" type="text/javascript">
			
			function ShowDiv( tab )
			{
				CloseAllDivs( );
				document.getElementById( tab ).style.display = "block";
				document.getElementById( tab+"Content" ).style.display = "block";
			}
			
			function ShowIndexTab( tab, indexTab )
			{
				CloseAllDivs( );
				document.getElementById( tab ).style.display = "block";
				document.getElementById( indexTab+"Content" ).style.display = "block";
			}
			
			function ShowSubTab( tab, subTab )
			{
				CloseAllDivs( );
				document.getElementById( tab ).style.display = "block";
				document.getElementById( subTab+"Content" ).style.display = "block";
			}
			
			function CloseAllDivs( )
			{
				var divsArray = document.getElementsByTagName( 'div' );
				for( var i = 3; i < divsArray.length; i++ )
				{
					divsArray[i].style.display = "none";
				}
			}
			
		</script>
	</head>
	<body>
<?php
	require_once( "../beta/include/Vars.php" ); 
	require_once( "../include/Utils-MiscA.php" );
	require_once( "../include/ErrorMessages.php" );
	require_once( "../include/adodb/adodb.inc.php" );
    require_once( "../include/fckeditor/fckeditor.php" );
	
	$headerImage = $http_site_root."images//resourceGuides.jpg";
	require_once( "../common/Header.php" );
	SessionCheck( );
    
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
	
	
	if( isset( $msg ) )
	{
		$fckEditor->Value = $_POST['updatePage'];
	}

	if( isset( $_POST['tabNSubTabValue'] ) )
	{
		$tabNSubTabValue = $_POST['tabNSubTabValue'];
		//echo $tabNSubTabValue."<br>";	
		$tabNSubTab = explode( "_", $tabNSubTabValue );
					
		if( $tabNSubTab[0] == "tab" )
		{						
			$sqlPageContent = "SELECT
									tabName,
									content,
									url
								FROM
									main_tabs
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$tabName = $rstPageContent->fields['tabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}
		
		else if( $tabNSubTab[0] == "subTab" )
		{						
			$sqlPageContent = "SELECT
									indexTabName,
									content,
									url
								FROM
									sub_tabs
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$subTabName = $rstPageContent->fields['indexTabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}
		
		else if( $tabNSubTab[0] == "libTab" )
		{						
			$sqlPageContent = "SELECT
									indexTabName,
									content,
									url
								FROM
									sub_tabs
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$subTabName = $rstPageContent->fields['indexTabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}
		
		else if( $tabNSubTab[0] == "aboutTab" )
		{						
			$sqlPageContent = "SELECT
									subTabName,
									content,
									url
								FROM
									internal_tabs
							
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$subTabName = $rstPageContent->fields['subTabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}
		
		
		
		else if( $tabNSubTab[0] == "sideBarTab" )
		{						
			$sqlPageContent = "SELECT
									subTabName,
									content,
									url
								FROM
									sidebar_tabs
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$subSubTabName = $rstPageContent->fields['subTabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}
		
		else if( $tabNSubTab[0] == "sideLibBarTab" )
		{						
			$sqlPageContent = "SELECT
									subTabName,
									content,
									url
								FROM
									sidebar_tabs
								WHERE
									id = ".$tabNSubTab[1];				
			$rstPageContent = $con->Execute( $sqlPageContent );
			if( $rstPageContent && !$rstPageContent->EOF )
			{
				$subSubTabName = $rstPageContent->fields['subTabName'];
				$url = $rstPageContent->fields['url'];
				if( !isset( $msg ) )
				{
					$fckEditor->Value = html_entity_decode( trim( $rstPageContent->fields['content'] ) );
				}
				$rstPageContent->Close( );
			}
		}

	}

    $selectMenu = "<select name=\"tabNSubTabMenu\" id=\"tabNSubTabMenu\" onChange=\"PostPage( );\" style=\"width:320px\">";
	$selectMenu .= "<option value=''></option>";
	$mainTabs = "SELECT
                        tabName,
                        id
                    FROM
                        main_tabs
                    WHERE
                        recordStatus = 'a'
						AND
						orderBy	 BETWEEN 1 AND 7 
						ORDER BY
							orderBy";
	
	$rstMainTabs = $con->Execute( $mainTabs );

	if( $rstMainTabs && !$rstMainTabs->EOF )
	{
		while( !$rstMainTabs->EOF )
        {
            $selectMenu .= "<option id='tab_".$rstMainTabs->fields['id']."' value='tab_".$rstMainTabs->fields['id']."'";
			
			//echo $rstMainTabs->fields['id']."<br>";
			//echo $updated."<br>";
			if(($tabNSubTab[1] == $rstMainTabs->fields['id']) && ($tabNSubTab[0] == "tab") )
			{
				//echo "1 - ".$rstMainTabs->fields['id']."<br>";
				$selectMenu .= " selected ";
			
			}
			$selectMenu .= ">".$rstMainTabs->fields['tabName']."</option>";

			$subTabs = "SELECT
                        	indexTabName,
							tabId,
                        	id
                		FROM
                        	sub_tabs
						WHERE
							tabId = ".$rstMainTabs->fields['id']."
                		ORDER BY
							orderBy";
	
			$rstSubTabs = $con->Execute( $subTabs );
			
			$aboutTabs = "SELECT
                          		subTabName,
						  		tabId,
                          		id
                		  FROM
                        		internal_tabs
						  WHERE
								tabId = ".$rstMainTabs->fields['id']."
								AND
								recordStatus = 'a'
                		  ORDER BY
								orderBy";
	
			$rstAboutTabs = $con->Execute( $aboutTabs );
			
			if( $rstAboutTabs && !$rstAboutTabs->EOF  )
			{
				while( !$rstAboutTabs->EOF )
        		{					
            		$selectMenu .="<option id='aboutTab_".$rstAboutTabs->fields['id'];
					$selectMenu .= "_".$rstMainTabs->fields['id'];							
					$selectMenu .="' value='aboutTab_".$rstAboutTabs->fields['id'];
					$selectMenu .="_".$rstMainTabs->fields['id']."'";	
					
					if(($tabNSubTab[1] == $rstAboutTabs->fields['id']) && ($tabNSubTab[0] == "aboutTab"))
					{
						//echo "2 - ".$rstAboutTabs->fields['id']."<br>";
						$selectMenu .= " selected ";
					
					}
					$selectMenu .= ">".$rstMainTabs->fields['tabName']." - ".$rstAboutTabs->fields['subTabName']."</option>";
						
					$rstAboutTabs->MoveNext( );
				}
				$rstAboutTabs->Close( );
			}  
			
			if( $rstSubTabs && !$rstSubTabs->EOF  )
			{
				while( !$rstSubTabs->EOF )
        		{					
            		$selectMenu .="<option id='subTab_".$rstSubTabs->fields['id'];
					$selectMenu .= "_".$rstMainTabs->fields['id'];	
					$selectMenu .="' value='subTab_".$rstSubTabs->fields['id'];
					$selectMenu .= "_".$rstMainTabs->fields['id']."'";
					
					if(($tabNSubTab[1] == $rstSubTabs->fields['id']) && ($tabNSubTab[0] == "subTab") )
					{
						//echo "3 - ".$rstSubTabs->fields['id']."<br>";
						$selectMenu .= " selected ";
						
					}
					$selectMenu .= ">".$rstMainTabs->fields['tabName']." - ".$rstSubTabs->fields['indexTabName']."</option>";
					
					$sideBarTabs = "SELECT
                          				subTabName,
						  				tabId,
                          				id
                		  			FROM
                        				sidebar_tabs
						  			WHERE
										tabId = ".$rstSubTabs->fields['id']."									
                		  			ORDER BY
										orderBy";
	
					$rstSideBarTabs = $con->Execute( $sideBarTabs );
						
					if( $rstSideBarTabs && !$rstSideBarTabs->EOF  )
					{
						while( !$rstSideBarTabs->EOF )
        				{					
            				$selectMenu .="<option id='sideBarTab_".$rstSideBarTabs->fields['id'];
							$selectMenu .= "_".$rstSubTabs->fields['id'];	
							$selectMenu .= "_".$rstMainTabs->fields['id'];	
							$selectMenu .="' value='sideBarTab_".$rstSideBarTabs->fields['id'];
							$selectMenu .= "_".$rstSubTabs->fields['id'];
							$selectMenu .= "_".$rstMainTabs->fields['id']."'";
					
							if(($tabNSubTab[1] == $rstSideBarTabs->fields['id']) && ($tabNSubTab[0] == "sideBarTab"))
							{
								//echo "4 - ".$rstSideBarTabs->fields['id']."<br>";					
								$selectMenu .= " selected ";
								
							}
							
							$selectMenu .= ">".$rstMainTabs->fields['tabName'];
							$selectMenu .=" - ".$rstSubTabs->fields['indexTabName'];
							$selectMenu .=" - ".$rstSideBarTabs->fields['subTabName']."</option>";
						
							$rstSideBarTabs->MoveNext( );
						}
						$rstSideBarTabs->Close( );
					} 
					$rstSubTabs->MoveNext( );
				}
				$rstSubTabs->Close( );
			}  
			

			
            $rstMainTabs->MoveNext( );
        }
		$rstMainTabs->Close( );
	}
	
			$libTabs = "SELECT
                        	indexTabName,
							tabId,
                        	id
                		FROM
                        	sub_tabs
						WHERE
							tabId = 23
                		ORDER BY
							orderBy";
	
			$rstLibTabs = $con->Execute( $libTabs );
			
			if( $rstLibTabs && !$rstLibTabs->EOF  )
			{
				while( !$rstLibTabs->EOF )
        		{					
            		$selectMenu .="<option id='libTab_".$rstLibTabs->fields['id'];
					$selectMenu .= "_23";							
					$selectMenu .="' value='libTab_".$rstLibTabs->fields['id'];
					$selectMenu .= "_23'";	
					
					if(($tabNSubTab[1] == $rstLibTabs->fields['id']) && ($tabNSubTab[0] == "libTab"))
					{
						//echo "2 - ".$rstAboutTabs->fields['id']."<br>";
						$selectMenu .= " selected ";
					
					}
					$selectMenu .= ">Library - ".$rstLibTabs->fields['indexTabName']."</option>";
					
					$sideLibBarTabs = "SELECT
                          				subTabName,
						  				tabId,
                          				id
                		  			FROM
                        				sidebar_tabs
						  			WHERE
										tabId = ".$rstLibTabs->fields['id']."									
                		  			ORDER BY
										orderBy";
	
					$rstSideLibBarTabs = $con->Execute( $sideLibBarTabs );
						
					if( $rstSideLibBarTabs && !$rstSideLibBarTabs->EOF  )
					{
						while( !$rstSideLibBarTabs->EOF )
        				{					
            				$selectMenu .="<option id='sideLibBarTab_".$rstSideLibBarTabs->fields['id'];
							$selectMenu .= "_".$rstLibTabs->fields['id'];	
							$selectMenu .= "_23";	
							$selectMenu .="' value='sideLibBarTab_".$rstSideLibBarTabs->fields['id'];
							$selectMenu .= "_".$rstLibTabs->fields['id'];
							$selectMenu .= "_23'";
					
							if(($tabNSubTab[1] == $rstSideLibBarTabs->fields['id']) && ($tabNSubTab[0] == "sideLibBarTab"))
							{
								//echo "4 - ".$rstSideBarTabs->fields['id']."<br>";					
								$selectMenu .= " selected ";
								
							}
							
							$selectMenu .= ">Library";
							$selectMenu .=" - ".$rstLibTabs->fields['indexTabName'];
							$selectMenu .=" - ".$rstSideLibBarTabs->fields['subTabName']."</option>";
						
							$rstSideLibBarTabs->MoveNext( );
						}
						$rstSideLibBarTabs->Close( );
					}
					$rstLibTabs->MoveNext( );
				}
				$rstLibTabs->Close( );
			} 
    
    $selectMenu .= "</select>";
	
	$con->Disconnect( );
?>
<div id="mainwrap" style="overflow:auto" width="100%" height="100%">
	
	<div id="left_columns_wrap" > <!--start left column wrap-->
		<div id="interior_page_photo" valign="top"> <!-- page-specific image -->          
		</div><!-- end page-specific image -->
                    
        <!-- start horizontal categories nav -->
		<div id="horizontal_nav">
			<?php require_once( "../common/Navigation.php" ); ?>
			<div class="clear"></div>
		</div><!-- end horizontal categories nav -->
                    
		<div id="left_column" > <!-- start left-hand column -->                        
			<?php require_once( "../common/AdminSidebarA.php" ); ?>                                                  
		</div><!-- end left column -->

		
					<form action="UpdatePage-2A.php" method="post">
 Update Page 
					    <?php if( $_POST['msg'] == "dataExists" ){?>
					  <?=$dataExists?>
					    <?php } ?>
					    
						<?=$selectMenu?>
					      <?php if( $tabNSubTab[0] == "subTab"  || $tabNSubTab[0] == "aboutTab"  || $tabNSubTab[0] == "libTab") { ?>
					       Subtab Name:
					     <input type="text" name="subTabName" id="subTabName" value="<?=$subTabName?>" onkeypress="UpdateURL( );" onblur="UpdateURL( );" />
					      <?php
									}
									else if( $tabNSubTab[0] == "sideBarTab"  || $tabNSubTab[0] == "sideLibBarTab" ) 
									{
								?>
					      SubSubtab Name:
					 <input type="text" name="subSubTabName" id="subSubTabName" value="<?=$subSubTabName?>" onkeypress="UpdateURL( );" onblur="UpdateURL( );" />
					      <?php
									}
									else
									{
								?>
					      New Tab Name: 
                          <input type="text" name="tabName" id="tabName" value="<?=$tabName?>" onkeypress="UpdateURL( );" onblur="UpdateURL( );" />
					      <?php
									}
								?>
					     URL: <input type="text" name="url" id="url" value="<?=$url?>" readonly /><?=$fckEditor->Create( )?><br />
					        <input type="submit" class="button2" name="btnSubmit" id="btnSubmit" value="Update Page" onclick="return Validate( );" />
					</form>
		

	</div>
</div>
<form name="UpdatePage" action="UpdatePageA.php" method="post">
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
		//alert(document.getElementById( "tabNSubTabMenu" ).value);
		document.UpdatePage.submit( );
	}
	
	function UpdateURL( )
	{
		try
		{
			document.getElementById( "url" ).value = 'http://ethics.iit.edu/index1A.php/'+document.getElementById( "tabName" ).value;
		}
		catch( error )
		{
			var tabNSubTab = document.getElementById( document.getElementById( "tabNSubTabMenu" ).value ).innerHTML.split( "-" );
			
			try
			{
				document.getElementById( "url" ).value = "http://ethics.iit.edu/index1A.php/"+Trim( tabNSubTab[0] )+"/"+document.getElementById( "subTabName" ).value;
			}
			catch( error )
			{
			
			}
		}
	}
	
</script>


  <?php  require_once("../common/Footer.php"); ?>

</body>
</html>