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


	public function getTree()
	{
		$qry = array(
			'variables' => 'SELECT @right:=rht FROM tree WHERE lft=1;',
			'resultset' => 'SELECT name, lft, rht FROM tree WHERE lft BETWEEN 1 AND @right ORDER BY lft ASC;',
		);

		$r = $this->db->transaction($qry);
		$c = 0;
		while($pathElement = mysql_fetch_assoc($r['resultset'])) {
			if ($c == 0) {
				$result = new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']);
				$c++;
			} else {
				$result->add(new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']));
			}
		}
		$visitor = new HtmlVisitor();
		$result->accept($visitor);
		return $visitor->output();
	}

	public function getTreeFromNode($nodeName, Visitor $visitor=null)
	{
		$qry = array(
			'variables' => 'SELECT @left:=lft, @right:=rht FROM tree WHERE name="'.$nodeName.'";',
			'resultset' => 'SELECT name, lft, rht FROM tree WHERE lft BETWEEN @left AND @right ORDER BY lft ASC;',
		);
		$r = $this->db->transaction($qry);
		$result = array();
		while($pathElement = mysql_fetch_assoc($r['resultset'])) {
			$result[] = $pathElement;
		}

		return $result;
	}

	public function getHtmlTreeFromNode($nodeName)
	{
		$qry = array(
			'variables' => 'SELECT @left:=lft, @right:=rht FROM tree WHERE name="'.$nodeName.'";',
			'resultset' => 'SELECT name, lft, rht FROM tree WHERE lft BETWEEN @left AND @right ORDER BY lft ASC;',
		);
		$r = $this->db->transaction($qry);
		$c = 0;
		while($pathElement = mysql_fetch_assoc($r['resultset'])) {
			if ($c == 0) {
				$result = new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']);
				$c++;
			} else {
				$result->add(new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']));
			}
		}
		$visitor = new HtmlVisitor();
		$result->accept($visitor);
		return $visitor->output();
	}

	public function getNode($nodeName)
	{
		$qry = 'SELECT lft, rht FROM tree WHERE name="'.$nodeName.'" LIMIT 1';
		return mysql_fetch_assoc($this->db->query($qry));

	}


	public function pathToNode($nodeName)
	{
		$qry = array(
			'variables' => 'SELECT @left:=lft, @right:=rht FROM tree WHERE name="'.$nodeName.'";',
			'resultset' => 'SELECT name FROM tree WHERE lft < @left AND rht > @right ORDER BY lft ASC;'
		);

		$r = $this->db->transaction($qry);
		$result = array();
		while($pathElement = mysql_fetch_assoc($r['resultset'])) {
			$result[] = $pathElement['name'];
		}

		return $result;
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
