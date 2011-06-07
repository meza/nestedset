<?php
/**
 * NodeCommand.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * The NodeCommand interface groups all command that can be ececuted in the app.
 */
interface NodeCommand
{
	/**
	 * Executes a command
	 *
	 * @return RestResponse
	 */
	public function createResponse();
}
?>