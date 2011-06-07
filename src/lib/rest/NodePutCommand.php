<?php
/**
 * NodePutCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The NodePutCommand gets executed on requesting a given node path with the
 * method: PUT.
 */
class NodePutCommand implements NodeCommand
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
	 * @return NodePutCommand
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
		if( $count == 1) {
			$this->dao->insertNode($this->nodes[0]);
		} else {
			$this->dao->insertNode($this->nodes[$count-1], $this->nodes[$count-2]);
		}

		return RestResponse::createCreatedResponse();
	}
}
?>