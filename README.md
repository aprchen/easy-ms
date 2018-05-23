# 说明
使用 phalcon Micro 搭建 restful api

# 使用方法

```php
composer require sl/micro-service

```

入口文件示例
```php
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
require_once BASE_PATH . '/vendor/autoload.php';
$app = new MicroApp();
$app->setConfigPath(BASE_PATH."/config.ini");
$app->setBoots(
    new CollectionBootstrap(),
    new ServiceBootstrap()
);
$app->handle();

```