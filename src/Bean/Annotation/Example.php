<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:04
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

/**
 * Class Example
 * @package EasyMS\Bean\Annotation
 * @Annotation
 */
class Example
{
    /**
     * @var string
     */
    public $stats;
    /**
     * @var string
     */
    public $json;

    /**
     * @return string
     */
    public function getStats(): string
    {
        return $this->stats;
    }

    /**
     * @param string $stats
     */
    public function setStats(string $stats): void
    {
        $this->stats = $stats;
    }

    /**
     * @return string
     */
    public function getJson(): string
    {
        return $this->json;
    }

    /**
     * @param string $json
     */
    public function setJson(string $json): void
    {
        $this->json = $json;
    }
}