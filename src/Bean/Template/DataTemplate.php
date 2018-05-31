<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:15
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Template;


use EasyMS\Helper\PhpHelper;
use Symfony\Component\Filesystem\Filesystem;

class DataTemplate
{

    /**
     * @var DataBean[]
     */
    protected $beans = [];


    public function addBeans(DataBean $bean)
    {
        $this->beans[] = $bean;
    }

    /**
     * apidoc js,json
     * @param string $file
     */
    public function getApiDocTemplate(string $file)
    {
        $f = new Filesystem();
        $type = PhpHelper::getExtension($file);
        if($type == 'json'){
            $head = "[";
            $foot = "]";
        }else{
            $head = "define({ \"api\": [";
            $foot = "] });";
        }
        if($f->exists($file)){
            $f->remove($file);
        }
        $f->appendToFile($file,$head);
        $count = count($this->beans);
        foreach ($this->beans as $key=>$bean) {
            if($key == $count-1){
                $f->appendToFile($file, $bean->toJson());
            }else{
                $f->appendToFile($file, $bean->toJson().',');
            }
        }
        $f->appendToFile($file,$foot);
    }

}