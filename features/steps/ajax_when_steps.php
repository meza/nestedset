<?php
$steps->When('/^I http delete the node "([^"]*)"$/', function($world, $nodeName) {
    $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'DELETE');
});

$steps->When('/^I http put a node with the name "([^"]*)"$/', function($world, $nodeName) {
    $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'PUT');
});

$steps->When('/^I http put a node to "([^"]*)" with the name "([^"]*)"$/', function($world, $rootName, $nodeName) {
    $world->curl->call($world->config['http']['baseUrl'].'/node/'.$rootName.'/'.$nodeName, 'PUT');
});

$steps->When('/^I http post to the node "([^"]*)" the name "([^"]*)"$/', function($world, $nodeName, $newNodeName) {
    $world->curl->call($world->config['http']['baseUrl'].'/node/'.$nodeName, 'POST', array($nodeName => array('name' => $newNodeName)));
});
?>