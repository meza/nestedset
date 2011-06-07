<?php
interface NodeCommand
{
	/**
	 * Executes a command
	 *
	 * @return Response
	 */
	public function createResponse();
}
?>