<?php

namespace PhpHalMapperTest\Mapper;

use PhpHalMapper\Mapper\HalJsonMapper;
use PhpHalMapperTest\Entity\Agent;
use PhpHalMapperTest\Entity\Customer;
use PhpHalMapperTest\Entity\User;

/**
 * Class HalJsonMapperTest
 * @package PhpHalMapperTest\Mapper
 */
class HalJsonMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test mapping from a set of PHP objects to HAL Json notation.
     */
    public function testMapping()
    {
        $agent = new Agent();
        $agent->setId(5);
        $agent->setName('Awesome Agent Company');

        $salesRep = new User();
        $salesRep->setId(1525);
        $salesRep->setName('Charles SalesGuy');

        $customer = new Customer();
        $customer->setId(3000);
        $customer->setName('ACME Corp.');
        $customer->setSalesRep($salesRep);
        $customer->setAgent($agent);

        $mapper = new HalJsonMapper(
            ['id', 'name'],
            [
                'salesRep' => function ($salesRep) {
                    $repMapper = new HalJsonMapper(['id', 'name']);
                    return $repMapper->execute($salesRep);
                } ,
                'agent' => function ($agent) {
                    $agentMapper = new HalJsonMapper(['id', 'name']);
                    return $agentMapper->execute($agent);
                }
            ]
        );

        $data = $mapper->execute($customer);

        $this->assertInternalType('array', $data);
        $this->assertEquals(3000, $data['id']);
        $this->assertEquals('ACME Corp.', $data['name']);

        $this->assertEquals(5, $data['_embedded']['agent']['id']);
        $this->assertEquals('Awesome Agent Company', $data['_embedded']['agent']['name']);

        $this->assertEquals(1525, $data['_embedded']['salesRep']['id']);
        $this->assertEquals('Charles SalesGuy', $data['_embedded']['salesRep']['name']);
    }
}
