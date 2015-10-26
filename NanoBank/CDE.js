// JavaScript Document
var xmlHttp

function submitIt(area, assoc_code, paper_code, assoc_desc, paper_desc, location)
{ 
alert(location);
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
  		alert ("Your browser does not support AJAX!");
  		return;
  	} 
	var url="PriyaCDEForm.php";
	var text = "<insert>";
	text = text + "<area>" + area + "</area>";
	text = text + "<assoc_code>" + assoc_code + "</assoc_code>";
	text = text + "<paper_code>" + paper_code + "</paper_code>"; 
	text = text + "<assoc_desc>" + assoc_desc + "</assoc_desc>";
	text = text + "<paper_desc>" + paper_desc + "</paper_desc>";
	text = text + "<location>" + location + "</location>";
	text = text + "</insert>";
	
	xmlHttp.onreadystatechange = stateChanged; 
	xmlHttp.open("POST",url,true);
	xmlHttp.setRequestHeader("Man", "GET url/server.php HTTP/1.1")
 	xmlHttp.setRequestHeader("MessageType", "CALL")
 	xmlHttp.setRequestHeader("Content-Type", "text/xml; charset=utf-8")
	xmlHttp.send(text);
	alert(text);
	alert("Your Registration request is sent!");
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		xmlDoc=xmlHttp.responseXML;
		 
		var root = xmlDoc.documentElement;
		alert(root.childNodes[0].childNodes[0].nodeValue);
		//document.getElementById("txtHint").innerHTML=xmlHttp.responseText;
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
  	{
  		// Firefox, Opera 8.0+, Safari
  		xmlHttp=new XMLHttpRequest();
  	}
	catch (e)
  	{
  		// Internet Explorer
  		try
    	{
    		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    	}
  		catch (e)
    	{
    		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    	}
  	}
	return xmlHttp;
}