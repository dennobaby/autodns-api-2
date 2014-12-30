<?php

namespace Autodns\Test\Api;

class ErrorTest extends \PHPUnit_Framework_TestCase
{
	private $errors;

	protected function setUp()
	{
		$this->errors = array();
		set_error_handler(array( $this, "errorHandler" ));
	}

	public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		$this->errors[] = compact( "errno", "errstr", "errfile", "errline", "errcontext" );
	}

	public function assertError($errstr, $errno)
	{
		foreach ( $this->errors as $error ) {
			if ( $error['errstr'] === $errstr && $error['errno'] === $errno ) {
				return;
			}
		}
		$this->fail("Error with level {$errno} and message '{$errstr}' not found in", var_export($this->errors, true));
	}

	/**
	 * @test
	 */
	public function MagicMethodsShouldFail()
	{
		$magic_classes = array(
			'Autodns\Api\Client\Request\Task\HandleCreate'
		);

		foreach ($magic_classes as $class) {
			$task = new $class();
			$task->abc();

			$this->assertError( 'Call to undefined method ' . $class . '::abc()', E_USER_ERROR );
		}
	}
}
