<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:09
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Collector;

use EasyMS\Bean\Annotation\Cache;
use EasyMS\Bean\Annotation\Description;
use EasyMS\Bean\Annotation\Example;
use EasyMS\Bean\Annotation\Firewall;
use EasyMS\Bean\Annotation\Group;
use EasyMS\Bean\Annotation\Param;
use EasyMS\Bean\Annotation\Point;
use EasyMS\Bean\Annotation\Scopes;
use EasyMS\Bean\Annotation\Version;
use EasyMS\Constants\ExampleType;
use EasyMS\Helper\PhpHelper;
use EasyMS\Mapping\CollectorInterface;

class ControllerCollector implements CollectorInterface
{

    protected static $points = [];

    const POINT_KEY = 'points';

    const EXAMPLE_KEY = 'examples';

    const PARAM_KEY = 'parameter';

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
            self::$points[$className]['prefix'] = $objectAnnotation->getPrefix();
            self::$points[$className]['group'] = $objectAnnotation->getName();
            return;
        }
        if($objectAnnotation instanceof Point){
            self::$points[$className][self::POINT_KEY][$methodName]['method'] = $objectAnnotation->getMethod();
            self::$points[$className][self::POINT_KEY][$methodName]['name'] = $objectAnnotation->getName();
            $prefix = self::$points[$className]['prefix'] ?? '';
            $uri = $objectAnnotation->getPath() ?? '/';
            if($prefix !== '' && $uri == '/'){
                $url = $prefix;
            }else{
                $url =$prefix.$uri;
            }
            $url = PhpHelper::replaceDoubleSlashes($url);
            self::$points[$className][self::POINT_KEY][$methodName]['path'] = $url;
            return;
        }
        if($objectAnnotation instanceof Version){
            self::$points[$className][self::POINT_KEY][$methodName]['version'] = $objectAnnotation->getValue();
            return;
        }
        if($objectAnnotation instanceof Cache){
            self::$points[$className][self::POINT_KEY][$methodName]['cache'] = $objectAnnotation->getValue();
            return;
        }
        if($objectAnnotation instanceof Scopes){
            self::$points[$className][self::POINT_KEY][$methodName]['scopes'] = $objectAnnotation->getValues();
            return;
        }
        if($objectAnnotation instanceof Description){
            self::$points[$className][self::POINT_KEY][$methodName]['description'] = $objectAnnotation->getValue();
            return;
        }
        if($objectAnnotation instanceof Firewall){
            self::$points[$className][self::POINT_KEY][$methodName]['firewall'] = $objectAnnotation->getValue();
            return;
        }
        if($objectAnnotation instanceof Example){
            if($objectAnnotation->getContent() === ''){
                return;
            }
            $example = [];
            $example['content'] = $objectAnnotation->getContent();
            $example['title'] = $objectAnnotation->getTitle();
            $example['type'] = $objectAnnotation->getType();
            if($objectAnnotation->getHeader() == ExampleType::HEADER_PARAMETER){
                self::$points[$className][self::POINT_KEY][$methodName][self::PARAM_KEY]['fields']['examples'] = $example;
            }else{
                $header = $objectAnnotation->getHeader();
                self::$points[$className][self::POINT_KEY][$methodName][self::EXAMPLE_KEY][$header]['examples'][] = $example;
            }
            return;
        }
        if($objectAnnotation instanceof Param){
            if($objectAnnotation->getField() !==''){
                self::$points[$className][self::POINT_KEY][$methodName][self::PARAM_KEY]['fields']['Parameter'][] = $objectAnnotation->toArray();
            }
            return;
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