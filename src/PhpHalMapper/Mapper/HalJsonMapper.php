<?php

namespace PhpHalMapper\Mapper;

/**
 * Class HalJsonMapper
 * @package PhpHalMapper\Mapper
 */
class HalJsonMapper
{
    /**
     * @var array
     */
    protected $basic;

    /**
     * @var array
     */
    protected $embedded;

    /**
     * @param array $basic
     * @param array $embedded
     */
    public function __construct(array $basic, array $embedded = array())
    {
        $this->basic = $basic;
        $this->embedded = $embedded;
    }

    /**
     * @param object $object
     * @return array
     */
    public function execute($object)
    {
        $data = array();

        foreach ($this->basic as $basic) {
            if (method_exists($object, 'get' . $basic)) {
                $data[$basic] = $object->{'get' . $basic}();
            }
        }

        if (!empty($this->embedded)) {
            $data['_embedded'] = array();

            foreach ($this->embedded as $name => $embed) {
                if (is_callable($embed) && method_exists($object, 'get' . $basic)) {
                    $value = $object->{'get' . $name}();
                    $data['_embedded'][$name] = $embed($value, $object);
                }
            }
        }

        return $data;
    }
}
