<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:06
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

use EasyMS\Base\BaseBean;


/**
 * Class Group
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("CLASS")
 */
class Group extends BaseBean
{
    /**
     * @var string
     */
    public $name ='';
    /**
     * @var string
     */
    public $prefix= '';

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->prefix = $values['value'];
        }

        if (isset($values['prefix'])) {
            $this->prefix = $values['prefix'];
        }

        if (isset($values['path'])) {
            $this->prefix = $values['path'];
        }
        if (isset($values['name'])) {
            $this->name = $values['name'];
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
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }


}