<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/30
 * Time: 下午2:16
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Mapping;


use EasyMS\MicroApp;

interface MiddlewareInterface
{

    /**
     * Calls the middleware
     *
     * @param MicroApp $app
     */
    public function call(MicroApp $app);

}