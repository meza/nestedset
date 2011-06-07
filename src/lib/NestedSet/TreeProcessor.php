<?php

class TreeProcessor
{

	private $visitor;

	public function __construct(Visitor $visitor=null)
	{
		$this->visitor = $visitor;
	}

	public static function createHtmlTree()
	{
		return new TreeProcessor(new HtmlVisitor());
	}


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
