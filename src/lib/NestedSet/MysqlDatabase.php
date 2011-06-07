<?php
/**
 * MysqlDatabase.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Manages database access to MYSQL backend.
 */
class MysqlDatabase implements Database
{

	/**
	 * @var string The database host.
	 */
	private $host;

	/**
	 * @var string The concrete database to use.
	 */
	private $db;

	/**
	 * @var string The username to connect with.
	 */
	private $user;

	/**
	 * @var string The password to connect with.
	 */
	private $pass;

	/**
	 * @var resource The mysql connection.
	 */
	private $connection;


	/**
	 * Creates a MysqlDatabase object.
	 *
	 * @param string $host The host to connect to.
	 * @param string $user The username to connect with.
	 * @param string $pass The password to connect with.
	 * @param string $db   The database to use.
	 *
	 * @return MysqlDatabase
	 */
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


	/**
	 * Do a gracefull shutdown if possible.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		if(is_resource($this->connection)) {
			mysql_close($this->connection);
		}
	}


	/**
	 * Fetch a mysql link
	 *
	 * @return resource
	 */
	private function getConnection()
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


	/**
	 * Run a given query on the db
	 *
	 * @return resource
	 */
	public function query($query)
	{
		return mysql_query($query, $this->getConnection());
	}


	/**
	 * Run multiple queries in a transaction to avoid
	 * concurrent indexes.
	 *
	 * @return array
	 */
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