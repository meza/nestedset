<?php
/**
 * NodePostCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The NodePostCommand gets executed on requesting a given node path with the
 * method: POST.
 */
class NodePostCommand implements NodeCommand
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
	 * @var array Post data
	 */
	private $postData;


	/**
	 * Creates the obejct.
	 *
	 * @param NestedSetDao $dao      The dao to use.
	 * @param string[]     $nodes    The nodes on the path.
	 * @param array        $postData the post data.
	 *
	 * @return NodePostCommand
	 */
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
			return RestResponse::createErrorResponse('No node given');
		}
		$nodeName = $this->nodes[$count-1];
		if (false === isset($this->postData['name'])) {
			return RestResponse::createErrorResponse('No new name given');
		}
		$this->dao->renameNode($nodeName, $this->postData['name']);
		return RestResponse::createOKResponse();
	}
}
?>