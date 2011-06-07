<?php
/**
 * CurlHelper.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * CurlHelper
 *
 * A helper object to the behat tests so that it can try all
 * http related REST calls.
 */
class CurlHelper
{

	/**
	 * @var int The last response code
	 */
	private $lastHTTPCode;


	/**
	 * Fetch the last call's response code
	 *
	 * @return int
	 */
	public function lastHTTPCode()
	{
		return $this->lastHTTPCode;
	}

	/**
	 * Call a given url with the given method and data.
	 *
	 * @param string $url    Which URL to call
	 * @param string $method The HTTP Method to use
	 * @param array  $data   The message's data
	 *
	 * @return string The call's response text
	 */
	public function call($url, $method='GET', $data=array())
	{
		$method = strtoupper($method);
		$ch     = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		if ($method!='GET') {
			curl_setopt($ch, CURLOPT_POST, 1);
			if ($method != 'POST') {
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
			}
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->formatData($data));
		} else {
			curl_setopt($ch, CURLOPT_URL, $url.'?'.$this->formatData($data));
		}
		$result = curl_exec($ch);
		$this->lastHTTPCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return $result;
	}

	/**
	 * Formats the given value to a query string
	 *
	 * @param mixed $data String, object, array -> query string
	 *
	 * @return void
	 */
	private function formatData($data)
	{
		if (true === is_array($data)) {
			$data = http_build_query($data);
		} else if (true === is_object($data)) {
			$data = http_build_query(get_object_vars($data));
		}
		return (string) $data;
	}

}
?>