<?php
class NodeGetCommand implements NodeCommand
{
	private $dao;
	private $nodes;

	public function __construct(NestedSetDao $dao, array $nodes=array())
	{
		$this->dao   = $dao;
		$this->nodes = $nodes;
	}

	public function createResponse()
	{
		$count = count($this->nodes);
		if ($count <= 0) {
			return RestResponse::createOkWithHtmlDataResponse(
				$this->dao->getTree(
					TreeProcessor::createHtmlTree()
				)
			);
		}
		return RestResponse::createOkWithHtmlDataResponse(
			$this->dao->getTreeFrom(
				$this->nodes[count($this->nodes)-1],
				TreeProcessor::createHtmlTree()
			)
		);
	}
}
?>