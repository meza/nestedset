<?php
class IndexActionCommand implements NodeCommand
{

	private $dao;
	private $layout;

	public function __construct(NestedSetDao $dao, Layout $layout)
	{
		$this->dao    = $dao;
		$this->layout = $layout;
	}

	public function createResponse()
	{
		return RestResponse::createOKWithHtmlDataResponse($this->layout->render($this->dao->getTree()));
	}
}
?>