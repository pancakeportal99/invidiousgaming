<?php
$configs = include('../config.php');
header('Content-type: text/plain');
$fp = fopen($configs['invidious'].$configs['trending'], 'r');
$meta_data = stream_get_contents($fp);
$json = json_decode($meta_data, false);
$json_count = count($json);

echo '[Playlist]'.PHP_EOL;
for ($x = 0; $x < $json_count; $x++) {
	$entries = $x + 1;
	echo 'File'.$entries.'='.$configs['hostname'].'proxy?id='.$json[$x]-> videoId.PHP_EOL;
	echo 'Title'.$entries.'='.$json[$x]-> title.PHP_EOL;
	// echo 'Length'.$entries.'='.$json[$x]-> lengthSeconds.PHP_EOL;
	echo 'Length'.$entries.'=0'.PHP_EOL;
	echo PHP_EOL;
}
// echo 'NumberOfEntries=' . $json_count . PHP_EOL.'Version=2';
?>