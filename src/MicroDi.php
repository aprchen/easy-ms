<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/23
 * Time: 下午1:45
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS;

use EasyMS\Constants\Services;
use EasyMS\Fractal\CustomSerializer;
use EasyMS\Fractal\Query\QueryParsers\PhqlQueryParser;
use EasyMS\Fractal\Query\QueryParsers\UrlQueryParser;
use League\Fractal\Manager as FractalManager;
use EasyMS\Http\ErrorHelper;
use EasyMS\Http\FormatHelper;
use EasyMS\Http\Request;
use EasyMS\Http\Response;
use EasyMS\Http\Router;
use Phalcon\Di\FactoryDefault;
use Phalcon\Escaper;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Url;

class MicroDi extends FactoryDefault
{
    public function __construct()
    {
        parent::__construct();
        $this->setShared(Services::REQUEST, new Request);
        $this->setShared(Services::RESPONSE, new Response);
        $this->setShared(Services::FORMAT_HELPER, new FormatHelper);
        $this->setShared(Services::ERROR_HELPER, new ErrorHelper);
        $this->setShared(Services::EVENTS_MANAGER, new EventsManager());
        $this->setShared(Services::ROUTER,new Router());
        $this->setShared(Services::PHQL_QUERY_PARSER,new PhqlQueryParser());
        $this->setShared(Services::URL_QUERY_PARSER,new UrlQueryParser());
        $this->setShared(Services::FRACTAL_MANAGER, function () {
            $fractal = new FractalManager;
            $fractal->setSerializer(new CustomSerializer);
            return $fractal;
        });
        $this->set(Services::ESCAPER,new Escaper());
        $this->set(Services::URL,function (){
            $url = new Url();
            $url->setBaseUri('/');
            return $url;
        });
    }
}