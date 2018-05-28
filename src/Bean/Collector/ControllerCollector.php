<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:09
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Collector;

use EasyMS\Bean\Annotation\Group;
use EasyMS\Bean\Annotation\Point;
use EasyMS\Mapping\CollectorInterface;

class ControllerCollector implements CollectorInterface
{

    protected static $points = [];

    /**
     * @param string $className
     * @param object|null $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param null $propertyValue
     * @return mixed
     */
    public static function collect(
        string $className,
        $objectAnnotation = null,
        string $propertyName = '',
        string $methodName = '',
        $propertyValue = null
    )
    {
        if($objectAnnotation instanceof Group){
            self::$points[$className]['prefix'] = $objectAnnotation->getPath();
            self::$points[$className]['group'] = $objectAnnotation->getName();
        }
        if($objectAnnotation instanceof Point){
            $point = [];
            $point['method'] = $objectAnnotation->getMethod();
            $point['name'] = $objectAnnotation->getName();
            $point['path'] = $objectAnnotation->getPath();
            $point['scopes'] = $objectAnnotation->getScopes();
            $point['description'] = $objectAnnotation->getDescription();
            $point['version'] = $objectAnnotation->getVersion();
            self::$points[$className]['points'][$methodName] = $point;
        }
    }

    /**
     * @return mixed
     */
    public static function getCollector()
    {
        return self::$points;
    }
}