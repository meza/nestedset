<?php
/**
 * Visitor.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Visitor interface
 */
interface Visitor
{

	/**
	 * When a new node level is started, this method is called.
	 *
	 * @param Node $node The node that is igniting the call.
	 *
	 * @return void
	 */
	public function visitEnter(Node $node);


	/**
	 * This method is called before exiting the visit session, to enable the
	 * Visitor to close all opend tags
	 *
	 * @return void
	 */
	public function visitLeave();


	/**
	 * The concrete visiting of a Node. The list item is generated from the
	 * state of the visited Node.
	 *
	 * @param Node $node The item being visited
	 *
	 * @return void
	 */
	public function visit(Node $node);


	/**
	 * The accumulation result.
	 *
	 * @return string
	 */
	public function output();

}
?>