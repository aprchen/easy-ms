<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 下午4:21
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Parser;


use EasyMS\Bean\Collector\ControllerCollector;

class DescriptionParser extends AbstractParser
{

    /**
     * 解析注解
     *
     * @param string $className
     * @param object $objectAnnotation
     * @param string $propertyName
     * @param string $methodName
     * @param string|null $propertyValue
     *
     * @return mixed
     */
    public function parser(
        string $className,
        $objectAnnotation = null,
        string $propertyName = '',
        string $methodName = '',
        $propertyValue = null
    )
    {
        ControllerCollector::collect($className,$objectAnnotation,$propertyName,$methodName,$propertyValue);
    }
}