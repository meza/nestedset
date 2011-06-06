<?php
class CommandBuilder
{
	public function getCommand(NestedSetDao $dao, $uri, $method, $postData)
	{
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
		return new IndexActionCommand($dao);
	}
}
?>