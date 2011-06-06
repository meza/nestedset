<?php
class Node
{
	private $children = array();
	private $name;
	private $left=1;
	private $right=2;

	public function __construct(
		$name,
		$left=1,
		$right=2
	) {
		$this->name  = $name;
		$this->left  = $left;
		$this->right = $right;
	}

	public function accept(Visitor $visitor)
	{
		$visitor->visitEnter();
		$visitor->visit($this);
		foreach ($this->children as $child)
		{
			$child->accept($visitor);
		}
		$visitor->visitLeave();
	}


	public function add(Node $node)
	{
		foreach ($this->children as $child)
		{
			if ($child->left() < $node->left()) {
				if ($child->right() > $node->right()) {
					$child->add($node);
					return;
				}
			}
		}
		$this->children[] = $node;
	}

	public function left()
	{
		return $this->left;
	}

	public function right()
	{
		return $this->right;
	}

	public function name()
	{
		return $this->name;
	}
}
?>