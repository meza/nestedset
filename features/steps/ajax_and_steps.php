<?php
$steps->And('/^The response code is (\d+)$/', function($world, $responseCode) {
	$code = $world->curl->lastHTTPCode();
	assertEquals($responseCode, $code);
});
?>