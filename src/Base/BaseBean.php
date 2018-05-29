<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 下午12:04
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Base;


class BaseBean
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
        //return ArrayHelper::toArray($this);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(),JSON_UNESCAPED_UNICODE);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function __construct($array = [])
    {
        if(!empty($array)){
            $varList = $this->toArray();
            foreach ($varList as $key => $value)
            {
                if(!is_numeric($key) && key_exists($key,$array)){
                    $this->$key = $array[$key];
                }
            }
        }
    }

}