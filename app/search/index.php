<?php
$configs = include('../config.php');
header('Content-type: application/rss+xml');
date_default_timezone_set('UTC');
function xml_entities($string) {
    return strtr(
        $string, 
        array(
            "<" => "&lt;",
            ">" => "&gt;",
            '"' => "&quot;",
            "'" => "&apos;",
            "&" => "&amp;",
        )
    );
}
if (isset($_GET['page'])) {
if (isset($_GET['q'])) {
	if (isset($_GET['page'])) {
$fp = fopen($configs['invidious'].$configs['search'].'&q='.$_GET['q'].'&page='.$_GET['page'], 'r');
$pagenum = $_GET['page'];
	} else {
		$fp = fopen($configs['invidious'].$configs['search'].'&q='.$_GET['q'], 'r');
		$pagenum = 1;
	}
$meta_data = stream_get_contents($fp);
$json = json_decode($meta_data, false);
$json_count = count($json);

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">';
echo '<channel><title>Invidious - '.$_GET['q'].'</title>';
echo '<atom:link href="'.$configs['hostname'].'" rel="self" type="application/rss+xml" />';
echo '<description>Search - '.$_GET['q'].'</description>';
echo '<link>'. xml_entities($configs['hostname']) .'/</link>';
echo '<image><url>'.$configs['hostname'].'images/icon.png</url><title>Invidious Gaming</title></image>';
for ($x = 0; $x < $json_count; $x++) {
	echo '<item><title>'.xml_entities($json[$x]-> title).'</title>';
	echo '<link>'.xml_entities($riitube.$json[$x]-> videoId).'</link>';
	echo '<guid>'.xml_entities($riitube.$json[$x]-> videoId).'</guid>';
	$published = new DateTime('@'.$json[0]-> published);
	echo '<pubDate>'.date_format($published,"D, d M Y H:i:s O").'</pubDate>';
	echo '<enclosure url="'.xml_entities($riitube.$json[$x]-> videoId).'" type="video/mp4" />';
	echo '<media:thumbnail url="http://i1.ytimg.com/vi/'.$json[$x]-> videoId.'/hqdefault.jpg" width="480" height="360"/>';
	echo '<description>'.xml_entities($json[$x]-> author).'</description></item>';
}
echo '<item><title>Next Page</title><enclosure url="'.$configs['hostname'].'search'.'?q='.$_GET['q'].'&amp;page='.++$pagenum.'" type="application/rss+xml" bookmark="false"/></item>';
echo '</channel></rss>';
}
} else {
	$str = 'abcdefghijklmnopqrstuvwxyz1234567890';
$chars = str_split($str);
if (isset($_GET['q'])) {
	$string = $_GET['q'];
} else {
	$string = '';
}
echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">';
echo '<channel><title>Invidious - Search</title>';
echo '<atom:link href="'.$configs['hostname'].'" rel="self" type="application/rss+xml" />';
echo '<description>Search</description>';
echo '<link>'. xml_entities($configs['hostname']) .'/</link>';
echo '<image><url>'.$configs['hostname'].'images/icon.png</url><title>Invidious Gaming</title><link>'.$configs['hostname'].'</link></image>';
if (isset($_GET['q'])) {
echo '<item><title>'.$string.'</title><enclosure url="'.$configs['hostname'].'search/index.php?q='.$string.'&amp;page=1" type="application/rss+xml" bookmark="false"/></item>';
}
echo '<item><title>SPACE</title><enclosure url="'.$configs['hostname'].'search/index.php?q='.$string.'+'.'" type="application/rss+xml" bookmark="false"/></item>';
foreach ($chars as $char) {
	echo '<item><title>'.strtoupper($char).'</title><enclosure url="'.$configs['hostname'].'search/index.php?q='.$string.$char.'" type="application/rss+xml" bookmark="false"/></item>';
}

echo '</channel></rss>';
}
?>
