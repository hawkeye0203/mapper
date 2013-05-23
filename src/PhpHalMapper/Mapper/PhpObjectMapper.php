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

        foreach ($json as $key => $value) {
            if (method_exists($object, 'set' . $key)) {
                if (isset($this->factories[$key]) && is_callable($this->factories[$key])) {
                    $mappedValue = $this->factories[$key]($value, $json);
                    $object->{'set' . $key}($mappedValue);
                } else {
                    $object->{'set' . $key}($value);
                }
            }
        }

        return $object;
    }
}
