<?php
/**
 * NodeGetCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The NodeGetCommand gets executed on requesting a given node path with the
 * method: GET.
 */
class NodeGetCommand implements NodeCommand
{
	/**
	 * @var NestedSetDao The dao to use.
	 */
	private $dao;

	/**
	 * @var string[] The nodes listed in the path.
	 */
	private $nodes;


	/**
	 * Creates the obejct.
	 *
	 * @param NestedSetDao $dao   The dao to use.
	 * @param string[]     $nodes The nodes on the path.
	 *
	 * @return NodeGetCommand
	 */
	public function __construct(NestedSetDao $dao, $nodes)
	{
		$this->dao   = $dao;
		$this->nodes = $nodes;
	}


	/**
	 * Executes the command.
	 *
	 * @return RestResponse
	 */
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