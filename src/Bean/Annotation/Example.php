<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:04
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Annotation;

use EasyMS\Base\BaseBean;
use EasyMS\Constants\ExampleType as ET;

/**
 *
 * Example(
 *     header=ET::HEADER_SUCCESS,
 *     type=ET::TYPE_JSON,
 *     title="Error-Response:",
 *     content="HTTP/1.1 404 Not Found
 *     {
 *          "error": "UserNotFound"
 *      }"
 * )
 * Class Example
 * @package EasyMS\Bean\Annotation
 * @Annotation
 * @Target("METHOD")
 */
class Example
{

    const KEY = "examples";

    /**
     * @var string
     */
    public $header = ET::HEADER_SUCCESS;
    /**
     * @var string
     */
    public $title = '';
    /**
     * @var string
     */
    public $content = '';

    public $type = ET::TYPE_JSON;



    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     */
    public function setHeader(string $header): void
    {
        $this->header = $header;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function toArray(): array
    {
        $res = [];
        $res[self::KEY]['title'] = $this->getTitle();
        $res[self::KEY]['content'] = $this->getContent();
        $res[self::KEY]['type'] = $this->getType();
        return $res;
    }

}