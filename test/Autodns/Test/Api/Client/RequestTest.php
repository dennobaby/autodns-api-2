<?php

namespace Autodns\Test\Api\Client;

use Autodns\Api\Client\Request\Task\Query;
use Autodns\Api\Client\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnArrayRepresentationOfARequest()
    {
        $query = new Query();
        $query = $query->addOr(
            $query->addAnd(
                array('name', 'like', '*.at'),
                array('created', 'lt', '2012-12-*')
            ),
            array('name', 'like', '*.de')
        );

        $task = new Request\Task\DomainInquireList();
        $task->withView(array('offset' => 0, 'limit' => 20, 'children' => 0))
            ->withKeys(array('created', 'payable'))
            ->withQuery($query);

        $request = new Request($task, null, '0987654321');
        $request->withReplyTo('customer@example.com');

        $expectedRequestArray = array(
            'auth' => array(),
            'task' => array(
                'code' => '0105',
                'view' => array(
                    'offset' => 0,
                    'limit' => 20,
                    'children' => 0
                ),
                'key' => array('created', 'payable'),
                'where' => array(
                    'or' => array(
                        array(
                            'and' => array(
                                array(
                                    'key' => 'name',
                                    'operator' => 'like',
                                    'value' => '*.at'
                                ),
                                array(
                                    'key' => 'created',
                                    'operator' => 'lt',
                                    'value' => '2012-12-*'
                                )
                            )
                        ),
                        array(
                            'key' => 'name',
                            'operator' => 'like',
                            'value' => '*.de'
                        )
                    )
                )
            ),
            'ctid' => '0987654321',
            'reply_to' => 'customer@example.com'
        );

        $output = $request->asArray();

        $this->assertEquals($expectedRequestArray, $output);
    }

    /**
     * @test
     */
    public function itShouldReturnInstanceOfTypeHandleCreate()
    {
        $request = new Request();
        $request->ofType('HandleCreate');

        $this->assertInstanceOf( 'Autodns\Api\Client\Request\Task\HandleCreate', $request->getTask() );
    }

    /**
     * @test
     */
    public function itShouldReturnGivenAuth()
    {
        $auth = array(
            'username' => 'customer',
            'password' => 'password',
            'context' => 4
        );
        $request = new Request();
        $request->setAuth($auth);

        $this->assertEquals( $auth, $request->getAuth() );
    }
}
