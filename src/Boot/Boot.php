<?php
namespace EasyMS\Boot;

use EasyMS\Mapping\BootstrapInterface;

class Boot
{
    /**
     * @var BootstrapInterface[]
     */
    protected  $_executables;

    public function __construct(array $arr)
    {
        $this->_executables = $arr;
    }

    public function run(...$args)
    {
        foreach ($this->_executables as $executable) {
            call_user_func_array([$executable, 'run'], $args);
        }
    }
}
