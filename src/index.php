<?php
define('SRCDIR', realpath(__DIR__));
define('ROOTDIR', realpath(__DIR__.'/..'));
define('DIST_CONFIG', ROOTDIR.'/run.properties.dist');
define('USER_CONFIG', ROOTDIR.'/run.properties');


require_once(SRCDIR.'/view/Layout.php');
require_once(SRCDIR.'/view/HtmlLayout.php');
require_once(SRCDIR.'/lib/rest/RestResponse.php');
require_once(SRCDIR.'/lib/rest/CommandBuilder.php');
require_once(SRCDIR.'/lib/rest/NodeCommand.php');
require_once(SRCDIR.'/lib/rest/IndexActionCommand.php');
require_once(SRCDIR.'/lib/rest/NodePutCommand.php');
require_once(SRCDIR.'/lib/rest/NodePostCommand.php');
require_once(SRCDIR.'/lib/rest/NodeGetCommand.php');
require_once(SRCDIR.'/lib/rest/NodeDeleteCommand.php');
require_once(SRCDIR.'/lib/NestedSet/Database.php');
require_once(SRCDIR.'/lib/NestedSet/MysqlDatabase.php');
require_once(SRCDIR.'/lib/NestedSet/NestedSetDao.php');
require_once(SRCDIR.'/lib/NestedSet/Visitor.php');
require_once(SRCDIR.'/lib/NestedSet/HtmlVisitor.php');
require_once(SRCDIR.'/lib/NestedSet/Node.php');

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
$command        = $commandBuilder->getCommand($dao, $path, $method, $_POST, new HtmlLayout(__DIR__.'/templates/index.html'));
$response       = $command->createResponse();

$response->send();

?>