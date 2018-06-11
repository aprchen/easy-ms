<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/6/5
 * Time: 上午11:28
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

/**
 * Class Description
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Firewall
{
    /**
     * @var array
     */
    public $allows=[];


    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->allows = $values['value'];
        }
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->allows;
    }

    /**
     * @param mixed|string $value
     */
    public function setValue($value): void
    {
        $this->allows = $value;
    }

}