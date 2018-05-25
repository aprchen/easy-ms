<?php

namespace EasyMS\Bean\Wrapper;

use EasyMS\Bean\Parser\AbstractParser;
use EasyMS\Bean\Resource\AnnotationResource;
use EasyMS\Mapping\WrapperInterface;


/**
 * 抽象封装器
 */
abstract class AbstractWrapper implements WrapperInterface
{
    /**
     * 类注解
     *
     * @var array
     */
    protected $classAnnotations = [];

    /**
     * 属性注解
     *
     * @var array
     */
    protected $propertyAnnotations = [];

    /**
     * 方法注解
     *
     * @var array
     */
    protected $methodAnnotations = [];


    /**
     * 注解资源
     *
     * @var AnnotationResource
     */
    protected $annotationResource;

    /**
     * AbstractWrapper constructor.
     *
     * @param AnnotationResource $annotationResource
     */
    public function __construct(AnnotationResource $annotationResource)
    {
        $this->annotationResource = $annotationResource;
    }

    /**
     * 封装注解
     *
     * @param string $className
     * @param array $annotations
     *
     * @return array|null
     * @throws \ReflectionException
     */
    public function doWrapper(string $className, array $annotations)
    {
        $reflectionClass = new \ReflectionClass($className);
        // 解析类级别的注解
        $beanDefinition = $this->parseClassAnnotations($className, $annotations['class']);

        // 解析方法
        $publicMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methodAnnotations = $annotations['method'] ??[];
        $this->parseMethods($methodAnnotations, $className, $publicMethods);

        return [$className, $beanDefinition];
    }


    /**
     * 解析方法
     *
     * @param array  $methodAnnotations
     * @param string $className
     * @param array  $publicMethods
     */
    private function parseMethods(array $methodAnnotations, string $className, array $publicMethods)
    {
        // 循环解析
        foreach ($publicMethods as $method) {
            /* @var \ReflectionMethod $method*/
            if ($method->isStatic()) {
                continue;
            }

            /* @var \ReflectionClass $declaredClass*/
            $declaredClass = $method->getDeclaringClass();
            $declaredName = $declaredClass->getName();

            // 不是当前类方法
            if ($declaredName != $className) {
                continue;
            }
            $this->parseMethodAnnotations($className, $method, $methodAnnotations);
        }
    }

    /**
     * 解析方法注解
     *
     * @param string            $className
     * @param \ReflectionMethod $method
     * @param array             $methodAnnotations
     */
    private function parseMethodAnnotations(string $className, \ReflectionMethod $method, array $methodAnnotations)
    {
        $methodName = $method->getName();
        // 循环方法注解解析
        foreach ($methodAnnotations[$methodName] as $methodAnnotationAry) {
            foreach ($methodAnnotationAry as $methodAnnotation) {
                $annotationClass = get_class($methodAnnotation);
                if (!in_array($annotationClass, $this->getMethodAnnotations())) {
                    continue;
                }
                // 解析器解析
                $annotationParser = $this->getAnnotationParser($methodAnnotation);
                $annotationParser->parser($className, $methodAnnotation, "", $methodName);
            }
        }
    }



    /**
     * 类注解解析
     *
     * @param string $className
     * @param array  $annotations
     *
     * @return array
     */
    public function parseClassAnnotations(string $className, array $annotations)
    {

        if (!$this->isParseClass($annotations)) {
            return null;
        }

        $beanData = null;
        foreach ($annotations as $annotation) {
            $annotationClass = get_class($annotation);

            if (!in_array($annotationClass, $this->getClassAnnotations())) {
                continue;
            }
            // annotation parser
            $annotationParser = $this->getAnnotationParser($annotation);
            if ($annotationParser == null) {
                continue;
            }

            $annotationData = $annotationParser->parser($className, $annotation);
            if ($annotationData != null) {
                $beanData = $annotationData;
            }
        }

        return $beanData;
    }


    /**
     * @return array
     */
    private function getClassAnnotations(): array
    {
        return $this->classAnnotations;
    }


    /**
     * @return array
     */
    private function getMethodAnnotations(): array
    {
        return $this->methodAnnotations;
    }


    /**
     * @param array $annotations
     *
     * @return bool
     */
    private function isParseClass(array $annotations): bool
    {
        return $this->isParseClassAnnotations($annotations);
    }



    /**
     * @param array $annotations
     *
     * @return bool
     */
    private function isParseMethod(array $annotations): bool
    {
        return $this->isParseMethodAnnotations($annotations) ;
    }


    /**
     *  获取注解对应解析器
     *
     * @param $objectAnnotation
     *
     * @return AbstractParser
     */
    private function getAnnotationParser($objectAnnotation)
    {
        $annotationClassName = get_class($objectAnnotation);
        $classNameTmp = str_replace('\\', '/', $annotationClassName);
        $className = basename($classNameTmp);
        $namespaceDir = dirname($classNameTmp, 2);
        $namespace = str_replace('/', '\\', $namespaceDir);

        // 解析器类名
        $annotationParserClassName = "{$namespace}\\Parser\\{$className}Parser";
        if (!class_exists($annotationParserClassName)) {
            return null;
        }

        $annotationParser = new $annotationParserClassName($this->annotationResource);
        return $annotationParser;
    }
}
