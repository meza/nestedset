<?php
class MysqlDatabase implements Database
{
	private $host;
	private $db;
	private $user;
	private $pass;
	private $connection;

	public function __construct(
		$host,
		$user,
		$pass,
		$db
	)
	{
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db   = $db;
	}

	public function __destruct()
	{
		if(is_resource($this->connection)) {
			mysql_close($this->connection);
		}
	}

	public function getConnection()
	{
		if (is_resource($this->connection))
		{
			return $this->connection;
		}

		$this->connection = mysql_connect(
			$this->host,
			$this->user,
			$this->pass,
			true
		);

		if (false == $this->connection) {
			throw new Exception('Mysql Connection Error');
		}
		if(false == mysql_select_db($this->db, $this->connection)) {
			throw new Exception('Mysql database select failure: '.mysql_error());
		}
		return $this->connection;
	}

	public function query($query)
	{
		return mysql_query($query, $this->getConnection());
	}

	public function transaction(array $queries)
	{
		$result = array();

		$this->query('START TRANSACTION;');
		foreach ($queries as $queryName => $query) {
			$result[$queryName] = $this->query($query);
		}
		$this->query('COMMIT;');
		return $result;
	}

}
?>