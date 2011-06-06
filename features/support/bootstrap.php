<?php

define('SRCDIR', realpath(__DIR__.'/../../src'));
define('ROOTDIR', realpath(__DIR__.'/../..'));


require_once('PHPUnit/Autoload.php');
require_once('PHPUnit/Framework/Assert/Functions.php');

require_once(SRCDIR.'/lib/Database.php');
require_once(SRCDIR.'/lib/MysqlDatabase.php');
require_once(SRCDIR.'/lib/Visitor.php');
require_once(SRCDIR.'/lib/HtmlVisitor.php');
require_once(SRCDIR.'/lib/Node.php');
require_once(SRCDIR.'/lib/NestedSetDao.php');
require_once(__DIR__.'/CurlHelper.php');

define('TEST_DIST_CONFIG', ROOTDIR.'/test.properties.dist');
define('TEST_USER_CONFIG', ROOTDIR.'/test.properties');
?>
