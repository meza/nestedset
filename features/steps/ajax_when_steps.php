<?php
/**
 * ajax_when_steps.php
 *
 * @author meza <meza@meza.hu>
 *
 * Step definitions for ajax based behat tests
 */
$steps->When('/^I http delete the node "([^"]*)"$/', function($world, $nodeName) {
    $world->lastCurlHandler = $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'DELETE');
});

$steps->When('/^I http put a node with the name "([^"]*)"$/', function($world, $nodeName) {
    $world->lastCurlHandler = $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'PUT');
});

$steps->When('/^I http put a node to "([^"]*)" with the name "([^"]*)"$/', function($world, $rootName, $nodeName) {
    $world->lastCurlHandler = $world->curl->call($world->config['http']['baseUrl'].'/node/'.$rootName.'/'.$nodeName, 'PUT');
});

$steps->When('/^I http post to the node "([^"]*)" the name "([^"]*)"$/', function($world, $nodeName, $newNodeName) {
    $world->lastCurlHandler = $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'POST', array('name' => $newNodeName));
});
?>