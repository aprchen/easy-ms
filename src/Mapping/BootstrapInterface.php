<?php

namespace EasyMS\Mapping;

use EasyMS\MicroApp;
use Phalcon\Config;
use Phalcon\DiInterface;

/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午4:14
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */
interface BootstrapInterface {

    public function run(MicroApp $app, DiInterface $di, Config $config);

}