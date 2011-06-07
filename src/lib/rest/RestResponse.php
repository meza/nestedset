<?php
/**
 * RestResponse.php
 *
 * @author meza <meza@meza.hu>
 */

/**
 * A RestResponse is created to responde to a request.
 */
class RestResponse
{

	/**
	 * @var string The response code.
	 */
	private $code='200 OK';

	/**
	 * @var string The response body.
	 */
	private $body='';

	/**
	 * @var string The mime type.
	 */
	private $type='text/plain';


	/**
	 * Creates the object.
	 *
	 * @param string $body The response body.
	 * @param string $type The mime type.
	 * @param string $code The response code.
	 *
	 * @return RestResponse
	 */
	public function __construct($body='', $type='text/plain', $code='200 OK')
	{
		$this->code = $code;
		$this->body = $body;
		$this->type = $type;
	}


	/**
	 * Creation method for a response of a successful creation.
	 *
	 * @return RestResponse
	 */
	public static function createCreatedResponse()
	{
		return new RestResponse('','text/plain','201 Created');
	}


	/**
	 * Creation method for a response of an OK
	 *
	 * @return RestResponse
	 */
	public static function createOKResponse()
	{
		return new RestResponse();
	}


	/**
	 * Creation method for a response with an error.
	 *
	 * @param string $msg The error message.
	 *
	 * @return RestResponse
	 */
	public function createErrorResponse($msg)
	{
		return new RestResponse($msg, 'text/plain', '501 Not Implemented');
	}


	/**
	 * Creation method of a html response.
	 *
	 * @param string $data The HTML data
	 *
	 * @return RestResponse
	 */
	public static function createOKWithHtmlDataResponse($data)
	{
		return new RestResponse($data, 'text/html');
	}


	/**
	 * Send the reponse.
	 *
	 * @return void
	 */
	public function send()
	{
		ob_start();
		header('Content-Type: '.$this->type);
		header('HTTP/1.1 '.$this->code);
		echo $this->body;
		ob_end_flush();
	}
}
?>