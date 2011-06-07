<?php
/**
 * Database.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Database interface acts as a default interface for all database related
 * code. It declares the functions that all implementations should have in order
 * to be compatible with the code using it.
 */
interface Database
{

	/**
	 * Run a given query on the db
	 *
	 * @return resource
	 */
	public function query($query);

	/**
	 * Run multiple queries in a transaction to avoid
	 * concurrent indexes.
	 *
	 * @return array
	 */
	public function transaction(array $queries);

}
?>