<?php

namespace Autodns\Test\Api\Client;

use Autodns\Api\Client\Request;
use Autodns\Api\Client\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function itShouldBeASuccessfulEmptyResponse()
	{
		$payload = array(
			'result' => array(
				'status' => array(
					'code' => 'S0105',
					'type' => 'success'
				)
			)
		);
		$response = new Response($payload);

		$this->assertTrue( $response->isSuccessful() );
		$this->assertEquals( 'S0105', $response->getStatusCode() );
		$this->assertEquals( 'success', $response->getStatusType() );
		$this->assertFalse( $response->getStatusReturnObject() );
		$this->assertEquals( $payload, $response->getPayload() );
	}

	/**
	 * @test
	 */
	public function itShouldReturnStatusObjectData()
	{
		$object = array(
			'type' => 'handle',
			'value' => '123456'
		);
		$payload = array(
			'result' => array(
				'status' => array(
					'code' => 'S0105',
					'type' => 'success',
					'object' => $object
				)
			)
		);
		$response = new Response($payload);

		$this->assertEquals( $response->getStatusReturnObject(), $object );
	}
}
