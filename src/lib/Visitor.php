<?php
interface Visitor
{

	public function visitEnter();
	public function visitLeave();
	public function visit(Node $node);
	public function output();

}
?>