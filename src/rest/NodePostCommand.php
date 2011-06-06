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

	public function createResponse()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return Response.createErrorResponse('No node given');
		}
		$nodeName = $this->nodes[$count-1];

		if (false === isset($this->postData[$nodeName])) {
			return Response.createErrorResponse('No new name given');
		}
		$this->dao->renameNode($nodeName, $this->postData[$nodeName]['name']);
		return RestResponse::createOKResponse();
	}
}
?>