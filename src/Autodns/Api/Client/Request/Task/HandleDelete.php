<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class HandleDelete implements Task
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

    /**
     * @param $replyTo
     * @return $this
     */
    public function replyTo($replyTo) {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    function __call( $name, $arguments ) {
        $fields = array(
            'id'
        );
        if ( in_array( $name, $fields ) ) {
            $this->handleData[ $name ] = $arguments[0];
            return $this;
        }
        trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);

        return $this;
    }


    /**
     * @return array
     */
    public function asArray()
    {
        $array = array(
            'code' => '0303',
            'handle' => $this->handleData
        );

        if ( $this->replyTo ) {
            $array['reply_to'] = $this->replyTo;
        }

        return $array;
    }
}