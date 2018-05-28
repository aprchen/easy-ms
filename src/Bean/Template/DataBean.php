<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2018/5/28
 * Time: 上午11:23
 * @author April2 <ott321@yeah.net>
 */

namespace EasyMS\Bean\Template;

use EasyMS\Base\BaseBean;
use EasyMS\Constants\Methods;

class DataBean extends BaseBean
{
    /**
     * @var string
     */
    protected $type ='get';

    protected $url = '';

    protected $title = '';

    protected $version = '0.0.0';

    protected $name = '';

    protected $group = '';

    protected $filename = '';

    protected $groupTitle = '';

    protected $permission = [];

    protected $description = '';

    protected $sampleRequest = [['uri'=>'']];

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
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
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
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getGroupTitle(): string
    {
        return $this->groupTitle;
    }

    /**
     * @param string $groupTitle
     */
    public function setGroupTitle(string $groupTitle): void
    {
        $this->groupTitle = $groupTitle;
    }

    /**
     * @return array
     */
    public function getPermission(): array
    {
        return $this->permission;
    }

    /**
     * @param array $permission
     */
    public function setPermission(array $permission): void
    {
        $this->permission[] = $permission;
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
     * @return array
     */
    public function getSampleRequest(): array
    {
        return $this->sampleRequest;
    }

    /**
     * @param array $sampleRequest
     */
    public function setSampleRequest(array $sampleRequest): void
    {
        $this->sampleRequest = $sampleRequest;
    }


}