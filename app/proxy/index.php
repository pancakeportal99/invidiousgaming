<?php

function download_file_chunked($path) {
	$file_name = $_GET['id'].".mp4";

	// get the file's mime type to send the correct content type header
	//$finfo = finfo_open(FILEINFO_MIME_TYPE); //For remote file, it may not work
	//$mime_type = finfo_file($finfo, $path); //For remote file, it may not work
	$mime_type = "video/mp4";

	$attachment = (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) ? "" : " attachment"; // IE 5.5 fix.

	// send the headers	
	header("Content-Type: $mime_type");
	header('Content-Transfer-Encoding: binary');
	//header('Content-Length: ' . filesize($path)); //PHP Warning: filesize(): stat failed for remote file
	//header("Content-Disposition: attachment; filename=$file_name;");
	header("Content-Disposition: $attachment; filename=\"$file_name\"");

	$options = array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	);
	
	$context  = stream_context_create($options);

    $handle = fopen($path, 'rb');	
	//$handle = fopen($path, 'rb', false, $context);
	
	ob_end_clean();//output buffering is disabled, so you won't hit your memory limit
	
	$buffer = '';
	$chunkSize = 1024 * 1024;
	
	//$newfname = basename($path);
	//$newf = fopen ($newfname, "wb");

	ob_start();
    while (!feof($handle)) {
        $buffer = fread($handle, $chunkSize);		
        echo $buffer;
        ob_flush();
        flush();
		
		//fwrite($newf, $buffer, $chunkSize);
    }
	
    fclose($handle);
	
	//fclose($newf);
	
	exit;
}

$configs = include('../config.php');
if (isset($_GET['id'])) {
$url = $configs['invidious'].$configs['videourl'].$_GET['id'];
$fp = fopen($url, 'r');
$meta_data = stream_get_meta_data($fp);
foreach ($meta_data['wrapper_data'] as $response) {
	if (strtolower(substr($response, 0, 10)) == 'location: ') {
	$url = substr($response, 10);
}
}
download_file_chunked($url);
} else {
echo 'ID not set';
}
?>