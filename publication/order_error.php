<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<head> 
		<title>Center for the Study of Ethics in the Professions</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<?php if (isset($_GET['q']) && $_GET['q'] == 'printme') { ?>
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/newlayout/print.css"/>
		<?php } else { ?>
		<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/newlayout/csep_interior_style.css" />
		<?php } ?>
		<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" />
	
		<SCRIPT LANGUAGE="JavaScript"> 
	
			var theImages = new Array( )
						
			var j = 0
			var p = theImages.length;
			var preBuffer = new Array( )
			
			for ( i = 0; i < p; i++ )
			{
				preBuffer[i] = new Image( )
				preBuffer[i].src = theImages[i]
			}
			
			function ShowDiv( tab )
			{
				CloseAllDivs( );
				document.getElementById( tab ).style.display = "block";
				document.getElementById( tab+"Content" ).style.display = "block";
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
			
			function htmlspecialchars_decode(string, quote_style)
			{				
				string = string.toString();
				
				// Always encode
				string = string.replace('/&amp;/g', '&');
				string = string.replace('/&lt;/g', '<');
				string = string.replace('/&gt;/g', '>');
				
				// Encode depending on quote_style
				if (quote_style == 'ENT_QUOTES')
				{
					string = string.replace('/&quot;/g', '"');
					string = string.replace('/&#039;/g', '\'');
				}
				else if (quote_style != 'ENT_NOQUOTES')
				{
					// All other cases (ENT_COMPAT, default, but not ENT_NOQUOTES)
					string = string.replace('/&quot;/g', '"');
				}
				
				return string;
			}
			
		</script> 
	</head> 
	<body> 
	
	<div id="container"> 
	<?php 
		require_once( "./common/Header.php" );
	?>
                                
    <div id="mainwrap"> 
    	<div id="left_columns_wrap" > <!--start left column wrap--> 
        	<div id="interior_page_photo" valign="top"> <!-- page-specific image --> 
            	<img src=http://ethics.iit.edu/images/publications.jpg width="629" height="80" valign="top" border="none" usemap="#interior_page_photo" /> 
                <map name="interior_page_photo" id="interior_photo"> 
                	<area href="http://library.iit.edu/" shape="rect" coords="70,20,268,5" alt="Library Home" /> 
                </map> 
            </div><!-- end page-specific image --> 
                     
            <div id="horizontal_nav"> <!-- start horizontal categories nav --> 
             	<ul id="horizontal_nav_list" class="menuitem"> 
                	<li id="home_li"><span id="home"><a id="home_a" href="http://ethics.iit.edu/" class="normal">CSEP Home</a></span></li> 
                    <li><span class="menuitem"><a href='http://ethics.iit.edu/index1.php/Programs' class="normal">Programs</a></span></li>
                    <li><span class="menuitem"><a href='http://ethics.iit.edu/index1.php/About Us' class="normal">About Us</a></span></li>
                    <li><span class="menuitem"><a href='http://ethics.iit.edu/index3.php' class="normal">Library</a></span></li>
                    <li><span class="menuitem"><a href='http://ethics.iit.edu/index1.php/Publications' class="hilite">Publications</a></span></li>                         
                    </ul>
            </div><!-- end horizontal categories nav --> 
                    
            <div id="left_column" > <!-- start left-hand column --> 
				<div id="left_nav">
					<a href=''> <strong class="red" >PUBLICATIONS</strong></a>
					<ul>
						<li><a href='http://ethics.iit.edu/index1.php/Publications/Perspective on the Professions' >Perspective on the Professions</a></li>
						<li><a href='http://ethics.iit.edu/index1.php/Publications/Featured Publications' >Featured Publications</a></li>
						<li><a href='http://ethics.iit.edu/index1.php/Publications/Order Center Publications' >Order Center Publications</a></li>
						<li><a href='http://ethics.iit.edu/index1.php/Publications/Modules in Applied Ethics' >Modules in Applied Ethics</a></li>
						<li ><a href='http://ethics.iit.edu/index1.php/Publications/new order page' >new order page</a></li>
					</ul>
				</div>
					<form name="populatePageBody" action="http://ethics.iit.edu/indexnew.php" method="post"> 
						<input type="hidden" name="expandSubSubTab" id="expandSubSubTab"> 
 					</form> 
 
					<script language="JavaScript" type="text/javascript"> 
	
						function PopulateNExpand( expandSubSubTab )
						{
							document.getElementById( "expandSubSubTab" ).value = expandSubSubTab;
							document.populatePageBody.submit( );
						}
					</script> 
            </div> <!-- end left column --> 
                    
            <div id="main_textarea" style="width:450px;height:600px;overflow:auto;"> 
            	<font color="black"> <p>&nbsp;</p>                     
					<?php 
						if( isset( $order_error ))
						{
							echo $_POST['order_error'];
						}
					?> 
					<p>Please try placing the order again with correct information. </p> 
					<br/> <br/>
					<p>For further assistance please contact CSEP.</p> 
					<p>email: csep@iit.edu</p>
					<p>Phone: 312.567.3017</p>  
					<p>&nbsp;</p>                    	
				</font> 
            </div> 
               
        </div> <!--end of left column wrap--> 
                
        <div id="right_column"> <!--start right column--> 
        	<?php
            	require_once( "http://ethics.iit.edu/common/RightSidebar.php" );
            ?>       
        </div> <!-- end right column -->
        
        <div class="clear"></div> 
    </div><!--end mainwrap--> 
        
    <div class="clear"></div> 
             
    <div id="footer"><!--start footer--> 
		<?php
           	require_once("./common/Footer.php");
        ?>
    </div> <!--end footer--> 
	
	        
    <div class="clear"></div> 
    </div><!--end container--> 
    
    </body> 
</html>