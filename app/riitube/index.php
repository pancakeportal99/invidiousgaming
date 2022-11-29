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
            "\n" => "&#10;"
        )
    );
}
$proxylink = $configs['riitube'];
$fp = fopen($configs['invidious'].$configs['trending'], 'r');
$meta_data = stream_get_contents($fp);
$json = json_decode($meta_data, false);
$json_count = count($json);

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">';
echo '<channel><title>Invidious Gaming</title>';
echo '<atom:link href="'.$configs['hostname'].'" rel="self" type="application/rss+xml" />';
echo '<description>Trending Gaming</description>';
echo '<link>'. xml_entities($configs['hostname']) .'</link>';
echo '<image><url>'.$configs['hostname'].'images/icon.png</url><title>Invidious Gaming</title><link>'.$configs['hostname'].'</link></image>';
echo '<item><title>Search Videos</title><enclosure url="'.$configs['hostname'].'search/index.php" type="application/rss+xml"/></item>';
for ($x = 0; $x < $json_count; $x++) {
	echo '<item><title>'.xml_entities($json[$x]-> title).'</title>';
	echo '<link>'.xml_entities($proxylink.$json[$x]-> videoId).'</link>';
	echo '<guid>'.xml_entities($proxylink.$json[$x]-> videoId).'</guid>';
	$published = new DateTime('@'.$json[0]-> published);
	echo '<pubDate>'.date_format($published,"D, d M Y H:i:s O").'</pubDate>';
	echo '<enclosure url="'.xml_entities($proxylink.$json[$x]-> videoId).'" type="video/mp4" />';
	echo '<media:thumbnail url="http://i1.ytimg.com/vi/'.$json[$x]-> videoId.'/hqdefault.jpg" width="480" height="360"/>';
    echo '<author>'.xml_entities($json[$x]-> author).'</author></item>';
}
echo '</channel></rss>';
?>
