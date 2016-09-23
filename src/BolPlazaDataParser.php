<?php

namespace Wienkit\BolPlazaClient;

use Wienkit\BolPlazaClient\Entities\BaseModel;
use SimpleXMLElement;

class BolPlazaDataParser
{
    /**
     * Create an array with entity classes, based on XML string or SimpleXMLElement
     *
     * @param string $entity
     * @param string|SimpleXMLElement $xmlString
     * @return array
     */
    public static function createCollectionFromResponse($entity, $xmlString)
    {
        if ($xmlString instanceof SimpleXMLElement) {
            $xmlElements = $xmlString;
        } else {
            $xmlElements = self::parseXmlResponse($xmlString);
        }

        $collection = [];
        foreach ($xmlElements as $xmlElement) {
            $collection[] = self::createEntityFromResponse($entity, $xmlElement);
        }
        return $collection;
    }

    /**
     * Returns a single filled entity from SimpleXMLElement response
     *
     * @param string $entity
     * @param SimpleXMLElement $xmlElement
     * @return BaseModel
     */
    public static function createEntityFromResponse($entity, $xml)
    {
        $entity = 'Wienkit\\BolPlazaClient\\Entities\\' . $entity;
        if ($xml instanceof SimpleXMLElement) {
            $xmlElement = $xml;
        } else {
            $model = new $entity;
            $xmlElement = self::parseXmlResponse($xml, $model->getXmlNamespace());
        }

        $object = self::fillModelFromXmlObject(new $entity, $xmlElement);
        return $object;
    }

    /**
     * Fills one empty entity model with data from SimpleXMLElement
     * @param BaseModel $model
     * @param SimpleXMLElement $xmlObject
     * @return BaseModel
     */
    public static function fillModelFromXmlObject(BaseModel $model, SimpleXMLElement $xmlObject)
    {
        /* @var SimpleXMLElement $child */
        foreach ($xmlObject as $name => $child)
        {
            if ($model->attributeExists($name))
            {
                $model->$name = (string)$child;
            } elseif ($model->nestedEntityExists($name))
            {
                $model->$name = self::createEntityFromResponse($model->getNestedEntity($name), $child);
            } elseif ($model->childEntityExists($name))
            {
                $model->$name = self::createCollectionFromResponse($model->getChildEntity($name)['entityClass'], $child);
            }
        }

        return $model;
    }

    /**
     * Parse a namespaced XML response and turn it into a SimpleXMLElement with the root data
     *
     * @param string $xmlString
     * @param array $namespaces
     * @return SimpleXMLElement
     */
    public static function parseXmlResponse($xmlString, $namespace = '')
    {
        $document = new SimpleXMLElement($xmlString);
        if(!empty($namespace)) {
          $namespaces = $document->getNamespaces(true);
          return $document->children($namespaces[$namespace]);
        }
        return $document->children();
    }

    /**
     * Create XML string for collection of entities/models
     *
     * @param array $entities
     * @param string $rootElement
     * @param array $subElements
     * @return mixed
     */
    public static function createXmlFromEntities(array $entities, $rootElement, array $subElements = [])
    {
        return self::createNamespacedXmlFromEntities('https://plazaapi.bol.com/services/xsd/v2/plazaapi.xsd', $entities, $rootElement, $subElements);
    }

    /**
     * Create XML string for collection of entities/models, uses the offer api
     *
     * @param array $entities
     * @param string $rootElement
     * @param array $subElements
     * @return mixed
     */
    public static function createOfferXmlFromEntities(array $entities, $rootElement, array $subElements = [])
    {
        return self::createNamespacedXmlFromEntities('http://plazaapi.bol.com/offers/xsd/api-1.0.xsd', $entities, $rootElement, $subElements);
    }

    /**
     * Create XML string for collection of entities/models
     *
     * @param string $namespace
     * @param array $entities
     * @param string $rootElement
     * @param array $subElements
     * @return mixed
     */
    protected static function createNamespacedXmlFromEntities($namespace, array $entities, $rootElement, array $subElements = [])
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
            <' . $rootElement . ' xmlns="' . $namespace . '"></' . $rootElement . '>');

        $subXml = $xml;
        foreach ($subElements as $subElement)
        {
            $subXml = $subXml->addChild($subElement);
        }

        foreach ($entities as $entity) {
            self::getXmlForSubelements($entity, $subXml);
        }

        return $xml->asXML();
    }

    /**
     * Create XML string for an entity
     *
     * @param BaseModel $entity
     * @return mixed
     */
    public static function createXmlFromEntity($entity)
    {
        return self::createNamespacedXmlFromEntity('https://plazaapi.bol.com/services/xsd/v2/plazaapi.xsd', $entity);
    }

    /**
     * Create XML string for an entity, using the offer api
     *
     * @param BaseModel $entity
     * @return mixed
     */
    public static function createOfferXmlFromEntity($entity)
    {
        return self::createNamespacedXmlFromEntity('http://plazaapi.bol.com/offers/xsd/api-1.0.xsd', $entity);
    }

    /**
     * Create XML string for an entity
     *
     * @param BaseModel $entity
     * @return mixed
     */
    protected static function createNamespacedXmlFromEntity($namespace, $entity)
    {
        $rootElement = $entity->getXmlEntityName();
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
            <' . $rootElement . ' xmlns="' . $namespace . '"></' . $rootElement . '>');

        $entityData = $entity->getData();
        self::fillEntityData($entityData, $xml);
       return $xml->asXML();
    }

    /**
     * @param BaseModel|array $entity
     * @param SimpleXMLElement $xml
     */
    protected static function getXmlForSubelements($entity, &$xml)
    {
        $entityData = $entity->getData();
        $xmlEntity = $xml->addChild($entity->getXmlEntityName());
        self::fillEntityData($entityData, $xmlEntity);
    }

    /**
     * @param BaseModel|array $entity
     * @param SimpleXMLElement $xml
     */
    protected static function fillEntityData($entityData, &$xmlEntity)
    {
        foreach ($entityData as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                // Attributes
                $xmlEntity->addChild($key, $value);
            } elseif ($value instanceof BaseModel) {
                // Nested entities
                self::getXmlForSubelements($value, $xmlEntity);
            } elseif (is_array($value)) {
                // Child entities
                /* @var $subEntity BaseModel */
                foreach ($value as $subEntity) {
                    self::getXmlForSubelements($subEntity, $xmlSubEntity);
                }
            }
        }
    }
}
