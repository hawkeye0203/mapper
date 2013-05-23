<?php

namespace PhpHalMapperTest\Entity;

/**
 * Class AbstractEntity
 * @package PhpHalMapperTest\Entity
 */
abstract class AbstractEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
