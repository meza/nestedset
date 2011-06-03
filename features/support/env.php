<?php

require_once('PHPUnit/Autoload.php');
require_once('PHPUnit/Framework/Assert/Functions.php');

require_once(SRCDIR.'/Database.php');
require_once(SRCDIR.'/MysqlDatabase.php');
require_once(SRCDIR.'/NestedSetDao.php');
require_once(SRCDIR.'/NestedSet.php');

$world->db = new MysqlDatabase(
	'192.168.56.101',
	'ns',
	'ns',
	'ns'
);

$world->dao = new NestedSetDao($world->db);

?>