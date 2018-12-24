<?php

namespace Flaravel\Upload;

use Illuminate\Support\Manager;

/**
 * 文件上传服务
 */
class UploadManager extends Manager
{
    public function createLocalDriver()
    {
         return $this->bindComponent(new UploadLocal());
    }

    public function createOssDriver()
    {
         return $this->bindComponent(new UploadOss());
    }

    public function getDefaultDriver()
    {
        return $this->app['config']['upload.driver'];
    }


    protected function bindComponent($driver)
    {
        return new Upload($driver);
    }
}
