<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:24
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Template;


use EasyMS\Base\BaseBean;

class ProjectBean extends BaseBean
{

    /** @var string */
    protected $title = '';
    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $name ='';

    /**
     * @var string
     */
    protected $version = '0.0.0';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var bool
     */
    protected $sampleUrl = false;

    protected $defaultVersion = '0.0.0';

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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isSampleUrl(): bool
    {
        return $this->sampleUrl;
    }

    /**
     * @param bool $sampleUrl
     */
    public function setSampleUrl(bool $sampleUrl): void
    {
        $this->sampleUrl = $sampleUrl;
    }

    /**
     * @return string
     */
    public function getDefaultVersion(): string
    {
        return $this->defaultVersion;
    }

    /**
     * @param string $defaultVersion
     */
    public function setDefaultVersion(string $defaultVersion): void
    {
        $this->defaultVersion = $defaultVersion;
    }

}