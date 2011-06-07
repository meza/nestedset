<?php
/**
 * NestedSetDao.php
 *
 * Holds the NestedSetDao class
 *
 * @package  ingatlancomtest
 * @author   meza <meza@meza.hu>
 */

/**
 * The NestedSetDao class is responsible for ...
 */
class NestedSetDao
{

	private $db;

	public function __construct(Database $db)
	{
		$this->db = $db;
	}


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

	public function getTreeFrom($nodeName, TreeProcessor $strategy=null)
	{
		return $this->getTree($strategy, $nodeName);
	}

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

		return $this->db->transaction($sql);

	}

	public function removeNode($nodeName)
	{
		$sql = array(
				'SELECT @left:=lft,@right:=rht,@width:=rht-lft+1 FROM tree WHERE name="'.$nodeName.'";',
				'DELETE FROM tree WHERE lft BETWEEN @left AND @right;',
				'UPDATE tree SET rht=rht-@width WHERE rht > @right;',
				'UPDATE tree SET lft=lft-@width WHERE lft > @right;',
			);
		return $this->db->transaction($sql);
	}

	public function renameNode($nodeName, $nodeNewName)
	{
		$sql = 'UPDATE tree SET name="'.$nodeNewName.'" WHERE name="'.$nodeName.'";';
		return $this->db->query($sql);
	}

}

//end class
?>