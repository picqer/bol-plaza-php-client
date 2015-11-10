<?php

namespace Picqer\BolPlazaClient\Entities;

abstract class BaseModel
{
    protected $xmlEntityName = 'BaseModel';

    /**
     * @var array List of all the attributes of this model
     */
    protected $attributes = [];

    /**
     * @var array Storage of all attribute data
     */
    protected $attributesData = [];

    /**
     * @var array List of all the nested entities for this model (1 element per branch)
     */
    protected $nestedEntities = [];

    /**
     * @var array Storage of all nested entities data
     */
    protected $nestedEntitiesData = [];

    /**
     * @var array List of all the child entities for this model (array of elements per branch)
     */
    protected $childEntities = [];

    /**
     * @var array Storage of all child entities data
     */
    protected $childEntitiesData = [];

    /**
     * @var array List of attributes that deserve special treatment from XML creator
     */
    protected $specialAttributes = [];

    public function __construct(array $attributes = [])
    {
        $this->fillFromArray($attributes);
    }

    /**
     * Fill data from array
     * @param array $attributes
     */
    protected function fillFromArray(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * Get data from attribute, child entity or nested entity
     *
     * @param string $key
     * @return null|string|array
     */
    public function __get($key)
    {
        if (isset( $this->attributesData[$key] ))
        {
            return $this->attributesData[$key];
        } elseif (isset($this->childEntitiesData[$key]))
        {
            return $this->childEntitiesData[$key];
        } elseif (isset($this->nestedEntitiesData[$key]))
        {
            return $this->nestedEntitiesData[$key];
        }

        return null;
    }

    /**
     * Set data for attribute, child entity or nested entity
     *
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        if ($this->attributeExists($key))
        {
            $this->attributesData[$key] = $value;
        } elseif ($this->childEntityExists($key))
        {
            $this->childEntitiesData[$key] = $value;
        } elseif ($this->nestedEntityExists($key))
        {
            $this->nestedEntitiesData[$key] = $value;
        }
    }

    /**
     * Check if an attribute key exists
     *
     * @param $key
     * @return bool
     */
    public function attributeExists($key)
    {
        return in_array($key, $this->attributes);
    }

    /**
     * Check if an nested entity key exists
     *
     * @param $key
     * @return bool
     */
    public function nestedEntityExists($key)
    {
        return array_key_exists($key, $this->nestedEntities);
    }

    /**
     * Check if an child entity key exists
     * @param $key
     * @return bool
     */
    public function childEntityExists($key)
    {
        return array_key_exists($key, $this->childEntities);
    }

    /**
     * Get a nested entity
     *
     * @param $key
     * @return mixed
     */
    public function getNestedEntity($key)
    {
        if ($this->nestedEntityExists($key)) {
            return $this->nestedEntities[$key];
        }
    }

    /**
     * Get a child entity
     *
     * @param $key
     * @return mixed
     */
    public function getChildEntity($key)
    {
        if ($this->childEntityExists($key)) {
            return $this->childEntities[$key];
        }
    }

    /**
     * Make var_dump and print_r look pretty
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->getData();
    }

    /**
     * Get all current data set in this model
     * @return array
     */
    public function getData()
    {
        $result = [];
        foreach ($this->attributes as $attribute)
        {
            $result[$attribute] = $this->$attribute;
        }

        foreach ($this->childEntities as $childEntity => $entityClassName)
        {
            $result[$childEntity] = $this->$childEntity;
        }

        foreach ($this->nestedEntities as $nestedEntity => $entityDetails)
        {
            $result[$nestedEntity] = $this->$nestedEntity;
        }

        return $result;
    }

    /**
     * Get the XML entity name for building XML
     * @return string
     */
    public function getXmlEntityName()
    {
        return $this->xmlEntityName;
    }

    /**
     * Get the plural of the XML entity name for building XML groups
     * @return array|null|string
     */
    public function getXmlEntityPluralName()
    {
        if (isset($this->xmlEntityPluralName))
        {
            return $this->xmlEntityPluralName;
        }

        return $this->xmlEntityName . 's';
    }

    /**
     * Check if attribute is special
     * @param $key
     * @return bool
     */
    public function isSpecialAttribute($key)
    {
        return array_key_exists($key, $this->specialAttributes);
    }

    /**
     * Get details of special attribute
     * @param $key
     * @return null|array
     */
    public function getSpecialAttribute($key)
    {
        if ( ! $this->isSpecialAttribute($key)) {
            return null;
        }

        return $this->specialAttributes[$key];
    }
}