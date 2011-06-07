<?php
/**
 * nestedSet_steps.php
 *
 * @author meza <meza@meza.hu>
 *
 * Step definitions for lib based behat tests
 */
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

$steps->When('/^I list the tree with (html|table)$/', function($world, $strategy) {
	$s = null;
	if ($strategy == 'html') {
		$s = TreeProcessor::createHtmlTree();
	}
	$world->listHtml = $world->dao->getTree($s);
});

$steps->When('/^I list the tree from node "([^"]*)"$/', function($world, $nodeName) {
    $world->listHtml = $world->dao->getTreeFrom($nodeName, TreeProcessor::createHtmlTree());
});


$steps->Then("/^The resulting html fragment should be '([^']*)'$/", function($world, $expectedHtml) {
    assertEquals($expectedHtml, $world->listHtml);
});



$steps->Then('/^The result is$/', function($world, $table) {
    $set  = $world->dao->getTree();
	$hash = $table->getHash();
	assertEquals($hash, $set);
});
?>