<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:03
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

use EasyMS\Base\BaseBean;
use EasyMS\Constants\Methods;
/**
 * Class Point
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Point extends BaseBean
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
     * @var array
     */
    public $method = [Methods::GET,Methods::POST];

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->path = $values['value'];
        }

        if (isset($values['path'])) {
            $this->path = $values['path'];
        }
    }

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
     * @return array
     */
    public function getMethod(): array
    {
        return $this->method;
    }

    /**
     * @param array $method
     */
    public function setMethod(array $method): void
    {
        $this->method = $method;
    }
}