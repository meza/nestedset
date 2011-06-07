<?php
/**
 * TreeProcessor.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Tree processor strategy to add Node creation and Visitor traversing
 * to the NestedSetDao::getTree calls.
 */
class TreeProcessor
{

	/**
	 * @var Visitor The visitor to utilize.
	 */
	private $visitor;


	/**
	 * Creates the object.
	 *
	 * @param Visitor $visitor The Visitor to use.
	 *
	 * @return TreeProcessor.
	 */
	public function __construct(Visitor $visitor=null)
	{
		$this->visitor = $visitor;
	}


	/**
	 * A static creation method to keep the creation logic in one place.
	 *
	 * @return TreeProcessor
	 */
	public static function createHtmlTree()
	{
		return new TreeProcessor(new HtmlVisitor());
	}


	/**
	 * Process a mysql result set.
	 *
	 * @param resource $mysqlResource The mysql resource that can be traversed.
	 *
	 * @return mixed. Depends on the visitor presence.
	 * @todo Unify output.
	 */
	public function processTree($mysqlResource)
	{
		$c      = 0;
		$result = new Node('empty set');
		while($pathElement = mysql_fetch_assoc($mysqlResource)) {
			if ($c == 0) {
				$result = new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']);
				$c++;
			} else {
				$result->add(new Node($pathElement['name'], $pathElement['lft'], $pathElement['rht']));
			}
		}
		if (null == $this->visitor) {
			return $result;
		}

		$result->accept($this->visitor);
		return $this->visitor->output();

	}
}

?>
