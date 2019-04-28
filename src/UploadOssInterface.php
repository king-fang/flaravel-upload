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


    /**
     * 列举oss 文件
     * @param string $prefix 你要列出的文件所在的目录名
     * @param string $marker 从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表
     * @param string $delimiter 为行使文件夹功能的分割符号，如 /
     * @param number $maxkeys max-keys用于限定此次返回object的最大数
     */
    public function getOssFileList($config);
}
