<?php

namespace Autodns\Test\Api;

use Autodns\Api\Account\Info;

class InfoTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function itShouldReturnGivenData ()
	{
		$username = 'username';
		$password = 'password';
		$context = 4;

		$info = new Info(
			'some url',
			$username,
			$password,
			$context
		);

		$this->assertEquals( $username, $info->getUsername() );
		$this->assertEquals( $password, $info->getPassword() );
		$this->assertEquals( $context, $info->getContext() );
	}
}
