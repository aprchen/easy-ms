<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/23
 * Time: 下午1:41
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS;

use EasyMS\Bean\Collector\ControllerCollector;
use EasyMS\Bean\Resource\ControllerAnnotationResource;
use EasyMS\Bean\Template\DataBean;
use EasyMS\Bean\Template\DataTemplate;
use EasyMS\Boot\Boot;
use EasyMS\Constants\Services;
use EasyMS\Exception\ErrorCode;
use EasyMS\Exception\RuntimeException;
use EasyMS\Helper\PhpHelper;
use EasyMS\Http\Response;
use EasyMS\Http\Router;
use EasyMS\Mapping\BootstrapInterface;
use EasyMS\Middleware\CORSMiddleware;
use EasyMS\Middleware\NotFoundMiddleware;
use EasyMS\Middleware\OptionsResponseMiddleware;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;
use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

class MicroApp extends Micro
{

    /** @var BootstrapInterface[] */
    protected $boots = [];


    /**
     * @param BootstrapInterface[] $boots
     */
    public function setBoots(BootstrapInterface ... $boots): void
    {
        $this->boots = $boots;
    }

    /**
     * @param Config $config
     * @return \Phalcon\Di\ServiceInterface
     */
    public function setConfig(Config $config)
    {
        return $this->getDI()->setShared(Services::CONFIG, $config);
    }

    /**
     * @return MicroDi|DiInterface
     */
    public function getDI()
    {
        if (!$this->_dependencyInjector instanceof DiInterface) {
            $this->_dependencyInjector = new MicroDi();
        }
        return $this->_dependencyInjector;
    }

    public function handle($uri = null)
    {
        try {
            PhpHelper::checkExtension('phalcon'); //扩展检查
            if (count($this->boots) > 0) {
                $bootstrap = new Boot($this->boots);
                $bootstrap->run($this, $this->getDI(), $this->getConfig());
            }
            $this->initRoutes();
            parent::handle($uri);
            $response = $this->getResponse();
            $returned = $this->getReturnedValue();
            if($returned !== null){
                if(is_object($returned)  && method_exists($returned,'send')){ //如果是其他第三方的response 直接输出
                    $returned->send();
                }else{
                    $response->setJsonContent($returned);
                }
            }
        } catch (\Throwable $t) {
            $response = $this->getResponse();
            $debug = isset($this->getConfig()->debug) ? $this->getConfig()->debug->enable : false;
            $response->setErrorContent($t, $debug);
        } finally {
            if (!$response->isSent()) {
                $response->send();
            }
        }
    }

    public static function getEventManager(): Manager
    {
        return MicroDi::getDefault()->getShared(Services::EVENTS_MANAGER);
    }


    public function initMiddleware(){
        /** @var Manager $manager */
        $manager = $this->getDI()->getShared(Services::EVENTS_MANAGER);
        $manager->attach('micro',new NotFoundMiddleware());
        $manager->attach('micro',new CORSMiddleware());
        $manager->attach('micro',new OptionsResponseMiddleware());
        $this->setEventsManager($manager);
    }


    private function initRoutes()
    {
        $controllers = $this->getControllers();
        /** @var Router $router */
        $router = $this->getDI()->getShared(Services::ROUTER);
        $this->_handlers = $router->initRoutes($controllers);
    }


    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        $response = $this->getDI()->getShared(Services::RESPONSE);
        if (!$response || !$response instanceof Response) {
            $response = new Response();
        }
        return $response;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return MicroDi::getDefault()->getShared(Services::CONFIG);
    }

    /**
     * @return array
     */
    public function getControllers(): array
    {

        try {
            $namespace = $this->getConfig()->application->controllerNamespace ?? null;
            if(!$namespace){
               throw new RuntimeException(ErrorCode::POST_DATA_NOT_PROVIDED,'Warning: controllerNamespace parameters not provided or invalid');
            }
            $dev = $this->getConfig()->application->dev ?? false;
            if ($dev) {
                $co = new ControllerAnnotationResource();
                $co->addScanNamespace([$namespace]);
                $co->getDefinitions(); //扫描
                $controllers = ControllerCollector::getCollector();
            } else {
                $cache = $this->getCache()->get("controllers");
                if (empty($cache)) {
                    $co = new ControllerAnnotationResource();
                    $co->addScanNamespace([$namespace]);
                    $co->getDefinitions();//扫描
                    $controllers = ControllerCollector::getCollector();
                    $this->getCache()->save("controllers", json_encode($controllers));
                } else {
                    $controllers = json_decode($cache, true);
                }
            }
            return $controllers;
        }catch (\Throwable $t){
            trigger_error($t->getMessage().$t->getTraceAsString());
            return[];
        }
    }

    /**
     * @return File
     */
    protected function getCache()
    {
        // Cache the file for 2 days
        $frontendOptions = [
            "lifetime" => 172800,
        ];
        $output = new FrontOutput($frontendOptions);
        $dir = $this->getConfig()->application->cacheDir;
        return new File($output, ['cacheDir' => $dir]);
    }

    /**
     * @param string $path
     */
    public function generateApiDocData(string $path)
    {
        $data = $this->getControllers();
        $dataTemplate = new DataTemplate();
        $host = $this->getConfig()->host->self;
        foreach ($data as $file=> $collection){
            foreach ($collection['points'] as $method=>$point){
                $bean = new DataBean();
                $bean->setFilename($file);
                $bean->setGroup($collection['group']);
                $bean->setGroupTitle($collection['group']);
                $bean->setType(PhpHelper::arrayToLowString($point['method']));
                $bean->setPermission(['name'=>PhpHelper::arrayToLowString($point['scopes'])]);
                $bean->setUrl($collection['prefix'].$point['path']);
                $bean->setName($point['name']);
                $bean->setTitle($point['name']);
                $bean->setDescription($point['description']);
                $bean->setVersion($point['version']);
                $bean->setSampleRequest(['uri'=>$host.$collection['prefix'].$point['path']]);
                $dataTemplate->addBeans($bean);
            }
        }
        $dataTemplate->getApiDocTemplate($path);
    }


}