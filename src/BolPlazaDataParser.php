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
        $object = self::fillModelFromXml(new $entity, $xmlElement);
        return $object;
    }

    /**
     * Fills one empty entity model with data from SimpleXMLElement
     * @param BaseModel $model
     * @param SimpleXMLElement $xmlObject
     * @return BaseModel
     */
    public static function fillModelFromXml(BaseModel $model, SimpleXMLElement $xmlObject)
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
}