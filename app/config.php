<?php
$appname = 'invidiousgaming.herokuapp.com';
return array(
	'hostname' => 'http://' .$appname. '/',
	'invidious' => 'https://vid.puffyan.us',
	'trending' => '/api/v1/trending?fields=title,videoId,author,lengthSeconds,published&type=Gaming',
	'default' => '/api/v1/trending?fields=title,videoId,author,lengthSeconds,published&type=Default',
	'search' => '/api/v1/search?fields=title,videoId,author,lengthSeconds,published',
	'videourl' => '/latest_version?itag=18&id=',
	'riitube' => 'http://riitube.rc24.xyz/video/wii/?q='
);
