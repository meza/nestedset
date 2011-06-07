<?php
/**
 * IndexActionCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The IndexActionCommand gets executed on requesting the base url.
 */
class IndexActionCommand implements NodeCommand
{

	/**
	 * @var NestedSetDao the dao to use.
	 */
	private $dao;

	/**
	 * @var Layout The layout to use as template.
	 */
	private $layout;


	/**
	 * Creates the object.
	 *
	 * @param NestedSetDao $dao    The dao to use.
	 * @param Layout       $layout The template.
	 *
	 * @return IndexActionCommand
	 */
	public function __construct(NestedSetDao $dao, Layout $layout)
	{
		$this->dao    = $dao;
		$this->layout = $layout;
	}


	/**
	 * Execute the command.
	 *
	 * @return RestResoponse
	 */
	public function createResponse()
	{
		return RestResponse::createOKWithHtmlDataResponse(
			$this->layout->render(
				$this->dao->getTree(TreeProcessor::createHtmlTree())
			)
		);
	}
}
?>