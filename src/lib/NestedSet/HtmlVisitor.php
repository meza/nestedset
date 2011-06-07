<?php
/**
 * HtmlVisitor.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * HtmlVisitor is the visitor that traverses the nodes of the tree in order to
 * transform that tree into a html unordered list.
 */
class HtmlVisitor implements Visitor
{

	/**
	 * @var string HTML Output
	 */
	private $output = '';

	/**
	 * @var array path of a given node
	 */
	private $path = array();

	/**
	 * @var bool isFirst
	 */
	private $isFirst = true;


	/**
	 * When a new node level is started, this method is called.
	 *
	 * @param Node $node The node that is igniting the call.
	 *
	 * @return void
	 */
	public function visitEnter(Node $node)
	{
		$this->path[] = $node->name();
		$this->output .= '<ul>';
	}


	/**
	 * This method is called before exiting the visit session, to enable the
	 * Visitor to close all opend tags
	 *
	 * @return void
	 */
	public function visitLeave()
	{
		array_pop($this->path);
		$this->output .= '</li></ul>';
	}


	/**
	 * The concrete visiting of a Node. The list item is generated from the
	 * state of the visited Node.
	 *
	 * @param Node $node The item being visited
	 *
	 * @return void
	 */
	public function visit(Node $node)
	{
		$class = '';
		if ($this->isFirst) {
			$class=' class="root"';
			$this->isFirst = false;
		}
		$this->output.='<li'.$class.' id="'.$node->name().'" name="'.implode('/',$this->path).'">'.$node->name();
	}


	/**
	 * The HTML unordered list representation of the traversed Node composite.
	 *
	 * @return string
	 */
	public function output()
	{
		return $this->output;
	}

}
?>