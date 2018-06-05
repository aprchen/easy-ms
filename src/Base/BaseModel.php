<?php

namespace EasyMS\Base;

use EasyMS\Constants\Services;
use Phalcon\Mvc\Model;

/**
 * Class BaseModel
 * @package EasyMS\Base
 */
class BaseModel extends Model
{
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="datetime", nullable=false)
     */
    public $gmtCreate;
    /**
     *
     * @var integer
     * @Column(type="datetime", nullable=false)
     */
    public $gmtModified;

    public function beforeCreate()
    {
        $this->gmtCreate = time();
        $this->gmtModified = $this->gmtCreate;
    }

    public function beforeUpdate()
    {
        $this->gmtModified = time();
    }

    /**
     * @param null $parameters
     * @return int
     */
    public static function count($parameters = null)
    {
        $res = self::find($parameters);
        if(isset($res)){
            return count($res->toArray());
        }
        return 0;
    }


    public function initialize()
    {
        $this->setReadConnectionService(Services::DB_SLAVE);

        $this->setWriteConnectionService(Services::DB);
    }
}
