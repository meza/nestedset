<?php
class NodeDeleteCommand implements NodeCommand
{
	private $dao;
	private $nodes;

	public function __construct(NestedSetDao $dao, $nodes)
	{
		$this->dao   = $dao;
		$this->nodes = $nodes;
	}

	public function createResponse()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return RestResponse::createErrorResponse('No node given');
		}
		$this->dao->removeNode($this->nodes[$count-1]);
		return RestResponse::createOKResponse();
	}
}
?>