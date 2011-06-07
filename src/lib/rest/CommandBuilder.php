<?php
/**
 * CommandBuilder.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Decide which NodeCommand to utilize regarding the incoming HTTP information.
 */
class CommandBuilder
{


	/**
	 * Create a NodeCommand to execute.
	 *
	 * @param NestedSetDao $dao      The dao to use.
	 * @param string       $uri      The uri called.
	 * @param string       $method   The HTTP method of the request.
	 * @param array        $postData The post data.
	 * @param Layout       $layout   The layout to use.
	 *
	 * @return NodeCommand
	 */
	public function getCommand(
		NestedSetDao $dao,
		$uri,
		$method,
		$postData,
		Layout $layout=null
	) {
		if (preg_match_all('/\/node\/(.*)/', $uri, $matches)) {
			$nodePath = $matches[1][0];
			$nodes    = explode('/', $nodePath);
			switch($method) {
				case 'PUT'   : return new NodePutCommand($dao, $nodes);
				case 'POST'  : return new NodePostCommand($dao, $nodes, $postData);
				case 'DELETE': return new NodeDeleteCommand($dao, $nodes);
				case 'GET'   : return new NodeGetCommand($dao, $nodes);
				default      : return RestResponse::createErrorResponse('Error');
			}
		}
		return new IndexActionCommand($dao, $layout);
	}
}
?>