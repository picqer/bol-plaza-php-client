<?php

namespace Picqer\BolPlazaClient;

use Picqer\BolPlazaClient\Entities\BaseModel;
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
    public static function createEntityFromResponse($entity, SimpleXMLElement $xmlElement)
    {
        $entity = 'Picqer\\BolPlazaClient\\Entities\\' . $entity;
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
     * @return SimpleXMLElement
     */
    public static function parseXmlResponse($xmlString)
    {
        $document = new SimpleXMLElement($xmlString);
        $namespaces = $document->getNamespaces(true);

        return $document->children($namespaces['bns']);
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
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
<' . $rootElement . ' xmlns="http://plazaapi.bol.com/services/xsd/plazaapiservice-1.0.xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://plazaapi.bol.com/services/xsd/plazaapiservice-1.0.xsd plazaapiservice-1.0.xsd "></' . $rootElement . '>');

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
     * @param BaseModel|array $entity
     * @param SimpleXMLElement $xml
     */
    protected static function getXmlForSubelements($entity, &$xml)
    {
        $entityData = $entity->getData();
        $xmlEntity = $xml->addChild($entity->getXmlEntityName());

        foreach ($entityData as $key => $value) {
            if (is_string($value) || is_numeric($value))
            {
                // Attributes
                $xmlEntity->addChild($key, $value);
            } elseif ($value instanceof BaseModel)
            {
                // Nested entities
                self::getXmlForSubelements($value, $xmlEntity);
            } elseif (is_array($value) && $entity->isSpecialAttribute($key))
            {
                $specialAttribute = $entity->getSpecialAttribute($key);
                if ($specialAttribute['type'] == 'array')
                {
                    $xmlSubEntity = $xmlEntity->addChild($key);
                    foreach ($value as $subValue)
                    {
                        $xmlSubEntity->addChild($specialAttribute['childName'], $subValue);
                    }
                }
            } elseif (is_array($value))
            {
                // Child entities
                /* @var $subEntity BaseModel */
                foreach ($value as $subEntity) {
                    if ( ! isset($addedExtraChild)) {
                        // Create extra XML child for child entities
                        $xmlSubEntity = $xmlEntity->addChild($subEntity->getXmlEntityPluralName());
                    }
                    self::getXmlForSubelements($subEntity, $xmlSubEntity);
                }
                unset($addedExtraChild);
            }
        }
    }
}