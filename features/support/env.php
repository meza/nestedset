<?php

$distConfig = parse_ini_file(TEST_DIST_CONFIG, true);
$userConfig = array();
if (file_exists(TEST_USER_CONFIG)) {
	$userConfig = parse_ini_file(TEST_USER_CONFIG, true);
}

$world->config = array_merge($distConfig, $userConfig);

$world->db = new MysqlDatabase(
	$world->config['database']['host'],
	$world->config['database']['user'],
	$world->config['database']['pass'],
	$world->config['database']['db']
);

$world->curl = new CurlHelper();

$world->dao = new NestedSetDao($world->db);

?>