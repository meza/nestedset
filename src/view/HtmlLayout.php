<?php
/**
 * HtmlLayout.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Html layout of the output.
 */
class HtmlLayout implements Layout
{


	/**
	 * @var string The layout file.
	 */
	private $layoutFile;


	/**
	 * Create the layout
	 *
	 * @param string $layoutFile The layout file to use.
	 */
	public function __construct($layoutFile)
	{
		$this->layoutFile = $layoutFile;
	}


	/**
	 * Render the layout with the given data.
	 *
	 * @param string $data The data to be rendered.
	 *
	 * @return string
	 */
	public function render($data='')
	{
		$template = file_get_contents($this->layoutFile);
		$data     = str_replace('###tree###', $data, $template);
		return $data;
	}
}
?>