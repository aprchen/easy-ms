<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:10
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Mapping;

/**
 * Annotaions Data Collector Interface
 */
interface CollectorInterface
{
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
    );

    /**
     * @return mixed
     */
    public static function getCollector();
}