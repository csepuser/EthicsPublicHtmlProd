<html>
<head>
  <link href="mystyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="cdiv">
<p class="cbox">

<?

$tags = array();

include "addTags.php";

include 'getDeliciousTags.php';
// include "getGenesisTags.php";

getTags();

// grab top LIMIT here, if arguments specify a limit
// and reduce to top N tags.
if (isset($_GET['limit']))
{
  arsort($tags);
  $tags = array_slice($tags, 0, (int)($_GET['limit']));
}

// Build Log Cloud from Tags
//
$useLogCurve = 1;
if (isset($_GET['linear']))
	$useLogCurve = 0;

$minFontSize = 10;
$maxFontSize = 36;
$fontRange = $maxFontSize - $minFontSize;
$maxTagCnt = 0;
$minTagCnt = 10000000;

foreach ($tags as $tag => $trec)
{
	$cnt = $trec['count'];
	
  if ($cnt > $maxTagCnt) 
  	$maxTagCnt = $cnt;
  if ($cnt < $minTagCnt)
  	$minTagCnt = $cnt;
}
$tagCntRange = $maxTagCnt+1 - $minTagCount;

$minLog = log($minTagCnt);
$maxLog = log($maxTagCnt);
$logRange = $maxLog - $minLog;
if ($maxLog == $minLog) $logRange = 1;


ksort($tags); # use arsort($tags) to sort by descending count

foreach ($tags as $utag => $trec)
{
  $cnt = $trec['count'];
  $url = $trec['url'];
  $tag = $trec['tag'];
  if ($useLogCurve)
    $fsize = $minFontSize + $fontRange * (log($cnt) - $minLog)/$logRange;
  else
    $fsize = $minFontSize + $fontRange * ($cnt - $minTagCnt)/$tagCntRange;
  printf("<a target=xxx href=%s style=\"font-size:%dpx;\">%s</a>\n", $url,(int)$fsize, $tag);
}

?>

</p>
</div>
</body></html>
