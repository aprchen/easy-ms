<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:03
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;
use EasyMS\Constants\Methods;
use EasyMS\Constants\Scopes;

/**
 * Class Point
 * @package EasyMS\Bean\Annotation
 * @Annotation
 */
class Point
{
    /**
     * @var string
     */
    public $name='';

    /**
     * @var string
     */
    public $path='';

    /**
     * @var string
     */
    public $method = Methods::GET;
    /**
     * @var array
     */
    public $scopes = [Scopes::UNAUTHORIZED];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        if(empty($this->method)){
            $this->method = Methods::GET;
        }
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        $this->scopes = $scopes;
    }



}