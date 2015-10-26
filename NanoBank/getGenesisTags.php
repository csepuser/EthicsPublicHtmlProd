<?
// Collect text from genesis

	function getTags()
	{
	  global $tags;
	  $url = 'http://www.gutenberg.org/dirs/etext05/bib0110.txt';  
	  $ch = curl_init();
	  $timeout = 30; // set to zero for no timeout
	  curl_setopt ($ch, CURLOPT_URL, $url);
	  curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	  $txt = curl_exec($ch);
	  curl_close($ch);

	  $searches = array('/^.*\*\*\* START OF THE PROJECT GUTENBERG[^\n]*\n/s',
						'/^.*(\nBook 01)/s',
						'/\*\*\* END OF THE PROJECT GUTENBERG.*$/s',
						'/[^\w\'\-]/s');
	  $replaces = array('',
						'$1',
						'',
						' ');                   
	  
	  $txt = preg_replace($searches,$replaces,$txt);

	  $words = preg_split('/\s+/', $txt);
	  foreach ($words as $w)
	  {
		if ($w == '' || preg_match('/[0-9]/',$w))
			continue;
		addTag($w, 'http://dictionary.reference.com/search?q='.$w);
	  }
	}
?>