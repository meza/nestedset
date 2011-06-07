<?php
/**
 * Layout.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * Common interface for layouts.
 */
interface Layout
{

	/**
	 * Render the layout with the given data.
	 *
	 * @return string
	 */
	public function render($data='');
}