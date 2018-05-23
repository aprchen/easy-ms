<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/23
 * Time: 下午1:41
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS;

use EasyMS\Boot\Boot;
use EasyMS\Constants\Services;
use EasyMS\Exception\ErrorCode;
use EasyMS\Exception\RuntimeException;
use EasyMS\Http\Response;
use EasyMS\Mapping\BootstrapInterface;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;
use Phalcon\Mvc\Micro;

class MicroApp extends Micro
{

    /** @var BootstrapInterface[] */
    protected $boots = [];

    /**
     * @var string
     */
    protected $configPath;

    /**
     * @var string
     */
    protected $appPath;

    /**
     * @param BootstrapInterface[] $boots
     */
    public function setBoots(BootstrapInterface ... $boots): void
    {
        $this->boots = $boots;
    }

    /**
     * @param string $configPath
     */
    public function setConfigPath(string $configPath): void
    {
        $this->configPath = $configPath;
    }

    /**
     * @param string $appPath
     */
    public function setAppPath(string $appPath): void
    {
        $this->appPath = $appPath;
    }

    public function handle($uri = null)
    {
        try {
            /** 扩展检查 */
            if (!extension_loaded('phalcon')) {
                exit("Please install phalcon extension. See https://phalconphp.com/zh/ \n");
            }

            if(!$this->_dependencyInjector instanceof DiInterface){
                $this->_dependencyInjector = new MicroDi();
            }

            if(count($this->boots)>0){
                $config = $this->getConfig();
                $bootstrap = new Boot($this->boots);
                $bootstrap->run($this, $this->_dependencyInjector, $config);
            }

            parent::handle($uri);

            /** @var Response $response */
            $response = $this->_dependencyInjector->getShared(Services::RESPONSE);
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
            $debug =  isset($this->getConfig()->debug) ? $this->getConfig()->debug->enable : false;
            $response->setErrorContent($t, $debug);
        } finally {
            /** @var $response Response */
            if (!$response->isSent()) {
                $response->send();
            }
        }
    }

    public function getConfig(){
        if(empty($this->configPath)){
            $this->configPath = __DIR__.'/default.config.ini';
        }
        if (!is_readable($this->configPath)) {
            throw new RuntimeException(ErrorCode::GENERAL_SYSTEM, 'Unable to read config from ' . $this->configPath);
        }
        /** @var \Phalcon\Config $config */
        $config = new Ini($this->configPath, INI_SCANNER_NORMAL);
        return $config;
    }

}