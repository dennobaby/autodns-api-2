<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

/**
 * Class HandleUpdate
 * @package Autodns\Api\Client\Request\Task
 */
class HandleUpdate implements Task
{
    private $handleData = array();
    private $replyTo;
    private $forceHandleCreate;
    private $confirmOwnerConsent;

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
     * @param $forceHandleCreate
     * @return $this
     */
    public function forceHandleCreate($forceHandleCreate) {
        $this->forceHandleCreate = $forceHandleCreate ? '1' : false;
        return $this;
    }

    /**
     * @param $confirmOwnerConsent
     * @return $this
     */
    public function confirmOwnerConsent($confirmOwnerConsent){
        $this->confirmOwnerConsent = $confirmOwnerConsent ? '1' : false;
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
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

            'sip',
            'protection',
            'nic_ref',
            'remarks',
            'extension'
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
            'code' => '0302',
            'handle' => $this->handleData
        );

        if ( ! isset($array['handle']['protection']) ) {
            $array['handle']['protection'] = 'B';
        }

        if ( $this->forceHandleCreate ) {
            $array['force_handle_create'] = $this->forceHandleCreate;
        }

        if($this->confirmOwnerConsent){
            $array['confirm_owner_consent'] = $this->confirmOwnerConsent;
        }

        if ( $this->replyTo ) {
            $array['reply_to'] = $this->replyTo;
        }

        return $array;
    }
}
