<?php
define('SRCDIR', realpath(__DIR__));
define('ROOTDIR', realpath(__DIR__.'/..'));
define('DIST_CONFIG', ROOTDIR.'/run.properties.dist');
define('USER_CONFIG', ROOTDIR.'/run.properties');


require_once(SRCDIR.'/rest/CommandBuilder.php');
require_once(SRCDIR.'/rest/NodeCommand.php');
require_once(SRCDIR.'/rest/NoActionCommand.php');
require_once(SRCDIR.'/rest/NodePutCommand.php');
require_once(SRCDIR.'/rest/NodePostCommand.php');
require_once(SRCDIR.'/rest/NodeGetCommand.php');
require_once(SRCDIR.'/rest/NodeDeleteCommand.php');
require_once(SRCDIR.'/lib/Database.php');
require_once(SRCDIR.'/lib/MysqlDatabase.php');
require_once(SRCDIR.'/lib/NestedSetDao.php');
require_once(SRCDIR.'/lib/Visitor.php');
require_once(SRCDIR.'/lib/HtmlVisitor.php');
require_once(SRCDIR.'/lib/Node.php');

$distConfig = parse_ini_file(DIST_CONFIG, true);
$userConfig = array();
if (file_exists(USER_CONFIG)) {
	$userConfig = parse_ini_file(USER_CONFIG, true);
}
$config = array_merge($distConfig, $userConfig);

$db = new MysqlDatabase(
    $config['database']['host'],
    $config['database']['user'],
    $config['database']['pass'],
    $config['database']['db']
);

$dao    = new NestedSetDao($db);
$path   = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtoupper($_SERVER['REQUEST_METHOD']);

$commandBuilder = new CommandBuilder();
$commandBuilder->getCommand($dao, $path, $method)->execute();

?>