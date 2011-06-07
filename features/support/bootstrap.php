<?php

define('SRCDIR', realpath(__DIR__.'/../../src'));
define('ROOTDIR', realpath(__DIR__.'/../..'));


require_once('PHPUnit/Autoload.php');
require_once('PHPUnit/Framework/Assert/Functions.php');

require_once(SRCDIR.'/lib/NestedSet/TreeProcessor.php');
require_once(SRCDIR.'/lib/NestedSet/Database.php');
require_once(SRCDIR.'/lib/NestedSet/MysqlDatabase.php');
require_once(SRCDIR.'/lib/NestedSet/Visitor.php');
require_once(SRCDIR.'/lib/NestedSet/HtmlVisitor.php');
require_once(SRCDIR.'/lib/NestedSet/Node.php');
require_once(SRCDIR.'/lib/NestedSet/NestedSetDao.php');
require_once(__DIR__.'/CurlHelper.php');

define('TEST_DIST_CONFIG', ROOTDIR.'/test.properties.dist');
define('TEST_USER_CONFIG', ROOTDIR.'/test.properties');
?>
