<?php

$distConfig = parse_ini_file(TEST_DIST_CONFIG, true);
$userConfig = array();
if (file_exists(TEST_USER_CONFIG)) {
	$userConfig = parse_ini_file(TEST_USER_CONFIG, true);
}

$config = array_merge($distConfig, $userConfig);

$world->db = new MysqlDatabase(
	$config['database']['host'],
	$config['database']['user'],
	$config['database']['pass'],
	$config['database']['db']
);

$world->dao = new NestedSetDao($world->db);

?>