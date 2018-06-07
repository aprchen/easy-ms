<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/25
 * Time: 上午11:44
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Template;

use Symfony\Component\Filesystem\Filesystem;

class ProjectTemplate
{

    const FILE_NAME = "api_project.js";

    public function getTemplate(ProjectBean $bean,string $path){
        $f = new Filesystem();
        $head = "define(";
        $foot = ");";
        $file = $path.DIRECTORY_SEPARATOR.self::FILE_NAME;
        if($f->exists($file)){
            $f->remove($file);
        }
        $data = $bean->toArray();
        $json = json_encode(array_filter($data),JSON_UNESCAPED_UNICODE);
        $f->appendToFile($file,$head);
        $f->appendToFile($file,$json);
        $f->appendToFile($file,$foot);
    }

}