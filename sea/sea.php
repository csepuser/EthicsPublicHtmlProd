<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
			require_once( "./include/Vars_new.php" );
			require_once( "./include/Utils-Misc.php" );
			require_once( "./include/adodb/adodb.inc.php" );
			
	$con = &AdoNewConnection( $system_db_dbtype );
	$con->Connect( $system_db_server, $system_db_username, $system_db_password, $system_db_dbname );

	$rawURL = explode( ".php", $_SERVER['PHP_SELF'] );
	
	$toExplode = substr( $rawURL[1], 1, strlen( $rawURL[1] ) );
	$tabNSubTab = explode( "/", $toExplode);
	$amount = count( $tabNSubTab);
	
	if ($tabNSubTab[0]==NULL)
	{
		$tabNSubTab[0] = 100;
	}
	
	$sqlBodyContent = "SELECT
							content,url,id,subTabName
						FROM
							csep2.sea
						WHERE
							id = ".$tabNSubTab[0]." ";
					
	$rstBodyContent = $con->Execute( $sqlBodyContent );
	
	$bodyContent ="";
	$title = $rstBodyContent->fields['subTabName'];
	
	if ($rstBodyContent->fields['content']==NULL)
	{
		$bodyContent.="<h1>404 - Error</h1><p>Page Not Found</p>" ;
	}
    else
	{
		$bodyContent.= php_compat_htmlspecialchars_decode( $rstBodyContent->fields['content'],1 );
	}


?>


              


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/jScrollPane.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/style_sea.css" media="all" />
<link rel="stylesheet" type="text/css" href="http://ethics.iit.edu/sea/styles/superfish.css" media="screen" />
<title><?php echo $title ?></title>
<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" />
<meta name="keywords" title="keywords" content="" />
<meta name="description" content="" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-8938192-11']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script src="http://code.jquery.com/jquery-1.7.1.js"></script>
<script src="http://ethics.iit.edu/sea/js/jScrollPane.js"></script>
<script src="http://ethics.iit.edu/sea/js/hoverIntent.js"></script> 
<script src="http://ethics.iit.edu/sea/js/superfish.js"></script>
<script type="text/javascript"> 
var pageTracker = _gat._getTracker("UA-3621988-3");
pageTracker._trackPageview();
</script>

<script type="text/javascript">
	$(function(){ $('#inner').jScrollPane(); });	
	 
    $(document).ready(function(){ $("ul.sf-menu").superfish(); }); 
</script>

</head>
<body>

            

<div id="wrapper">
<div id="banner"></div>

<?php require_once( "./common/sea_header.php" );?>


<div id="viewer">
<?php echo $bodyContent; ?>
<?php require_once( "./common/sea_footer.php" ); ?>
</div>




</div>
</body>
</html>
