<?php
class NestedSet {

	private $set = array();

	public function addNode($name)
	{
		$elementCount = count($this->set);
		$left  = 1 * $elementCount+1;
		$right = $left + 1;
		$this->set[] = array(
			'name' => $name,
			'lft'  => $left,
			'rht'  => $right,
		);
	}
	public function getSet(){
		return $this->set;
	}
}
?>