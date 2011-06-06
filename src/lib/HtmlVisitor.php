<?php
class HtmlVisitor implements Visitor
{
	private $output = '';

	public function visitEnter()
	{
		$this->output .= '<ul>';
	}

	public function visitLeave()
	{
		$this->output .= '</li></ul>';
	}

	public function visit(Node $node)
	{
		$this->output.='<li>'.$node->name();
	}

	public function output()
	{
		return $this->output;
	}

}
?>