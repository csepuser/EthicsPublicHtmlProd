<?php 
session_start( );
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Center for the Study of Ethics in the Professions</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />		
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/beta/newlayout/csep_interior_style.css" />
		<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" >
	</head>
	<body>
		<?php
			require_once( "./include/Vars_new.php" );
			require_once( "./include/Utils-Misc.php" );
			require_once( "./include/adodb/adodb.inc.php" );
			
			$con = &AdoNewConnection( $system_db_dbtype );
			$con->Connect( $system_db_server, $system_db_username, $system_db_password, $system_db_dbname );
			
			require_once( "./common/sea_header.php" );
			
			$populateTopLinks = "";
			$sqlFetchTopLinks = "SELECT
				id,
				tabName,
				url
			FROM
				main_tabs
			WHERE
				orderBy BETWEEN 1 AND 4
			ORDER BY
				orderBy ASC";
			
			$rstFetchTopLinks = $con->Execute( $sqlFetchTopLinks );
		
			if( $rstFetchTopLinks && !$rstFetchTopLinks->EOF )
			{
				while( !$rstFetchTopLinks->EOF )
				{
					$populateTopLinks .= "<li><span class=\"menuitem\"><a href='".$rstFetchTopLinks->fields['url']."' ";
					if( $tabNSubTab[0] == $rstFetchTopLinks->fields['tabName'] )
					{
						$populateTopLinks .= "class=\"hilite\">";
					}
					else
					{
							$populateTopLinks .= "class=\"normal\">";
					}
					$populateTopLinks .= $rstFetchTopLinks->fields['tabName'];
					$populateTopLinks .= "</a></span></li>";
					
					$rstFetchTopLinks->MoveNext( );
				}
			}
			$rstFetchTopLinks->Close( );
			
		$con->Disconnect( );
				
			$bodyHeaderAdmin .= "<p class=\"tableheader\" align=\"center\"><strong>CSEP Administrator Home</strong></p>";
			$bodyContent .= "This is the home page for the admin module for CSEP Website.";
		?>
        <div id="mainwrap">
                
               <div id="left_columns_wrap" > <!--start left column wrap-->
                    
                    <div id="interior_page_photo" valign="top">
                
                  
             
                    </div><!-- end page-specific image -->
                    
                    <!-- start horizontal categories nav -->
                 
    
                    

                    
                    <div id="main_textarea">
					    <?php
							echo $bodyHeaderAdmin;
                            echo $bodyContent;							
                        ?>
                        
                        <?php
							require_once( "../common/AdminSidebarA.php" );
						?>
                    
                    </div>
                </div><!--end of left column wrap-->
                

                
        </div> <!--end mainwrap-->
        <div class="clear"></div>
        
        <!--start footer-->
        <?php
            require_once("../common/Footer.php");
        ?>
        
         <div class="clear"></div>
	</body>
</html>