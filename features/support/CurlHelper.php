<?php
class CurlHelper
{
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
		curl_close($ch);
	}

	/**
	 * Formats the given value to a query string
	 *
	 * @param mixed $data String, object, array -> query string
	 *
	 * @return void
	 */
	public function formatData($data)
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