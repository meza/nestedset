<?php
$steps->Given('/^I have an empty set$/', function($world) {
    $world->db->query('TRUNCATE TABLE tree;');
});

$steps->Given('/^I have a set$/', function($world, $table) {
	$world->db->query('TRUNCATE TABLE tree;');
    $hash = $table->getHash();
	foreach($hash as $row) {
		$world->db->query(
		'INSERT INTO tree VALUES(
			"'.$row['name'].'",
			'.$row['lft'].',
			'.$row['rht'].');'
		);
	}
});

$steps->When('/^I enter a node under "([^"]*)" with the name "([^"]*)"$/', function($world, $root, $node) {
    $world->dao->insertNode($node, $root);
});

$steps->When('/^I enter a node with the name "([^"]*)"$/', function($world, $node) {
    $world->dao->insertNode($node);
});

$steps->When('/^I remove the node "([^"]*)"$/', function($world, $node) {
    $world->dao->removeNode($node);
});

$steps->When('/^I rename the node "([^"]*)" to "([^"]*)"$/', function($world, $nodeName, $nodeNewName) {
    $world->dao->renameNode($nodeName, $nodeNewName);
});


$steps->Then('/^The result is$/', function($world, $table) {
    $set  = $world->dao->getTreeFromNode('Root');
	$hash = $table->getHash();
	assertEquals($hash, $set);
});
?>