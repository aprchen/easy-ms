<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:15
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Template;


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
     * @param string $path
     * @param string $type
     */
    public function getApiDocTemplate(string $path,$type = 'js')
    {
        $f = new Filesystem();
        if($type == 'js'){
            $head = "[";
            $foot = "]";
            $filename = "api_data.json";
        }else{
            $head = "define({ \"api\": [";
            $foot = "] });";
            $filename = "api_data.js";
        }
        $file = $path . $filename;
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