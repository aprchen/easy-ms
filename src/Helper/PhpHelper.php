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
                    trigger_error($message[$extension], E_USER_WARNING);
                    break;
                }
            }
        } elseif (!extension_loaded($extension)) {
            trigger_error($message[$extension], E_USER_WARNING);
        }
    }


    public static function arrayToLowString(array $array)
    {
        return strtolower(implode(',', $array));
    }

    public static function getExtension(string $filename):string
    {
        return substr(strrchr($filename, '.'), 1);
    }


    public static function replaceDoubleSlashes(string $url){
        return str_replace("//", "/", $url);
    }

}