<?php
namespace EasyMS\Helper;


use function Composer\Autoload\includeFile;
use Symfony\Component\Filesystem\Filesystem;

class PhpHelper
{
    /**
     * Checks if a particular extension is loaded and if not it marks
     * the tests skipped
     *
     * @param mixed $extension
     */
    public static function checkExtension($extension)
    {
        $message = function ($ext) {
            sprintf('Warning: %s extension is not loaded', $ext);
        };
        if (is_array($extension)) {
            foreach ($extension as $ext) {
                if (!extension_loaded($ext)) {
                    trigger_error($message[$extension],E_USER_WARNING);
                    break;
                }
            }
        } elseif (!extension_loaded($extension)) {
            trigger_error($message[$extension],E_USER_WARNING);
        }
    }


    public static function arrayToLowString(array $array){
        return strtolower(implode(',',$array));
    }


    public static function saveDataToFile(string $file,array $data){
        $f = new Filesystem();
        if($f->exists($file)){
            $f->remove($file);
        }
        $text='<?php $array =  '.var_export($data,true).';';
        $f->appendToFile($file,$text);
    }


    public static function getDataToFile(string $file){
        $f = new Filesystem();
        if(!$f->exists($file)){
            trigger_error(sprintf("Waring: %s can`t find !"));
        }
        include realpath($file);
        if(isset($array)){
            return $array;
        }
        return false;
    }

}