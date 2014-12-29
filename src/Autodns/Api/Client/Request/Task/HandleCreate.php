<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class HandleCreate implements Task
{
    private $handleData = array();
    private $replyTo;

    /**
     * @param array $handleData
     * @return $this
     */
    public function fill(array $handleData)
    {
        $this->handleData = $handleData;
        return $this;
    }

    public function replyTo($replyTo) {
        $this->replyTo = $replyTo;
        return $this;
    }

    function __call( $name, $arguments ) {
        $fields = array(
            'alias',
            'type',

            'fname',
            'lname',
            'title',
            'organization',

            'address',
            'pcode',
            'city',
            'state',
            'country',

            'phone',
            'fax',
            'email',
        );
        if ( in_array( $name, $fields ) ) {
            $this->handleData[ $name ] = $arguments[0];
            return $this;
        }
        return false;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code' => '0301',
            'handle' => $this->handleData
        );
        $array['handle']['protection'] = 'A';

        if ( $this->replyTo ) {
            $array['reply_to'] = $this->replyTo;
        }

        return $array;
    }
}
