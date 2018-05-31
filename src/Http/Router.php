<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 下午1:29
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Http;


use Phalcon\Mvc\Micro\LazyLoader;
use Phalcon\Mvc\Router as BaseRouter;
use Phalcon\Mvc\RouterInterface;

class Router extends BaseRouter implements RouterInterface
{

    /**
     * @param array $controllers
     * {
     * "App\\Controller\\Collection\\TestCollection":
     *    {
     *        "prefix":"\/test",
     *        "group":"",
     *        "points":
     *              {
     *                  "test":
     *                      {
     *                          "method":"GET","name":"","path":"\/{id}","scopes":["unauthorized"]
     *                      }
     *              }
     *     }
     * }
     *
     * @return mixed
     */
    public function initRoutes(array $controllers) :array
    {
        $result = [];
        if(!empty($controllers)){
            foreach ($controllers as $class => $controller) {
                $points = $controller['points'] ?? [];
                if (!empty($points)) {
                    foreach ($points as $action => $point) {
                        $method = $point['method'];
                        $pattern = $point['path'] ;
                        $path = "$class:$action";
                        $route = $this->add($pattern, $path, $method);
                        $result[$route->getRouteId()] = [new LazyLoader($class), $action];
                    }
                }
            }
        }
        return $result;
    }
}