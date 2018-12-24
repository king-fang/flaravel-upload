<?php

namespace Flaravel\Upload;

use Illuminate\Support\Str;
use OSS\Core\OssException;
use OSS\OssClient;

class UploadOss implements UploadOssInterface
{
    private $bucketName;

    private $ossClient;

    private $endpoint;

    public function __construct()
    {
        if(config('upload.endpoint') == self::OSS_SERVICE)
        {
            $this->endpoint = config('upload.ossServer');
        }else if(config('upload.endpoint') == self::OSS_SERVERINTERNAL){
            $this->endpoint = config('upload.ossServerInternal');
        }else{
            $this->endpoint = config('upload.ossServer');
        }
        $this->bucketName = config('upload.BucketName');
        $this->ossClient = new OssClient(config('upload.AccessKeyId'),config('upload.AccessKeySecret'),$this->endpoint);
    }

    /**
     * 普通文件上传
     * @param  object $file 文件对象
     * @param  string $path 文件路径名称
     * @return array       返回OSS content
     * @throws \Exception
     */
    public function supload($file,$path = '/')
    {
        try {
            return $this->ossClient->uploadFile($this->bucketName,$path,$file);
        } catch (OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }

    /**
     * 文件删除
     * @param string $path 文件路径
     * @return bool|null
     * @throws \Exception
     */
    public function sdelete($path)
    {
        try {
            $path = Str::after($path,'com/');
            $res = $this->ossClient->deleteObject($this->bucketName,$path);
            if(isset($res['info']))
            {
                return true;
            }
            return false;
        } catch (OssException $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }
}
