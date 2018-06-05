<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午7:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace EasyMS\Middleware;

use EasyMS\Exception\ErrorCode;
use EasyMS\Exception\RuntimeException;
use EasyMS\Mapping\MiddlewareInterface;
use EasyMS\MicroApp;


class NotFoundMiddleware implements MiddlewareInterface
{
    public function beforeNotFound()
    {
        throw new RuntimeException(ErrorCode::GENERAL_NOT_FOUND);
    }


    /**
     * Calls the middleware
     *
     * @param MicroApp $app
     * @return bool
     */
    public function call(MicroApp $app)
    {
        return true;
    }
}