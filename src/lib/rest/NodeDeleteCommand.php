<?php
/**
 * NodeDeleteCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The NodeDeleteCommand gets executed on requesting a given node path with the
 * method: DELETE.
 */
class NodeDeleteCommand implements NodeCommand
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
	 * @return NodeDeleteCommand
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
			return RestResponse::createErrorResponse('No node given');
		}
		$this->dao->removeNode($this->nodes[$count-1]);
		return RestResponse::createOKResponse();
	}
}
?>