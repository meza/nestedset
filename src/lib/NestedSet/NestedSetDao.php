<?php
/**
 * NestedSetDao.php
 *
 * @author   meza <meza@meza.hu>
 */

/**
 * The NestedSetDao class is responsible for communicating with the given
 * Database instance.
 */
class NestedSetDao
{

	/**
	 * @var Database instance to use.
	 */
	private $db;


	/**
	 * Create the object.
	 *
	 * @param Database $db The Database instance to use.
	 *
	 * @return NestedSetDao
	 */
	public function __construct(Database $db)
	{
		$this->db = $db;
	}


	/**
	 * Retrieve a tree representation of the nodes.
	 *
	 * @param TreeProcessor $strategy The rocess startegy to use
	 * @param string        $nodeName The node name to originate the tree from
	 *
	 * @return mixed - Depends on the strategy used.
	 *
	 * @todo Unify the output.
	 */
	public function getTree(TreeProcessor $strategy=null, $nodeName=null)
	{
		if(null == $nodeName) {
			$qry = array(
				'variables' => 'SELECT @right:=rht FROM tree WHERE lft=1;',
				'resultset' => 'SELECT name, lft, rht FROM tree WHERE lft BETWEEN 1 AND @right ORDER BY lft ASC;',
			);
		} else {
			$qry = array(
				'variables' => 'SELECT @left:=lft, @right:=rht FROM tree WHERE name="'.$nodeName.'";',
				'resultset' => 'SELECT name, lft, rht FROM tree WHERE lft BETWEEN @left AND @right ORDER BY lft ASC;',
			);
		}

		$r = $this->db->transaction($qry);
		if (null == $strategy) {
			$result = array();
			while($pathElement = mysql_fetch_assoc($r['resultset'])) {
				$result[] = $pathElement;
			}
			return $result;
		}

		return $strategy->processTree($r['resultset']);


	}


	/**
	 * Shorthand to get the tree rooted from a given node.
	 *
	 * @param string        $nodeName The node name to originate from.
	 * @param TreeProcessor $strategy The strategy to use.
	 *
	 * @return mixed. Depends on the strategy.
	 * @todo Unify return.
	 * @todo eliminate duplication.
	 */
	public function getTreeFrom($nodeName, TreeProcessor $strategy=null)
	{
		return $this->getTree($strategy, $nodeName);
	}

	/**
	 * Insert a node under a parent.
	 *
	 * @param string $nodeName   The new child node's name.
	 * @param string $parentName The parent node's name.
	 *
	 * @return void
	 */
	public function insertNode($nodeName, $parentName='')
	{
		if (empty($parentName)) {
			$sql = array('INSERT INTO tree SET lft=1, rht=2, name="'.$nodeName.'"');
		} else {
			$sql = array(
				'SELECT @right:=rht-1 FROM tree WHERE name="'.$parentName.'";',
				'UPDATE tree SET rht=rht+2 WHERE rht>@right;',
				'UPDATE tree SET lft=lft+2 WHERE lft>@right;',
				'INSERT INTO tree SET lft=@right+1, rht=@right+2, name="'.$nodeName.'";'
			);
		}

		$this->db->transaction($sql);
	}


	/**
	 * Removes a node.
	 *
	 * @param string $nodeName The node name to remove.
	 *
	 * @return void
	 */
	public function removeNode($nodeName)
	{
		$sql = array(
				'SELECT @left:=lft,@right:=rht,@width:=rht-lft+1 FROM tree WHERE name="'.$nodeName.'";',
				'DELETE FROM tree WHERE lft BETWEEN @left AND @right;',
				'UPDATE tree SET rht=rht-@width WHERE rht > @right;',
				'UPDATE tree SET lft=lft-@width WHERE lft > @right;',
			);
		$this->db->transaction($sql);
	}


	/**
	 * Rename a node.
	 *
	 * @param string $nodeName    The original name of the node.
	 * @param string $nodeNewName The new name of the node.
	 */
	public function renameNode($nodeName, $nodeNewName)
	{
		$sql = 'UPDATE tree SET name="'.$nodeNewName.'" WHERE name="'.$nodeName.'";';
		$this->db->query($sql);
	}

}
?>
