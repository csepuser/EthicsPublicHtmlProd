<!--
/* To Display the Help lin*/
function popup(mylink)
{
	if (! window.focus)return true;
	var href;
	if (typeof(mylink) == 'string')
   		href=mylink;
	else
   		href=mylink.href;
	window.open(href, 'Help', 'width=600,height=400,scrollbars=yes');
	return false;
}

/* 
	To Display the Help link when boolean search is selected.
	The coordinates of "mode" are found using findX and findY functions.
*/
function lookMode(mode)
{
	var mydiv = document.getElementById("mydiv");
	if (mode == 'Boolean')
	{
		if (mydiv == null)
		{
			alert("Sorry can't find your div");
			return;
		}
		var left = findX("mode");
		left = left + 100;
		
		var top = findY("mode");
		top = top + 2;
//		mydiv.style.visibility="visible";
		mydiv.style.display='block';
		mydiv.style.left = left;
		mydiv.style.top = top;

//		window.document.search.help.style.display='block';
	}
	else
		mydiv.style.display='none';;
}

function getY(layerID)
{
	var iReturnValue = 0;
	elementid=document.getElementById(layerID)
	while( elementid != null )
	{
		iReturnValue += elementid.offsetTop;
		elementid = elementid.offsetParent;
	}
	alert("link:"+iReturnValue);
	return iReturnValue;
}
/*
Finds the the X coordinate of the object
*/
function findX(layerID)
{
	var curleft = 0;
	obj=document.getElementById(layerID);
	if(obj.offsetParent)
		while(1) 
		{
			curleft += obj.offsetLeft;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
		}
	else if(obj.x)
		curleft += obj.x;
		
	return curleft;
}

/*
Finds the the Y coordinate of the object
*/
function findY(layerID)
{
	var curtop = 0;
	obj=document.getElementById(layerID);
	if(obj.offsetParent)
		while(1)
		{
			curtop += obj.offsetTop;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
		}
	else if(obj.y)
		curtop += obj.y;
	return curtop;
}
