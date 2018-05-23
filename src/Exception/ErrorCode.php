<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午6:25
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace EasyMS\Exception;


class ErrorCode
{

    /**
     * 通用
     */
    const GENERAL_SYSTEM = 1010;
    const GENERAL_NOT_IMPLEMENTED = 1020;
    const GENERAL_NOT_FOUND = 1030;


    /**
     * 用户认证
     */
    const AUTH_INVALID_ACCOUNT_TYPE = 2010;
    const AUTH_LOGIN_FAILED = 2020;
    const AUTH_TOKEN_INVALID = 2030;
    const AUTH_SESSION_EXPIRED = 2040;
    const AUTH_SESSION_INVALID = 2050;

    /**
     * 访问控制
     */
    const ACCESS_DENIED = 3010;

    /**
     * 客户端错误
     */
    const DATA_FAILED = 4010;
    const DATA_NOT_FOUND = 4020;
    const WECHAT_NOT_FOUND = 4030;
    /**
     * 商品不存在
     */
    const GOODS_NOT_FOUND =4041;

    /**
     * 业务提示
     */
    const MUST_ATTENTION = 4050;
    const NO_BALANCE = 4060;
    /**
     * 文件错误
     */

    const SIZE_OVER = 4070;
    const TYPE_ERROR = 4080;

    /**
     * 服务器错误
     */
    const POST_DATA_NOT_PROVIDED = 5010;
    const POST_DATA_INVALID = 5020;
    const FILE_FAILED = 5030;

    /**
     * 微信公众号已存在
     */
    const WECHAT_IS_EXIST = 5040;

    /**
     * 任务加锁
     */
    const TASK_IS_BUSY = 5050;

}