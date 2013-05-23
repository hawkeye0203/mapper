<?php

namespace PhpHalMapperTest\Entity;

/**
 * Class Customer
 * @package PhpHalMapperTest\Entity
 */
class Customer
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var User
     */
    protected $salesRep;

    /**
     * @var Agent
     */
    protected $agent;

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \PhpHalMapperTest\Entity\User $salesRep
     * @return $this
     */
    public function setSalesRep($salesRep)
    {
        $this->salesRep = $salesRep;
        return $this;
    }

    /**
     * @return \PhpHalMapperTest\Entity\User
     */
    public function getSalesRep()
    {
        return $this->salesRep;
    }

    /**
     * @param \PhpHalMapperTest\Entity\Agent $agent
     * @return $this
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * @return \PhpHalMapperTest\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }
}
