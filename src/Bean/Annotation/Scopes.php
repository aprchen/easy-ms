<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/6/5
 * Time: 上午11:25
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

/**
 * Class Scopes
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Scopes
{
    /**
     * @var array
     */
    private $values = [\EasyMS\Constants\ScopeRoles::UNAUTHORIZED];

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->values = $values;
    }


    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->values[] = $values['value'];
        }

        if (isset($values['values'])) {
            $this->values = $values['values'];
        }
    }


}