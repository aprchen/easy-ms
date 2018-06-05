<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 下午5:42
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Constants;


class ScopeRoles
{

    /**
     * 管理员
     */
    const ADMINISTRATOR = "administrator";
    /**
     * 普通用户
     */
    const ORDINARY = "ordinary";
    /**
     * 客户端用户
     */
    const MANAGER = "manager";
    /**
     * 未登录用户
     */
    const UNAUTHORIZED= 'unauthorized';

    /**
     * 所有
     */
    const ALL = [self::ADMINISTRATOR,self::MANAGER,self::ORDINARY,self::UNAUTHORIZED];

}