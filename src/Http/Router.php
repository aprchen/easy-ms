<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 下午1:29
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Http;


use Phalcon\Mvc\Router as BaseRouter;
use Phalcon\Mvc\RouterInterface;

class Router extends BaseRouter implements RouterInterface
{
    public function getRoutes()
    {
       return parent::getRoutes(); // TODO: Change the autogenerated stub
    }
}