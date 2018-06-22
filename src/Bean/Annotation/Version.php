<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/6/5
 * Time: 上午11:27
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

/**
 * Class Version
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Version
{
    private $value = '0.0.0';


    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->value = $values['value'];
        }
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

}