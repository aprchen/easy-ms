<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/23
 * Time: 下午1:54
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Exception;

class RuntimeException extends \RuntimeException
{
    protected $developerInfo;
    protected $userInfo;

    public function __construct($code, $message = null, $developerInfo = null, $userInfo = null)
    {
        parent::__construct($message, $code);

        $this->developerInfo = $developerInfo;
        $this->userInfo = $userInfo;
    }

    public function getDeveloperInfo()
    {
        return $this->developerInfo;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }
}