<?php namespace NpmWeb\OmnipayPayflow;

use Omnipay\Tests\GatewayTestCase;

class RecurringGatewayTest extends GatewayTestCase {


    public function setUp()
    {
        parent::setUp();

        $this->gateway = new RecurringGateway($this->getHttpClient(), $this->getHttpRequest());

		$tomorrow = new \DateTime();
		$tomorrow->modify('+1 day');

        $this->options = array(
            'amount' => '10.00',
            'card' => new \Omnipay\Common\CreditCard(array(
                'firstName' => 'Example',
                'lastName' => 'User',
                'number' => '4111111111111111',
                'expiryMonth' => '12',
                'expiryYear' => '2016',
                'cvv' => '123',
            )),
            'comment1' => 'A Comment for the Tx',
			'profileName' => 'User, Example | Bi-weekly',
            'payPeriod' => 'BIWK',
            'term' => 0,
            'startDate' => $tomorrow->format('mdY')
        );
    }

	public function testAddRecurringProfileSuccess() {
		// arrange
        $this->setMockHttpResponse('ProfileSuccess.txt');

 		// act
 		echo "Sending the request to Payflow\n";
        $response = $this->gateway->addRecurringProfile($this->options)->send();

        echo "Response data: ".print_r($response->getData(),true)."\n";

		// assert
        $this->assertTrue($response->isProfileActionSuccessful());
        $this->assertEquals('RT0000000012', $response->getProfileID());
        $this->assertEquals('R1056BE9039C', $response->getProfileReference());

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('B70E6A323E14', $response->getTransactionReference());

	}

}
