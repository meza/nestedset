<?php
class HtmlLayout implements Layout
{

	private $layoutFile;

	public function __construct($layoutFile)
	{
		$this->layoutFile = $layoutFile;
	}

	public function render($data='')
	{
		$template = file_get_contents($this->layoutFile);
		$data     = str_replace('###tree###', $data, $template);
		return $data;
	}
}
?>