<?php

namespace Autodns\Api\Client\Request\Task;


use Autodns\Api\Client\Request\Task;

class DomainCreate implements Task
{
	private $domainData = array();
	private $replyTo;

	/**
	 * @param array $domainData
	 * @return $this
	 */
	public function fill(array $domainData)
	{
		$this->domainData = $domainData;
		return $this;
	}

	public function replyTo($replyTo) {
		$this->replyTo = $replyTo;
		return $this;
	}

	function __call( $name, $arguments ) {
		$fields = array(
			'name',

			'ownerc',
			'adminc',
			'techc',
			'zonec',

			'nserver',
			'dnssec',
			'zone'
		);
		if ( in_array( $name, $fields ) ) {
			$this->domainData[ $name ] = $arguments[0];
			return $this;
		}
		trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
	}

	/**
	 * @return array
	 */
	public function asArray()
	{
		$array = array(
			'code' => '0101',
			'domain' => $this->domainData
		);
		$array['domain']['confirm_order'] = 1;

		if ( $this->replyTo ) {
			$array['reply_to'] = $this->replyTo;
		}

		return $array;
	}
}
