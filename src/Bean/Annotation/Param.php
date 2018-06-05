<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/31
 * Time: 下午12:28
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

use EasyMS\Base\BaseBean;

/**
 * Class Params
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Param extends BaseBean
{

    /**
     * @var string
     * 数据类型
     */
    public $type = '';

    /**
     * @var bool
     * 是否可选
     */
    public $optional = false;

    /**
     * @var string
     * 描述,可添加html代码
     */
    public $description = '';

    /**
     * @var string
     * 字段名
     */
    public $field = '';


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }

    /**
     * @param bool $optional
     */
    public function setOptional(bool $optional): void
    {
        $this->optional = $optional;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }


}