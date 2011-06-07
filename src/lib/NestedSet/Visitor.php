<?php
interface Visitor
{

	public function visitEnter(Node $node);
	public function visitLeave();
	public function visit(Node $node);
	public function output();

}
?>