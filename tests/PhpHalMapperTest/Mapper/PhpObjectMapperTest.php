<?php

namespace PhpHalMapperTest\Mapper;

use PhpHalMapper\Mapper\PhpObjectMapper;
use PhpHalMapperTest\Entity\Agent;
use PhpHalMapperTest\Entity\User;

/**
 * Class PhpObjectMapperTest
 * @package PhpHalMapperTest\Mapper
 */
class PhpObjectMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests generic mapping as well as factory mapping.
     */
    public function testMapping()
    {
        $json = '{
            "name": "ACME Corp.",
            "type": "R",
            "salesRep": 1441,
            "agent": 200
        }';

        $json = json_decode($json, true);

        $mapper = new PhpObjectMapper(
            'PhpHalMapperTest\Entity\Customer',
            [
                'salesRep' => function ($value) {
                    $user = new User();
                    $user->setId($value);
                    $user->setName('User #' . $value);
                    $user->setEmail('user.' . $value . '@email.com');

                    return $user;
                },
                'agent' => function ($value) {
                    $agent = new Agent();
                    $agent->setId($value);
                    $agent->setName('Agent #' . $value);

                    return $agent;
                }
            ]
        );

        $customer = $mapper->execute($json);

        $this->assertEquals('ACME Corp.', $customer->getName());
        $this->assertEquals('R', $customer->getType());
        $this->assertEquals(1441, $customer->getSalesRep()->getId());
        $this->assertEquals('User #1441', $customer->getSalesRep()->getName());
        $this->assertEquals('user.1441@email.com', $customer->getSalesRep()->getEmail());
        $this->assertEquals(200, $customer->getAgent()->getId());
        $this->assertEquals('Agent #200', $customer->getAgent()->getName());
    }
}
