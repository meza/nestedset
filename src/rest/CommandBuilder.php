<?php
class CommandBuilder
{
	public function getCommand(NestedSetDao $dao, $uri, $method)
	{
		$command = new NoActionCommand($dao);
		if (preg_match_all('/\/node\/(.*)/', $uri, $matches)) {
			$nodePath = $matches[1][0];
			$nodes = explode('/', $nodePath);
			if ($method == 'GET') {
				$command = new NodeGetCommand($dao, $nodes);
			} elseif ($method == 'PUT') {
				$command = new NodePutCommand($dao, $nodes);
			} elseif ($method == 'POST') {
				$nodeName = $nodes[count($nodes)-1];
				if (false == isset($_POST[$nodeName])) {
					return;
				}
				$command = new NodePostCommand($dao, $nodes, $_POST[$nodeName]);
			} elseif ($method == 'DELETE') {
				$command = new NodeDeleteCommand($dao, $nodes);
			}
		}
		return $command;
	}
}
?>