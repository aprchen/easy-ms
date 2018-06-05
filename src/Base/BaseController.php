<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/26
 * Time: 下午1:01
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Base;


use EasyMS\Constants\Services;
use EasyMS\Exception\RuntimeException;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 * @package EasyMS\Base
 * @property Config $config
 * @property \Phalcon\Mvc\Dispatcher|\Phalcon\Mvc\DispatcherInterface $dispatcher;
 * @property \Phalcon\Mvc\Router|\Phalcon\Mvc\RouterInterface $router
 * @property \Phalcon\Mvc\Url|\Phalcon\Mvc\UrlInterface $url
 * @property \Phalcon\Http\Response\Cookies|\Phalcon\Http\Response\CookiesInterface $cookies
 * @property \Phalcon\Filter|\Phalcon\FilterInterface $filter
 * @property \Phalcon\Flash\Direct $flash
 * @property \Phalcon\Flash\Session $flashSession
 * @property \Phalcon\Session\Adapter\Files|\Phalcon\Session\Adapter|\Phalcon\Session\AdapterInterface $session
 * @property \Phalcon\Events\Manager $eventsManager
 * @property \Phalcon\Db\AdapterInterface $db
 * @property \Phalcon\Security $security
 * @property \Phalcon\Crypt $crypt
 * @property \Phalcon\Tag $tag
 * @property \Phalcon\Escaper|\Phalcon\EscaperInterface $escaper
 * @property \Phalcon\Annotations\Adapter\Memory|\Phalcon\Annotations\Adapter $annotations
 * @property \Phalcon\Mvc\Model\Manager|\Phalcon\Mvc\Model\ManagerInterface $modelsManager
 * @property \Phalcon\Cache\BackendInterface $modelsCache
 * @property \Phalcon\Mvc\Model\MetaData\Memory|\Phalcon\Mvc\Model\MetadataInterface $modelsMetadata
 * @property \Phalcon\Mvc\Model\Transaction\Manager $transactionManager
 * @property \Phalcon\Assets\Manager $assets
 * @property \Phalcon\DI|DiInterface $di
 * @property \Phalcon\Session\Bag $persistent
 * @property \Phalcon\Mvc\View|\Phalcon\Mvc\ViewInterface $view
 * @property \League\Fractal\Manager $fractalManager
 * @property \EasyMS\Fractal\Query\QueryParsers\PhqlQueryParser $phqlQueryParser
 * @property \EasyMS\Fractal\Query\QueryParsers\UrlQueryParser $urlQueryParser
 */
class BaseController extends Controller
{

    /**
     * @param $model
     * @param string $primaryKey
     * @param array $defaultConditions
     * @param string $key
     * @param string $val
     * @param bool $noLimit
     * @return \Phalcon\Mvc\Model\Query\Builder
     * $this->getUriBuilder(User::class,'')->getQuery()->execute()
     */
    public function getUriBuilder($model, $primaryKey = '',array $defaultConditions=[],$noLimit=false, $key=null,$val=null)
    {
        $default = $this->config->get(Services::URL_QUERY)->toArray();
        $params = $this->request->getQuery();
        try {
            if($noLimit){
                $default['limit']='';
            }
            if($key==null||$val==null){
                list($key,$val) = $default["sort"];
            }
            $arr = $this->urlQueryParser->createQuery($params, $default['limit'], $default['offset'], [$key=>$val], $defaultConditions,$noLimit);

        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage());
        }

        $builder = $this->phqlQueryParser->fromQuery($arr, $model, $primaryKey);
        return $builder;
    }
    /**
     * @param $sql
     * @param $param
     * @return bool|\Phalcon\Db\ResultInterface
     */
    public function executeSql($sql,$param){
        $result = $this->db->query( $sql,$param);
        return $result;
    }


    protected $fractal;

    public function onConstruct()
    {
        $this->fractal = $this->di->get(Services::FRACTAL_MANAGER);
    }


    protected function createArrayResponse($array, $key)
    {
        $response = [$key => $array];

        return $this->createResponse($response);
    }

    protected function createResponse($response)
    {
        return $response;
    }

    protected function createOkResponse()
    {
        $response = ['result' => 'OK'];

        return $this->createResponse($response);
    }

    protected function createItemOkResponse($item, $transformer, $resourceKey = null, $meta = null)
    {
        $response = ['result' => 'OK'];
        $response += $this->createItemResponse($item, $transformer, $resourceKey, $meta);

        return $this->createResponse($response);
    }

    protected function createItemResponse($item, $transformer, $resourceKey = null, $meta = null)
    {

        $resource = new Item($item, $transformer, $resourceKey);
        $data = $this->fractalManager->createData($resource)->toArray();
        $response = array_merge($data, $meta ? $meta : []);

        return $this->createResponse($response);
    }

    protected function createCollectionResponse($collection, $transformer, $resourceKey = null, $meta = null)
    {
        $resource = new Collection($collection, $transformer, $resourceKey);
        $data = $this->fractalManager->createData($resource)->toArray();
        $response = array_merge($data, $meta ?? []);

        return $this->createResponse($response);
    }

}