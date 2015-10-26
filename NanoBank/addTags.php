<?
function addTag($tag,$url)
{
	global $tags;
	$utag = strtoupper($tag);	
	if (!$tags[$utag])
		$tags[$utag] = array('count' => 0, 'url' => $url, 'tag' => $tag);
	$tags[$utag]['count']++;
}
?>