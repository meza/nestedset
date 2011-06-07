<?php
class HtmlVisitor implements Visitor
{
	private $output = '';
	private $path = array();

	public function visitEnter(Node $node)
	{
		$this->path[] = $node->name();
		$this->output .= '<ul>';
	}

	public function visitLeave()
	{
		array_pop($this->path);
		$this->output .= '</li></ul>';
	}

	public function visit(Node $node)
	{
		$this->output.='<li id="'.$node->name().'" name="'.implode('/',$this->path).'">'.$node->name();
	}

	public function output()
	{
		return $this->output;
	}

}
?>