<?php

namespace PhpHalMapperTest\Entity;

/**
 * Class Agent
 * @package PhpHalMapperTest\Entity
 */
class Agent extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

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
}
