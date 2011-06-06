<?php
class NodePostCommand implements NodeCommand
{
	private $dao;
	private $nodes;
	private $newNode;

	public function __construct(NestedSetDao $dao, $nodes, $newNode)
	{
		$this->dao     = $dao;
		$this->nodes   = $nodes;
		$this->newNode = $newNode;
	}

	public function execute()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return;
		}
		$nodeName = $this->nodes[$count-1];

		if (isset($this->newNode['name'])) {
			$this->dao->renameNode($nodeName, $this->newNode['name']);
		}
	}
}
?>