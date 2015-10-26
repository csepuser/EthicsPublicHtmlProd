<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


              


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test</title>
<link rel="shortcut icon" href="http://ethics.iit.edu/newlayout/favicon.ico" />
<meta name="keywords" title="keywords" content="" />
<meta name="description" content="" />


<script src="http://code.jquery.com/jquery-1.7.1.js"></script>
<script src="http://ethics.iit.edu/sea/js/jScrollPane.js"></script>

  <style>
	div { width:60px; height:60px; margin:5px; float:left; }
	.hide{ display:none; }
  </style>

</head>
<body >

<span id="result">&nbsp;</span>
<div id="blue" style="background-color:red;"></div>
<div class="hide" style="background-color:rgb(15,99,30);"></div>

<div class="hide" style="background-color:#123456;"></div>
<div class="hide" style="background-color:#f11;"></div>
<script>
function () {$(#blue).css("background-color","blue");
$("#blue").click(function () {
if ($(".hide").is(":hidden")) {$("div").slideDown("slow");} else {$(".hide").slideUp("slow");}
});

</script>
            

</body>
</html>
