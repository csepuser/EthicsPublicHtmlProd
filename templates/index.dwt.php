<?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- TemplateBeginEditable name="doctitle" -->
	<title>Center for the Study of Ethics in the Professions</title>
	<!-- TemplateEndEditable -->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="../newlayout/styles.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="../newlayout/favicon.ico" >

	<SCRIPT LANGUAGE="JavaScript">

		var theImages = new Array( )
		
		//Random-loading images
		theImages[0] = 'field.jpg' // replace with names of images
		theImages[1] = 'hub.jpg' // replace with names of images
		theImages[2] = 'main.jpg' // replace with names of images
		theImages[3] = 'ssv.jpg' // replace with names of images
		theImages[4] = 'tube.jpg' // replace with names of images
		
		var j = 0
		var p = theImages.length;
		var preBuffer = new Array( )
		
		for ( i = 0; i < p; i++ )
		{
			preBuffer[i] = new Image()
			preBuffer[i].src = theImages[i]
		}
		var whichImage = Math.round( Math.random( )*( p-1 ) );
		
		function showImage( )
		{
			if( whichImage == 0 )
			{
				document.write( '<img src="'+theImages[whichImage]+'" border=0 width=431 height=251></a>' );
			}
			else if( whichImage == 1 )
			{
				document.write( '<img src="'+theImages[whichImage]+'" border=0 width=478 height=241></a>' );
			}
			else if( whichImage == 2 )
			{
				document.write('<img src="'+theImages[whichImage]+'" border=0 width=398 height=304></a>');
			}
			else if( whichImage == 3 )
			{
				document.write( '<img src="'+theImages[whichImage]+'" border=0 width=305 height=218></a>' );
			}
			else if( whichImage == 4 )
			{
				document.write( '<img src="'+theImages[whichImage]+'" border=0 width=472 height=304></a>' );
			}
		}
	
	</script>
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
</head>

<body>
</body>
</html>
