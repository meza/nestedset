<?php
class NodePostCommand implements NodeCommand
{
	private $dao;
	private $nodes;
	private $postData;

	public function __construct(NestedSetDao $dao, $nodes, $postData)
	{
		$this->dao     = $dao;
		$this->nodes   = $nodes;
		$this->postData = $postData;
	}

	public function execute()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return;
		}
		$nodeName = $this->nodes[$count-1];

		if (false === isset($this->postData[$nodeName])) {
			return;
		}

		$this->dao->renameNode($nodeName, $this->postData[$nodeName]['name']);
	}
}
?>