<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript">
var isDOM = (document.getElementById ? true : false);
var isIE4 = ((document.all && !isDOM) ? true : false);
var isNS4 = (document.layers ? true : false);
var isNS = navigator.appName == "Netscape";
 
function getRef(id) {
        if (isDOM) return document.getElementById(id);
        if (isIE4) return document.all[id];
        if (isNS4) return document.layers[id];
}
 
function moveRightEdge() {
        var yMenuFrom, yMenuTo, yOffset, timeoutNextCheck ;
 
 
        if (isNS4) {
                yMenuFrom   = divMenu.top;
                yMenuTo     = windows.pageYOffset + 137; 
        } else if (isDOM) {
                yMenuFrom   = parseInt (divMenu.style.top, 10);
                yMenuTo     = (isNS ? window.pageYOffset : document.body.scrollTop) + 30;  //Specify the distance of the  Floating Object from top.
        }
        timeoutNextCheck = 50;
 
        if (yMenuFrom != yMenuTo) {
                yOffset = Math.ceil(Math.abs(yMenuTo - yMenuFrom) / 20);//Specify the floating Speed high=0,slow=500. etc
                if (yMenuTo < yMenuFrom)
                        yOffset = -yOffset;
                if (isNS4)
                        divMenu.top += yOffset;
                else if (isDOM)
                        divMenu.style.left =  120;//Specifies the distance of the floating object from left.
                       
                        divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset;
                        timeoutNextCheck = 0; //Specifies the speed of reaction .
        }
        setTimeout ("moveRightEdge()", timeoutNextCheck);
}
 
if (isNS4) {
        var divMenu = document["divMenu"];
        divMenu.top = top.pageYOffset + 0;
        divMenu.visibility = "visible";
        moveRightEdge();
} else if (isDOM) {
        var divMenu = getRef('divMenu');
        divMenu.style.top = (isNS ? window.pageYOffset : document.body.scrollTop) + 0;
        divMenu.style.visibility = "visible";
        moveRightEdge();
}

</script>
</head>


<body>
<div id=divMenu style="VISIBILITY: visible; WIDTH: 100px; POSITION: absolute; TOP: 10px; HEIGHT: 100px">you menu or stuff</div>
</body>
</html>
