<?php namespace NpmWeb\OmnipayPayflow;

use Omnipay\Payflow\ProGateway;
use Omnipay\Omnipay;

class RecurringGateway extends ProGateway {

	public function __construct() {
		parent::__construct();
		$factory = Omnipay::getFactory();
		$factory->register('\NpmWeb\OmnipayPayflow\RecurringGateway');
	}

    public function getName()
    {
        return 'Payflow_Recurring';
    }

    public function addRecurringProfile(array $parameters = array()) {
        return $this->createRequest('\NpmWeb\OmnipayPayflow\Message\RecurringBillingRequest', $parameters);
    }
	
}