<?php
/**
 * Node.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * A Node composite representating the stored tree.
 */
class Node
{

	/**
	 * @var Node[] The child nodes of the current Node
	 */
	private $children = array();

	/**
	 * @var string The name of the node.
	 */
	private $name;

	/**
	 * @var int the left number in the nested set.
	 */
	private $left=1;

	/**
	 * @var int the right number in the nested set.
	 */
	private $right=2;


	/**
	 * Create a Node
	 *
	 * @param string $name  The name of the Node.
	 * @param int    $left  The left number of the Node.
	 * @param int    $right The right number of the Node.
	 *
	 * @return Node
	 */
	public function __construct(
		$name,
		$left=1,
		$right=2
	) {
		$this->name  = $name;
		$this->left  = $left;
		$this->right = $right;
	}


	/**
	 * ÍThe Visitor entrance.
	 *
	 * @param Visitor $visitor The visitor to serve.
	 *
	 * @return void.
	 */
	public function accept(Visitor $visitor)
	{
		$visitor->visitEnter($this);
		$visitor->visit($this);
		foreach ($this->children as $child)
		{
			$child->accept($visitor);
		}
		$visitor->visitLeave();
	}


	/**
	 * Add a Node by finding it's place in the composite.
	 *
	 * @param Node $node The Node to add.
	 *
	 * @return void
	 */
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


	/**
	 * The left number of the Node.
	 *
	 * @return int
	 */
	private function left()
	{
		return $this->left;
	}


	/**
	 * The right number of the Node.
	 *
	 * @return int
	 */
	private function right()
	{
		return $this->right;
	}


	/**
	 * The name of the Node
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}
}
?>