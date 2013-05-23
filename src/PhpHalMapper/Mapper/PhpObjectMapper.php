<?php

namespace PhpHalMapper\Mapper;

/**
 * Class PhpObjectMapper
 * @package PhpHalMapper\Mapper
 */
class PhpObjectMapper
{
    /**
     * @var string
     */
    protected $mappedClass;

    /**
     * @var array
     */
    protected $factories;

    /**
     * @param string $class
     * @param array $factories
     */
    public function __construct($class, array $factories = array())
    {
        $this->mappedClass = $class;
        $this->factories = $factories;
    }

    /**
     * @param string $attribute
     * @param callable $factory
     */
    public function addMappingFactory($attribute, $factory)
    {
        $this->factories[$attribute] = $factory;
    }

    /**
     * @param array $json
     * @return object
     */
    public function execute(array $json)
    {
        $object = new $this->mappedClass();

        $properties = $this->getObjectProperties($object);

        foreach ($json as $key => $value) {
            if (isset($properties[$key])) {
                if (isset($this->factories[$key]) && is_callable($this->factories[$key])) {
                    $mappedValue = $this->factories[$key]($value);
                    $object->{'set' . $key}($mappedValue);
                } else {
                    $object->{'set' . $key}($value);
                }
            }
        }

        return $object;
    }

    /**
     * @param object $object
     * @return array
     */
    protected function getObjectProperties($object)
    {
        $reflector = new \ReflectionClass($object);
        $list = $reflector->getProperties();

        $properties = array();

        foreach ($list as $property) {
            $properties[$property->getName()] = $property->getName();
        }

        return $properties;
    }
}
