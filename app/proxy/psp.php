<?php
$configs = include('../config.php');
if (isset($_GET['id'])) {
define('FFMPEG_LIBRARY', '/app/vendor/ffmpegffmpeg');
$file_name = $_GET['id'].".mp4";
$mime_type = "video/mp4";
$attachment = (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) ? "" : " attachment";
$url = $configs['invidious'].$configs['videourl'].$_GET['id'];
$fp = fopen($url, 'r');
$meta_data = stream_get_meta_data($fp);
foreach ($meta_data['wrapper_data'] as $response) {
	if (strtolower(substr($response, 0, 10)) == 'location: ') {
	$url = substr($response, 10);
}
}
header("Content-Type: $mime_type");
header('Content-Transfer-Encoding: binary');
header("Content-Disposition: $attachment; filename=\"$file_name\"");
passthru(FFMPEG_LIBRARY." -y -i \"".escapeshellarg($url)."\" -flags +bitexact -vcodec mpeg4 -vtag xvid -level 3.0 -s 480x272 -r 29.97 -b:v 768k -acodec aac -b:a 64k -ar 44100 -f avi -strict -2 -");
echo $output;
} else {
echo 'ID not set';
}
?>