<?php
class NodePutCommand implements NodeCommand
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
		if( $count == 1) {
			$this->dao->insertNode($this->nodes[0]);
		} else {
			$this->dao->insertNode($this->nodes[$count-1], $this->nodes[$count-2]);
		}
	}
}
?>