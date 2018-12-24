<?php

namespace Flaravel\Upload;

interface UploadOssInterface  extends UploadInterface
{
    //外网
    const OSS_SERVICE = 1;
    //内网
    const OSS_SERVERINTERNAL = 2;

    /**
     * 普通对象上传
     */
    public function supload($file,$path = '');


    /**
     * 刪除文件
     * @param  string $path 文件路徑
     * @return bool
     */
    public function sdelete($path);
}
