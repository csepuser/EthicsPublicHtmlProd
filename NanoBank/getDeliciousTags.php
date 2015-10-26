<?
// Collect delicious tags (or load them from a cache)

function getTags()
{
  global $tags;

  $who = 'jbum';

  if (isset($_GET['who']))
    $who = $_GET['who'];

  $who = preg_replace('/\W/', '',$who); // remove troublesome characters from name

  if ($who == '')
    return;

  $delURL = "http://del.icio.us/rss/$who";

  require('magpierss/rss_fetch.inc');
  $rss = fetch_rss($delURL);

  foreach ($rss->items as $item ) {
    $tagstrings = preg_split('/ /',$item[dc][subject]);
    foreach ($tagstrings as $tagstring)
    {
      addTag($tagstring, "http://del.icio.us/$who/$tagstring");
    }
  }
}
?>
