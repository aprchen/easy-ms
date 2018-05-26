<?php

namespace EasyMS\Bean\Parser;

use EasyMS\Bean\Resource\ControllerAnnotationResource;
use EasyMS\Mapping\ParserInterface;


/**
 * 抽象解析器
 *
 * @uses      AbstractParser
 * @version   2017年09月03日
 * @author    stelin <phpcrazy@126.com>
 * @copyright Copyright 2010-2016 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * 注解解析资源
     *
     * @var ControllerAnnotationResource
     */
    protected $annotationResource;

    /**
     * AbstractParser constructor.
     *
     * @param ControllerAnnotationResource $annotationResource
     */
    public function __construct(ControllerAnnotationResource $annotationResource)
    {
        $this->annotationResource = $annotationResource;
    }
}
