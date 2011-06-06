<?php
class NoActionCommand implements NodeCommand
{

	private $dao;

	public function __construct(NestedSetDao $dao)
	{
		$this->dao = $dao;
	}

	public function execute()
	{
		print $this->dao->getTree();
	}
}
?>