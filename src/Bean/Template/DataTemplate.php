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

    const FILE_NAME = "api_data.js";

    /**
     * @var DataBean[]
     */
    protected $beans = [];


    public function addBeans(DataBean $bean)
    {
        $this->beans[] = $bean;
    }

    /**
     * @param string $path
     */
    public function getApiDocTemplate(string $path)
    {
        $f = new Filesystem();
        $head = "define({ \"api\": [";
        $foot = "] });";
        $file = $path.DIRECTORY_SEPARATOR.self::FILE_NAME;
        if($f->exists($file)){
            $f->remove($file);
        }
        $f->appendToFile($file,$head);
        $count = count($this->beans);
        foreach ($this->beans as $key=>$bean) {
            $data = $bean->toArray();
            $data = array_filter($data);
            if(isset($data['examples'])){
                $examples = $data['examples'];
                unset($data['examples']);
                $data = array_merge($data,$examples);
            }
            $json = json_encode($data,JSON_UNESCAPED_UNICODE);
            if($key == $count-1){
                $f->appendToFile($file, $json);
            }else{
                $f->appendToFile($file, $json.',');
            }
        }
        $f->appendToFile($file,$foot);
    }

}