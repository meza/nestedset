<?php
define('SRCDIR', realpath(__DIR__));
define('ROOTDIR', realpath(__DIR__.'/..'));
define('DIST_CONFIG', ROOTDIR.'/run.properties.dist');
define('USER_CONFIG', ROOTDIR.'/run.properties');

require_once(SRCDIR.'/lib/Database.php');
require_once(SRCDIR.'/lib/MysqlDatabase.php');
require_once(SRCDIR.'/lib/NestedSetDao.php');

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

$dao = new NestedSetDao($db);

$scope = $GLOBALS;
$uri = $scope['_SERVER']['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);
$method  = strtoupper($scope['_SERVER']['REQUEST_METHOD']);
$uri     = $path;
$headers = array();
foreach(getallheaders() as $name=>$value) {
    $headers[] = array('name'=>$name, 'value'=>$value);
}

$dp = new RequestDataParser();
$data = $dp->getData($method, $scope);

if (preg_match_all('/\/node\/(.*)/', $uri, $matches)) {
	$nodePath = $matches[1][0];
	$nodes = explode('/', $nodePath);
	if ($method == 'PUT') {
		putNode($dao, $nodes);
	} elseif ($method == 'POST') {
		postNode($dao, $nodes);
	} elseif ($method == 'DELETE') {
		deleteNode($dao, $nodes);
	}

}

function deleteNode($dao, $nodes)
{
	$count = count($nodes);
	if ($count <= 0) {
		return;
	}

	$dao->removeNode($nodes[$count-1]);
}
function postNode($dao, $nodes)
{
	$count = count($nodes);
	if ($count <= 0) {
		return;
	}
	$nodeName = $nodes[$count-1];
	if (false == isset($_POST[$nodeName])) {
		return;
	}

	if (isset($_POST[$nodeName]['name'])) {
		$dao->renameNode($nodeName, $_POST[$nodeName]['name']);
	}
}

function putNode($dao, $nodes)
{
	$count = count($nodes);
	if( $count == 1) {
		$dao->insertNode($nodes[0]);
	} else {
		$dao->insertNode($nodes[$count-1], $nodes[$count-2]);
	}
}

class RequestDataParser {
    public function getData($method, $scope)
    {
        switch(strtolower($method)) {
            case 'delete':  return $this->getDeleteData($scope);
            case 'get':     return $this->getGetData($scope);
            case 'head':    return $this->getHeadData($scope);
            case 'options': return $this->getOptionsData($scope);
            case 'post':    return $this->getPostData($scope);
            case 'put':     return $this->getPutData($scope);
        }

    }

    private function getGetData(array $scope)
    {
        return $scope['_GET'];
    }

    private function getPostData(array $scope)
    {
        return $scope['_POST'];
    }

    private function getPutData()
    {
        $data = file_get_contents('php://input');
        parse_str($data, $result);
        return $result;

    }

    private function getDeleteData(array $scope)
    {
        return $this->getGetData($scope);

    }

    private function getHeadData(array $scope)
    {
        return array();

    }

    private function getOptionsData(array $scope)
    {
        return $this->getPutData($scope);

    }
}

?>