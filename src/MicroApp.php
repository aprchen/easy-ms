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
use EasyMS\Boot\Boot;
use EasyMS\Constants\Services;
use EasyMS\Exception\ErrorCode;
use EasyMS\Exception\RuntimeException;
use EasyMS\Http\Response;
use EasyMS\Http\Router;
use EasyMS\Mapping\BootstrapInterface;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Mvc\Micro;
use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

class MicroApp extends Micro
{

    const MODE_DEV = "development";

    const MODE_PRO = "production";

    private $mode = self::MODE_DEV;

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
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode(string $mode): void
    {
        $this->mode = $mode;
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
            /** 扩展检查 */
            if (!extension_loaded('phalcon')) {
                exit("Please install phalcon extension. See https://phalconphp.com/zh/ \n");
            }
            if (count($this->boots) > 0) {
                $bootstrap = new Boot($this->boots);
                $bootstrap->run($this, $this->getDI(), $this->getConfig());
            }
            $this->notFound(function () {
                throw new RuntimeException(ErrorCode::DATA_NOT_FOUND);
            });
            parent::handle($uri);
            /** @var Response $response */
            $response = $this->getDI()->getShared(Services::RESPONSE);
            // 返回值类型
            $returnedValue = $this->getReturnedValue();
            if ($returnedValue !== null) {
                $response->setJsonContent($returnedValue);
            }
        } catch (\Throwable $t) {
            $di = $this->_dependencyInjector ?? new MicroDi();
            $response = $di->getShared(Services::RESPONSE);
            if (!$response || !$response instanceof Response) {
                $response = new Response();
            }
            $debug = isset($this->getConfig()->debug) ? $this->getConfig()->debug->enable : false;
            $response->setErrorContent($t, $debug);
        } finally {
            /** @var $response Response */
            if (!$response->isSent()) {
                $response->send();
            }
        }
    }

    public function getConfig()
    {
        return MicroDi::getDefault()->getShared(Services::CONFIG);
    }

    /**
     *  echo "<pre>";
     * $router = $this->getDI()->getShared(Services::ROUTER);
     * $route = $router->add("/a");
     * $this->_handlers[$route->getRouteId()] = [new IndexController(),"index"];
     */
    public function scan()
    {
        if ($this->mode == self::MODE_DEV) {
            $co = new ControllerAnnotationResource([]);
            $co->addScanNamespace(['App\\Controller']);
            $co->getDefinitions();
            $controllers = ControllerCollector::getCollector();
        }else{
            $cache = $this->getCache()->get("controllers");
            if(empty($cache)){
                $co = new ControllerAnnotationResource([]);
                $co->addScanNamespace(['App\\Controller']);
                $co->getDefinitions();
                $controllers = ControllerCollector::getCollector();
                $this->getCache()->save("controllers",json_encode($controllers));
            }else{
                $controllers = json_decode($cache,true);
            }
        }

        /** @var Router $router */
        $router = $this->getDI()->getShared(Services::ROUTER);
        foreach ($controllers as $class => $controller) {
            $prefix = $controller['prefix'];
            $points = $controller['points'] ?? [];
            if (!empty($points)) {
                foreach ($points as $action => $point) {
                    $method = $point['method'];
                    $pattern = empty($prefix) ? $point['path'] : $prefix . $point['path'];
                    $path = "$class:$action";
                    $route = $router->add($pattern, $path, $method);
                    $this->_handlers[$route->getRouteId()] = [new $class, $action];
                }
            }
        }
    }

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


}