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
use EasyMS\Http\ErrorHelper;
use EasyMS\Http\FormatHelper;
use EasyMS\Http\Request;
use EasyMS\Http\Response;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager as EventsManager;

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
    }
}