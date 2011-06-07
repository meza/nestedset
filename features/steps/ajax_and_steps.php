<?php
/**
 * ajax_and_steps.php
 *
 * @author meza <meza@meza.hu>
 *
 * Step definitions for ajax based behat tests
 */
$steps->And('/^The response code is (\d+)$/', function($world, $responseCode) {
	$code = $world->curl->lastHTTPCode();
	assertEquals($responseCode, $code);
});
?>