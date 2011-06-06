<?php
class NodeGetCommand implements NodeCommand
{
	private $dao;
	private $nodes;

	public function __construct(NestedSetDao $dao, $nodes)
	{
		$this->dao   = $dao;
		$this->nodes = $nodes;
	}

	public function execute()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return;
		}
		print $this->dao->getHtmlTreeFromNode($this->nodes[$count-1]);
	}
}
?>