<?php

namespace EasyMS\Mapping;
/**
 * Resource Interface
 */
interface ResourceInterface
{
    /**
     * 获取已解析的配置beans
     *
     * @return array
     */
    public function getDefinitions();
}
