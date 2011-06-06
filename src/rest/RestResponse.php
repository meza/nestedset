<?php
class RestResponse
{
	private $code='200 OK';
	private $body='';
	private $type='text/plain';
	
	public function __construct($body='', $type='text/plain', $code='200 OK')
	{
		$this->code = $code;
		$this->body = $body;
		$this->type = $type;
	}

	public static function createCreatedResponse()
	{
		return new RestResponse('','text/plain','201 Created');
	}

	public static function createOKResponse()
	{
		return new RestResponse();
	}

	public function createErrorResponse($msg)
	{
		return new RestResponse($msg, 'text/plain', '501 Not Implemented');
	}

	public static function createOKWithHtmlDataResponse($data)
	{
		return new RestResponse($data, 'text/html');
	}

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