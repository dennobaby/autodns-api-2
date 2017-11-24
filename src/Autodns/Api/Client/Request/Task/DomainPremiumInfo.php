<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

/**
 * Class DomainPremiumInfo
 * @package Autodns\Api\Client\Request\Task
 */
class DomainPremiumInfo implements Task
{
    private $handleData = array();

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
     * @param $name
     * @param $arguments
     * @return $this
     */
    function __call( $name, $arguments ) {
        $fields = array(
            'name'
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
            'code' => '0164',
            'domain_premium' => $this->handleData
        );

        return $array;
    }
}
