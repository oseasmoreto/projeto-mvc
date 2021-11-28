<?php

namespace App\Classes;

    class CleanJsonSerializer {

  
    private $classPropertyGetters = array();

   
    public function serialize($object)
    {
        return json_encode($this->serializeInternal($object));
    }

   
    private function serializeInternal($object)
    {
        if (is_array($object)) {
            $result = $this->serializeArray($object);
        } elseif (is_object($object)) {
            $result = $this->serializeObject($object);
        } else {
            $result = $object;
        }
        return $result;
    }

    private function getClassPropertyGetters($object)
    {
        $className = get_class($object);
        if (!isset($this->classPropertyGetters[$className])) {
            $reflector = new \ReflectionClass($className);
            $properties = $reflector->getProperties();
            $getters = array();
            foreach ($properties as $property)
            {
                $name = $property->getName();
                $getter = "get" . ucfirst($name);
                try {
                    $reflector->getMethod($getter);
                    $getters[$name] = $getter;
                } catch (\Exception $e) {
                }
            }
            $this->classPropertyGetters[$className] = $getters;
        }
        return $this->classPropertyGetters[$className];
    }


    public function serializeObject($object) {
        $properties = $this->getClassPropertyGetters($object);
        $data = array();
        foreach ($properties as $name => $property)
        {
            $data[$name] = $this->serializeInternal($object->$property());
        }
        return $data;
    }

    /**
     * @param $array
     * @return array
     */
    public function serializeArray($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $result[$key] = $this->serializeInternal($value);
        }
        return $result;
    }  
} 