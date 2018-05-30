<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午7:18
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace EasyMS\Middleware;

use EasyMS\Mapping\MiddlewareInterface;
use EasyMS\MicroApp;
use Phalcon\Events\Event;

class OptionsResponseMiddleware implements MiddlewareInterface
{
    public function beforeHandleRoute(Event $event, MicroApp $app)
    {

        if($app->request->isHead()){  //心跳检测
            $app->response->setJsonContent([
                'result' => 'OK',
            ]);
            return false;
        }
        if ($app->request->isOptions()) {
            $app->response->setJsonContent([
                'result' => 'OK',
            ]);
            return false;
        }
    }

    public function call(MicroApp $api)
    {
        return true;
    }

}